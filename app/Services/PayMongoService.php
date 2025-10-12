<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PayMongoService
{
    protected $secretKey;

    public function __construct()
    {
        $this->secretKey = env('PAYMONGO_SECRET_KEY');
    }

    // Create a payment intent
    public function createPaymentIntent($amount, $currency = 'PHP')
    {
        $response = Http::withBasicAuth($this->secretKey, '')
            ->post('https://api.paymongo.com/v1/payment_intents', [
                'data' => [
                    'attributes' => [
                        'amount' => $amount * 100, // PayMongo uses cents
                        'payment_method_allowed' => ['card', 'gcash', 'paymaya'],
                        'payment_method_options' => ['card' => ['request_three_d_secure' => 'automatic']],
                        'currency' => $currency,
                    ]
                ]
            ]);

        return $response->json();
    }

    // Attach payment method
    public function attachPaymentMethod($paymentIntentId, $paymentMethodId)
    {
        $response = Http::withBasicAuth($this->secretKey, '')
            ->post("https://api.paymongo.com/v1/payment_intents/{$paymentIntentId}/attach", [
                'data' => [
                    'attributes' => [
                        'payment_method' => $paymentMethodId
                    ]
                ]
            ]);

        return $response->json();
    }
}
