<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{
    // Create Checkout Session
    public function createCheckout(Request $request)
    {
        // Validate that 'amount' and 'payment_status' are present.
        $request->validate([
            'reservation_id' => 'required|exists:reservation_details,id',
            'payment_status' => 'required|in:partial,paid' // Validate payment_status
        ]);

        // Fetch the reservation.
        $reservation = \Illuminate\Support\Facades\DB::table('reservation_details')->find($request->reservation_id);

        if (!$reservation) {
            return back()->with('error', 'Reservation not found.');
        }

        $paymentStatus = $request->input('payment_status');
        $totalAmount = $reservation->total_amount ?? $reservation->amount ?? 0;

        if ($totalAmount <= 0) {
            return back()->with('error', 'Invalid reservation amount.');
        }

        $amountToCharge = 0;
        if ($paymentStatus === 'paid') {
            // If a partial payment was made, charge the balance. Otherwise, charge the full amount.
            $amountToCharge = ($reservation->payment_status === 'partial' || $reservation->payment_status === 'pending') ? $reservation->balance : $totalAmount;
        } elseif ($paymentStatus === 'partial') {
            // Use the pre-calculated downpayment from the reservation.
            $amountToCharge = $reservation->downpayment;
        }

        if ($amountToCharge < 25) {
            return back()->with('error', 'Payment amount must be at least ₱25.');
        }

        // PayMongo requires the amount in centavos.
        $amount = $amountToCharge * 100;

        $response = Http::withBasicAuth(env('PAYMONGO_SECRET_KEY'), '')
            ->post('https://api.paymongo.com/v1/checkout_sessions', [
                'data' => [
                    'attributes' => [
                        'billing' => [
                            'name' => auth()->user()->name ?? 'Guest',
                            'email' => auth()->user()->email ?? 'guest@example.com',
                            'phone' => auth()->user()->mobileNo ?? null,
                        ],
                        'line_items' => [
                            [
                                'currency' => 'PHP',
                                'amount' => $amount,
                                'name' => 'Lelo’s Resort',
                                'quantity' => 1
                            ]
                        ],
                        'payment_method_types' => ['gcash'],
                        'success_url' => url('/payment/success?reservation_id=' . $request->reservation_id),
                        'cancel_url' => url('/payment/cancel'),
                        // Add reservation_id and payment_status to metadata.
                        'metadata' => [
                            'reservation_id' => $request->reservation_id,
                            'payment_status' => $paymentStatus, // This will be 'partial' or 'paid'
                        ]
                    ]
                ]
            ]);

        $checkout = $response->json();

        // Check for successful checkout URL creation
        if (isset($checkout['data']['attributes']['checkout_url'])) {
            // Store the checkout_session_id in your database to link it to the reservation
            \Illuminate\Support\Facades\DB::table('reservation_details')
                ->where('id', $request->reservation_id)
                ->update(['paymongo_checkout_id' => $checkout['data']['id']]);

            return redirect($checkout['data']['attributes']['checkout_url']);
        } else {
            // Log the detailed error from PayMongo for debugging
            Log::error('PayMongo Checkout Error:', $checkout);
            $errorMessage = $checkout['errors'][0]['detail'] ?? 'Unable to create checkout session. Please try again.';
            return back()->with('error', $errorMessage);
        }
    }

    // Handle Webhook
    public function handleWebhook(Request $request)
{
    try {
        // Log webhook attempt
        Log::info('=== PAYMONGO WEBHOOK RECEIVED ===');
        
        // Check all possible header formats
        $paymongoSignature = $request->header('paymongo-signature');

        if (!$paymongoSignature) {
            $allHeaders = collect($request->headers->all())->mapWithKeys(function ($value, $key) {
                return [strtolower($key) => $value[0] ?? ''];
            });
            
            Log::error('PayMongo Signature missing. Available headers:', $allHeaders->toArray());
            return response()->json(['error' => 'Missing signature'], 400);
        }

        Log::info('Paymongo Signature found: ' . substr($paymongoSignature, 0, 50) . '...');

        $webhookSecretKey = env('PAYMONGO_WEBHOOK_SECRET_KEY');
        
        if (empty($webhookSecretKey)) {
            Log::error('PAYMONGO_WEBHOOK_SECRET_KEY is empty or not set');
            return response()->json(['error' => 'Webhook secret not configured'], 500);
        }

        $payloadBody = $request->getContent();
        $payload = $request->all();

        Log::info('Webhook payload type: ' . ($payload['data']['attributes']['type'] ?? 'unknown'));

        // Parse the signature - NEW FORMAT: t=timestamp,te=signature,li=livemode
        $timestamp = '';
        $signatureV1 = '';

        $signatureParts = explode(',', $paymongoSignature);
        foreach ($signatureParts as $part) {
            $part = trim($part);
            if (str_starts_with($part, 't=')) {
                $timestamp = substr($part, 2);
            } elseif (str_starts_with($part, 'te=')) {
                $signatureV1 = substr($part, 3);
            }
        }

        Log::info('Signature parsed:', [
            'timestamp' => $timestamp,
            'signature_length' => strlen($signatureV1),
            'has_timestamp' => !empty($timestamp),
            'has_signature' => !empty($signatureV1)
        ]);

        if (empty($timestamp) || empty($signatureV1)) {
            Log::error('Invalid signature format', [
                'signature' => $paymongoSignature,
                'timestamp_found' => !empty($timestamp),
                'signature_found' => !empty($signatureV1)
            ]);
            return response()->json(['error' => 'Invalid signature format'], 400);
        }

        $signedPayload = $timestamp . '.' . $payloadBody;
        $computedSignature = hash_hmac('sha256', $signedPayload, $webhookSecretKey);

        if (!hash_equals($computedSignature, $signatureV1)) {
            Log::error('Invalid signature', [
                'computed_length' => strlen($computedSignature),
                'received_length' => strlen($signatureV1),
                'timestamp' => $timestamp,
                'payload_length' => strlen($payloadBody)
            ]);
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        Log::info('Signature verified successfully');

        // Process the event
        $eventType = data_get($payload, 'data.attributes.type');
        Log::info("Processing event type: {$eventType}");

        if ($eventType === 'payment.paid') {
            return $this->handlePaymentPaid($payload);
        } elseif ($eventType === 'source.chargeable') {
            return $this->handleSourceChargeable($payload);
        } else {
            Log::info("Unhandled event type: {$eventType}");
        }

        return response()->json(['status' => 'ok']);

    } catch (\Exception $e) {
        Log::error('Webhook processing error: ' . $e->getMessage());
        return response()->json(['error' => 'Internal server error'], 500);
    }
}

private function handlePaymentPaid($payload)
{
    Log::info('Processing payment.paid event');
    
    // Get the payment data
    $paymentData = data_get($payload, 'data.attributes.data');
    Log::info('Payment data:', $paymentData);

    // Get reservation_id from payment metadata
    $reservationId = data_get($paymentData, 'attributes.metadata.reservation_id');

    if (!$reservationId) {
        Log::error('reservation_id not found in payment.paid webhook metadata', [
            'payment_id' => data_get($paymentData, 'id'),
            'metadata' => data_get($paymentData, 'attributes.metadata'),
        ]);
        return response()->json(['error' => 'reservation_id not found in metadata'], 400);
    }

    Log::info("Looking for reservation with ID: {$reservationId}");

    $reservation = \Illuminate\Support\Facades\DB::table('reservation_details')->where('id', $reservationId)->first();

    if ($reservation) {
        Log::info("Reservation found", [
            'reservation_id' => $reservation->id,
            'current_payment_status' => $reservation->payment_status,
            'current_reservation_status' => $reservation->reservation_status
        ]);

        // Determine payment type based on amount comparison
        $paymentType = $this->determinePaymentType($reservation, $payload);
        
        $updateData = [
            'payment_status' => $paymentType,
            'reservation_status' => 'reserved',
            'updated_at' => now()
        ];

        $result = \Illuminate\Support\Facades\DB::table('reservation_details')
            ->where('id', $reservation->id)
            ->update($updateData);

        if ($result) {
            Log::info("✅ Reservation ID {$reservation->id} successfully updated. Payment status: {$paymentType}");
            
            // Verify the update
            $updatedReservation = \Illuminate\Support\Facades\DB::table('reservation_details')->where('id', $reservation->id)->first();
            Log::info("✅ Update verified", [
                'new_payment_status' => $updatedReservation->payment_status,
                'new_reservation_status' => $updatedReservation->reservation_status
            ]);

            // Send email notification upon successful payment
            try {
                $accommodationIds = json_decode($updatedReservation->accomodation_id, true) ?? [];
                $roomQuantities = json_decode($updatedReservation->room_quantities, true) ?? [];

                $accommodationDetails = [];
                if (!empty($accommodationIds)) {
                    $accommodations = \Illuminate\Support\Facades\DB::table('accomodations')->whereIn('accomodation_id', $accommodationIds)->get()->keyBy('accomodation_id');
                    foreach ($roomQuantities as $id => $qty) {
                        if (isset($accommodations[$id])) {
                            $accommodationDetails[] = [
                                'name' => $accommodations[$id]->accomodation_name,
                                'quantity' => $qty,
                            ];
                        }
                    }
                }

                Mail::to($updatedReservation->email)->send(new \App\Mail\PendingReservation($updatedReservation, $accommodationDetails, $updatedReservation->amount, $updatedReservation->downpayment));
                Log::info("✅ Reservation confirmation email sent to {$updatedReservation->email} for reservation ID {$updatedReservation->id}");
            } catch (\Exception $e) {
                Log::error("❌ Failed to send reservation email for ID: {$updatedReservation->id}", ['error' => $e->getMessage()]);
            }
        } else {
            Log::error("❌ Database update failed for reservation ID: {$reservation->id}");
        }

    } else {
        Log::error("❌ Reservation not found for checkout ID: {$checkoutSessionId}");
        
        // Debug: log available reservations
        $reservations = \Illuminate\Support\Facades\DB::table('reservation_details')
            ->select('id', 'paymongo_checkout_id', 'payment_status')
            ->whereNotNull('paymongo_checkout_id')
            ->get();
            
        Log::info("Available reservations with checkout IDs:", $reservations->toArray());
    }

    return response()->json(['status' => 'processed']);
}

private function determinePaymentType($reservation, $payload)
{
    // Get amount paid from PayMongo payload (in centavos)
    $amountPaid = data_get($payload, 'data.attributes.data.attributes.amount') 
                 ?? data_get($payload, 'data.attributes.amount', 0);
    
    // Convert to pesos (PayMongo amounts are in centavos)
    $amountPaidInPesos = $amountPaid / 100;
    
    // Get total amount from reservation
    $totalAmount = $reservation->total_amount ?? $reservation->amount ?? 0;

    Log::info("Amount comparison:", [
        'amount_paid_centavos' => $amountPaid,
        'amount_paid_pesos' => $amountPaidInPesos,
        'total_amount' => $totalAmount,
        'reservation_id' => $reservation->id
    ]);

    // If we don't have total amount, default to paid
    if ($totalAmount <= 0) {
        Log::warning('Total amount is zero or not found, defaulting to paid');
        return 'paid';
    }

    // Check if paid amount equals or exceeds total amount (with small tolerance for floating point)
    $tolerance = 0.01; // 1 centavo tolerance
    if (abs($amountPaidInPesos - $totalAmount) <= $tolerance || $amountPaidInPesos >= $totalAmount) {
        Log::info("Full payment detected: Paid {$amountPaidInPesos} vs Total {$totalAmount}");
        return 'paid';
    } 
    // Check if paid amount is exactly half (common downpayment scenario)
    elseif (abs($amountPaidInPesos - ($totalAmount / 2)) <= $tolerance) {
        Log::info("50% downpayment detected: Paid {$amountPaidInPesos} vs Total {$totalAmount}");
        return 'partial';
    }
    // Check if paid amount is less than total (partial payment)
    elseif ($amountPaidInPesos < $totalAmount) {
        Log::info("Partial payment detected: Paid {$amountPaidInPesos} vs Total {$totalAmount}");
        return 'partial';
    }

    // Default to paid if all checks fail
    Log::warning('Could not determine payment type with amount comparison, defaulting to paid');
    return 'paid';
}

private function handleSourceChargeable($payload)
{
    Log::info('Processing source.chargeable event');
    
    $sourceId = data_get($payload, 'data.id');
$checkoutSessionId = data_get($payload, 'data.attributes.checkout_id');
    
    if (!$checkoutSessionId) {
        Log::error('paymongo_checkout_id not found in source.chargeable payload');
        return response()->json(['error' => 'paymongo_checkout_id not found'], 400);
    }

    Log::info("Source chargeable for checkout ID: {$checkoutSessionId}");

    $reservation = \Illuminate\Support\Facades\DB::table('reservation_details')->where('paymongo_checkout_id', $checkoutSessionId)->first();
    
    if ($reservation) {
        Log::info("Marking reservation as processing for checkout ID: {$checkoutSessionId}");
        
        \Illuminate\Support\Facades\DB::table('reservation_details')
            ->where('id', $reservation->id)
            ->update([
                'payment_status' => 'processing',
                'updated_at' => now()
            ]);
    }

    return response()->json(['status' => 'processing']);
}

}