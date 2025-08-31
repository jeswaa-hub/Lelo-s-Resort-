<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use DatePeriod;
use DateInterval;
use Carbon\CarbonPeriod;
use App\Models\User;
use App\Models\Package;
use App\Models\Accomodation;
use App\Models\Transaction;
use App\Models\Reservation;
use App\Models\Feedback;
use DateTime;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewReservationNotification;


class ReservationController extends Controller
{
    public function reservation()
    {
        return view('Reservation.reservation');
    }
    public function fetchAddons()
    {
        $addons = DB::table('addons')->get();
        return view('Reservation.addons', ['addons' => $addons]);
    }
    public function checkAccommodationAvailability(Request $request)
{
    try {
        $checkIn = Carbon::parse($request->checkIn);
        $checkOut = Carbon::parse($request->checkOut);

        // 1. Get all active accommodations
        $accommodations = DB::table('accomodations')
            ->where('accomodation_status', 'available')
            ->get();

        // 2. Find accommodations with ANY reservations during dates
        $bookedIds = DB::table('reservation_details')
            ->where('reservation_check_out_date', '>', $checkIn)
            ->where('reservation_check_in_date', '<', $checkOut)
            ->whereIn('reservation_status', ['reserved', 'checked-in'])
            ->pluck('accomodation_id')
            ->unique();

        // 3. Filter out ANY accommodation with reservations
        $available = $accommodations->reject(function ($accom) use ($bookedIds) {
            return $bookedIds->contains($accom->accomodation_id);
        });

        return response()->json([
            'available_accommodations' => $available->map(function ($accom) {
                return [
                    'id' => $accom->accomodation_id,
                    'name' => $accom->accomodation_name,
                    'total_quantity' => $accom->quantity,
                    'available_quantity' => $accom->quantity // All rooms available
                ];
            })
        ]);

    } catch (\Exception $e) {
        return response()->json(['error' => 'Server error'], 500);
    }
}
// One Day Stay
public function fetchAccomodationData()
    {
        // Get the authenticated user
        $user = auth()->user();

        $accomodations = DB::table('accomodations')
            ->get();
        $activities = DB::table('activitiestbl')->get();
        $transactions = DB::table('transaction')->first();
        $adultTransaction = Transaction::where('type', 'adult')->select('entrance_fee')->first();
        $kidTransaction = Transaction::where('type', 'kid')->select('entrance_fee')->first();
        
        return view('Reservation.selectPackage', [
            'accomodations' => $accomodations, 
            'activities' => $activities, 
            'transactions' => $transactions,
            'adultTransaction' => $adultTransaction,
            'kidTransaction' => $kidTransaction
        ]);
    }
// Stay In
public function selectPackageCustom(Request $request)
{
    // Get the authenticated user
    $user = auth()->user();
    
    $checkIn = $request->query('checkIn');
    $checkOut = $request->query('checkOut');

    // Validate dates
    if ($checkIn && $checkOut) {
        try {
            $start = Carbon::parse($checkIn);
            $end = Carbon::parse($checkOut);
            
            if ($end <= $start) {
                return back()->with('error', 'Check-out date must be after check-in date');
            }
            
            // Optional: Add validation for past dates
            if ($start < Carbon::today()) {
                return back()->with('error', 'Check-in date cannot be in the past');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Invalid date format');
        }
    }

    // Get all accommodations (including quantity information)
    $accommodations = DB::table('accomodations')
        ->get();

    // For each accommodation, set is_available based on quantity
    $accommodations->each(function ($accomodation) {
        // Mark as unavailable if quantity is 0
        $accomodation->is_available = ($accomodation->quantity > 0);
    });

    // Get activities and transactions more efficiently
    $activities = DB::table('activitiestbl')->get();
    $transaction = DB::table('transaction')->first();

    return view('Reservation.selectPackageCustom', [
        'user' => $user,
        'accomodations' => $accommodations,
        'check_in_date' => $checkIn,
        'check_out_date' => $checkOut,
        'activities' => $activities,
        'transactions' => $transaction,
    ]);
}
public function OnedayStay(Request $request)
{
    try {
        $request->validate([
            'reservation_check_in_date' => 'required|date|after_or_equal:today',
            'reservation_check_out_date' => 'required|date|after_or_equal:reservation_check_in_date',
            'reservation_check_in' => 'required|date_format:H:i',
            'reservation_check_out' => 'required|date_format:H:i',
            'number_of_adults' => 'required|integer|min:1',
            'number_of_children' => 'required|integer|min:0',
            'special_request' => 'nullable|string|max:500',
            'quantity' => 'required|integer|min:1'
        ], [
            'number_of_adults.required' => 'At least one adult must be included.',
            'number_of_adults.min' => 'At least one adult must be included.',
            'number_of_children.min' => 'Number of children cannot be negative.',
            'quantity.required' => 'Please select number of rooms.',
            'quantity.min' => 'Please select at least one room.',
        ]);
    } catch (\Illuminate\Validation\ValidationException $e) {
        return redirect()->back()->withErrors($e->validator)->withInput();
    }
    
    // Validate selected accommodations
    $selectedAccommodationIds = (array) $request->input('accomodation_id');
    if (empty($selectedAccommodationIds)) {
        return redirect()->back()->with('error', 'Please select at least one accommodation.');
    }

    // If single value is received, convert it to array
    if (!is_array($selectedAccommodationIds)) {
        $selectedAccommodationIds = [$selectedAccommodationIds];
    }

    // Get logged-in user information
    $user = Auth::user();

    // Get dates and quantity
    $checkInDate = $request->input('reservation_check_in_date');
    $checkOutDate = $request->input('reservation_check_out_date');
    $requestedQuantity = (int) $request->input('quantity', 1);

    // Check availability using getAvailableQuantities
    $availabilityRequest = new Request([
        'checkIn' => $checkInDate,
        'checkOut' => $checkOutDate
    ]);
    
    $availabilityResponse = $this->getAvailableQuantities($availabilityRequest);
    $availabilityData = json_decode($availabilityResponse->getContent(), true);
    
    // Check if there was an error in availability check
    if (isset($availabilityData['error'])) {
        return redirect()->back()->with('error', 'Error checking availability: ' . $availabilityData['error']);
    }
    
    // Check availability for each selected accommodation
    foreach ($selectedAccommodationIds as $accommodationId) {
        $availableRooms = $availabilityData[$accommodationId] ?? 0;
        
        if ($requestedQuantity > $availableRooms) {
            // Get accommodation name for better error message
            $accommodation = DB::table('accomodations')
                ->where('accomodation_id', $accommodationId)
                ->first();
            
            $accommodationName = $accommodation ? $accommodation->accomodation_name : "Accommodation ID: $accommodationId";
            
            return redirect()->back()->with('error', 
                "Not enough rooms available for {$accommodationName}. " .
                "Available: {$availableRooms}, Requested: {$requestedQuantity}"
            );
        }
    }

    // Get accommodations data
    $accommodations = DB::table('accomodations')
        ->whereIn('accomodation_id', $selectedAccommodationIds)
        ->get();
    
    if ($accommodations->isEmpty()) {
        return redirect()->back()->with('error', 'Selected accommodations not found.');
    }
    
    $accommodationPrice = (float) $accommodations->sum('accomodation_price') * $requestedQuantity;

    // Handle activity selection (store as JSON if multiple)
    $activityIds = $request->input('activity_id', []);
    $selectedActivityId = count($activityIds) > 1 ? json_encode($activityIds) : (count($activityIds) === 1 ? $activityIds[0] : null);

    // Compute entrance fee
    $numAdults = (int) $request->input('number_of_adults', 0);
    $numChildren = (int) $request->input('number_of_children', 0);
    
    // Get entrance fees from transaction table based on session
    $session = $request->input('session', 'morning');
    $adultFee = Transaction::where('type', 'adult')
        ->where('session', $session)
        ->value('entrance_fee') ?? 0;
    $kidFee = Transaction::where('type', 'kid')
        ->where('session', $session)
        ->value('entrance_fee') ?? 0;
    
    // Calculate total entrance fee
    $entranceFee = ($numAdults * $adultFee) + ($numChildren * $kidFee);

    // Compute total price
    $totalPrice = $entranceFee + $accommodationPrice;

    // Generate unique reservation ID
    $reservationId = $this->generateReservationId();

    // Save reservation directly to database
    $reservationData = [
        'reservation_id' => $reservationId,
        'user_id' => Auth::id(),
        'name' => $user->name,
        'email' => $user->email,
        'mobileNo' => $user->mobileNo,
        'address' => $user->address,
        'accomodation_id' => json_encode($selectedAccommodationIds),
        'activity_id' => $selectedActivityId,
        'reservation_check_in' => $request->input('reservation_check_in'),
        'reservation_check_out' => $request->input('reservation_check_out'),
        'reservation_check_in_date' => $checkInDate,
        'reservation_check_out_date' => $checkOutDate,
        'special_request' => $request->input('special_request'),
        'quantity' => $requestedQuantity,
        'total_guest' => $numAdults + $numChildren,
        'number_of_adults' => $numAdults,
        'number_of_children' => $numChildren,
        'amount' => $totalPrice,
        'payment_status' => 'pending',
        'reservation_status' => 'pending',
        'created_at' => now(),
        'updated_at' => now(),
    ];

    // Insert reservation into database
    DB::table('reservation_details')->insert($reservationData);

    // Create reservation object for email notification
    $reservation = (object) $reservationData;

    // Retrieve admin email and send notification
    $adminEmail = DB::table('settings')->where('key', 'admin_email')->value('value');
    Mail::to($adminEmail)->send(new NewReservationNotification($reservation));

    // Log reservation creation
    Log::info('One Day Stay Reservation Created Successfully', [
        'reservation_id' => $reservationId,
        'user_id' => Auth::id(),
        'user_info' => [
            'name' => $user->name,
            'email' => $user->email,
            'mobileNo' => $user->mobileNo,
            'address' => $user->address,
        ],
        'reservation_data' => $reservationData,
        'accommodation_details' => [
            'selected_ids' => $selectedAccommodationIds,
            'accommodation_price' => $accommodationPrice
        ],
        'activity_details' => [
            'activity_ids' => $activityIds,
            'selected_activity_id' => $selectedActivityId
        ],
        'guest_details' => [
            'adults' => $numAdults,
            'children' => $numChildren,
            'total_guests' => $numAdults + $numChildren
        ],
        'price_details' => [
            'accommodation_price' => $accommodationPrice,
            'entrance_fee' => $entranceFee,
            'total_price' => $totalPrice
        ],
        'timestamp' => now()->toDateTimeString()
    ]);

    return redirect()->route('summary')->with('success', 'Reservation processed successfully, wait for the approval of the staff to process your reservation. Thank you for your reservation!');
}
public function StayInPackages(Request $request)
{
    try {
        $request->validate([
            'reservation_check_in_date' => 'required|date|after_or_equal:today',
            'reservation_check_out_date' => 'required|date|after_or_equal:reservation_check_in_date',
            'reservation_check_in' => 'required|date_format:H:i',
            'reservation_check_out' => 'required|date_format:H:i',
            'number_of_adults' => 'required|integer|min:1',
            'number_of_children' => 'required|integer|min:0',
            'special_request' => 'nullable|string|max:500',
            'quantity' => 'required|integer|min:1',
            'total_amount' => 'required|numeric|min:0'
        ], [
            'number_of_adults.required' => 'At least one adult must be included.',
            'number_of_adults.min' => 'At least one adult must be included.',
            'number_of_children.min' => 'Number of children cannot be negative.',
            'quantity.required' => 'Please select number of rooms.',
            'quantity.min' => 'Please select at least one room.',
            'total_amount.required' => 'Total amount is required.',
            'total_amount.numeric' => 'Total amount must be a valid number.',
            'total_amount.min' => 'Total amount cannot be negative.',
        ]);
    } catch (\Illuminate\Validation\ValidationException $e) {
        return redirect()->back()->withErrors($e->validator)->withInput();
    }

    // Validate selected accommodations
    $selectedAccommodationIds = $request->input('accomodation_id', []);
    if (empty($selectedAccommodationIds)) {
        return redirect()->back()->with('error', 'Please select at least one accommodation.');
    }

    // Get logged-in user information
    $user = Auth::user();

    // Calculate number of nights
    $checkInDate = new \DateTime($request->input('reservation_check_in_date'));
    $checkOutDate = new \DateTime($request->input('reservation_check_out_date'));
    $numberOfNights = $checkInDate->diff($checkOutDate)->days;

    // Validate that there's at least 1 night
    if ($numberOfNights < 1) {
        return redirect()->back()->with('error', 'Check-out date must be at least 1 day after check-in date.');
    }

    // Fetch accommodation prices
    $accommodations = DB::table('accomodations')
        ->whereIn('accomodation_id', $selectedAccommodationIds)
        ->get();
    
    // Calculate accommodation price: room price × quantity × number of nights
    $baseAccommodationPrice = (float) $accommodations->sum('accomodation_price');
    $quantity = (int) $request->input('quantity', 1);
    $accommodationPrice = $baseAccommodationPrice * $quantity * $numberOfNights;

    // Get the total amount calculated from frontend
    $frontendTotalAmount = (float) $request->input('total_amount', 0);

    // Verify that frontend calculation matches backend calculation
    if (abs($accommodationPrice - $frontendTotalAmount) > 0.01) { // Allow for small floating point differences
        Log::warning('Price calculation mismatch', [
            'backend_calculated' => $accommodationPrice,
            'frontend_calculated' => $frontendTotalAmount,
            'base_price' => $baseAccommodationPrice,
            'quantity' => $quantity,
            'nights' => $numberOfNights,
            'reservation_data' => $request->all()
        ]);
        
        return redirect()->back()->with('error', 'Price calculation error. Please refresh the page and try again.');
    }

    // Handle activity selection (store as JSON if multiple)
    $activityIds = $request->input('activity_id', []);
    $selectedActivityId = count($activityIds) > 1 ? json_encode($activityIds) : (count($activityIds) === 1 ? $activityIds[0] : null);

    // Compute entrance fee
    $numAdults = (int) $request->input('number_of_adults', 0);
    $numChildren = (int) $request->input('number_of_children', 0);

    // Use the verified total price (accommodation price includes nights calculation)
    $totalPrice = $accommodationPrice;

    // Generate unique reservation ID
    $reservationId = $this->generateReservationId();

    // Save reservation directly to database
    $reservationData = [
        'reservation_id' => $reservationId,
        'user_id' => Auth::id(),
        'name' => $user->name,
        'email' => $user->email,
        'mobileNo' => $user->mobileNo,
        'address' => $user->address,
        'accomodation_id' => json_encode($selectedAccommodationIds),
        'activity_id' => $selectedActivityId,
        'reservation_check_in' => $request->input('reservation_check_in'),
        'reservation_check_out' => $request->input('reservation_check_out'),
        'reservation_check_in_date' => $request->input('reservation_check_in_date'),
        'reservation_check_out_date' => $request->input('reservation_check_out_date'),
        'special_request' => $request->input('special_request'),
        'quantity' => $quantity,
        'total_guest' => $numAdults + $numChildren,
        'number_of_adults' => $numAdults,
        'number_of_children' => $numChildren,
        'amount' => $totalPrice,
        'payment_status' => 'pending',
        'reservation_status' => 'pending',
        'created_at' => now(),
        'updated_at' => now(),
    ];

    // Insert reservation into database
    DB::table('reservation_details')->insert($reservationData);

    // Create reservation object for email notification
    $reservation = (object) $reservationData;

    // Retrieve admin email and send notification
    $adminEmail = DB::table('settings')->where('key', 'admin_email')->value('value');
    Mail::to($adminEmail)->send(new NewReservationNotification($reservation));

    // Log reservation creation
    Log::info('Reservation Created Successfully', [
        'reservation_id' => $reservationId,
        'user_id' => Auth::id(),
        'user_info' => [
            'name' => $user->name,
            'email' => $user->email,
            'mobileNo' => $user->mobileNo,
            'address' => $user->address,
        ],
        'reservation_data' => $reservationData,
        'accommodation_details' => [
            'selected_ids' => $selectedAccommodationIds,
            'base_accommodation_price' => $baseAccommodationPrice,
            'accommodation_price_with_nights' => $accommodationPrice,
            'quantity' => $quantity,
            'number_of_nights' => $numberOfNights
        ],
        'activity_details' => [
            'activity_ids' => $activityIds,
            'selected_activity_id' => $selectedActivityId
        ],
        'guest_details' => [
            'adults' => $numAdults,
            'children' => $numChildren,
            'total_guests' => $numAdults + $numChildren
        ],
        'price_details' => [
            'base_price_per_room' => $baseAccommodationPrice,
            'quantity' => $quantity,
            'number_of_nights' => $numberOfNights,
            'accommodation_price' => $accommodationPrice,
            'total_price' => $totalPrice,
            'frontend_calculated' => $frontendTotalAmount
        ],
        'timestamp' => now()->toDateTimeString()
    ]);

    // Determine success message based on reservation status
    $successMessage = 'Reservation processed successfully, wait for the approval of the staff to process your reservation. Thank you for your reservation!';
    
    if ($reservationData['reservation_status'] === 'on-hold') {
        $successMessage = 'Reservation #' . $reservationId . ' is being on-hold, please pay the required downpayment to complete the process.';
    } elseif ($reservationData['reservation_status'] === 'reserved') {
        $successMessage = 'Reservation #' . $reservationId . ' process successfully!';
    }

    return redirect()->route('summary')->with('success', $successMessage);
}
public function getAvailableQuantities(Request $request)
{
    try {
        $checkIn = $request->get('checkIn');
        $checkOut = $request->get('checkOut');
        
        if (!$checkIn || !$checkOut) {
            return response()->json(['error' => 'Missing dates'], 400);
        }
        
        $checkInFormatted = Carbon::parse($checkIn)->format('Y-m-d');
        $checkOutFormatted = Carbon::parse($checkOut)->format('Y-m-d');
        
        Log::info('=== AVAILABILITY CHECK ===', [
            'checkIn' => $checkInFormatted,
            'checkOut' => $checkOutFormatted,
            'isOneDayStay' => $checkInFormatted === $checkOutFormatted
        ]);
        
        $availableQuantities = [];
        $accommodations = DB::table('accomodations')->get();
        
        foreach ($accommodations as $accommodation) {
            $accommodationId = $accommodation->accomodation_id;
            $totalRooms = (int)($accommodation->quantity ?? 0);
            
            // For one-day stays, we need to adjust the date comparison
            if ($checkInFormatted === $checkOutFormatted) {
                // ONE-DAY STAY LOGIC
                $reservationQuery = DB::table('reservation_details')
                    ->whereIn('reservation_status', ['reserved', 'checked-in'])
                    ->where(function($query) use ($checkInFormatted) {
                        $query->where(function($q) use ($checkInFormatted) {
                            // Reservations that span the selected date
                            $q->where('reservation_check_in_date', '<=', $checkInFormatted)
                              ->where('reservation_check_out_date', '>', $checkInFormatted);
                        })->orWhere(function($q) use ($checkInFormatted) {
                            // Reservations that start and end on the selected date
                            $q->where('reservation_check_in_date', '=', $checkInFormatted)
                              ->where('reservation_check_out_date', '=', $checkInFormatted);
                        });
                    })
                    ->where(function($jsonQuery) use ($accommodationId) {
                        // Accommodation ID matching logic
                        $jsonQuery->whereJsonContains('accomodation_id', (string)$accommodationId)
                                  ->orWhereJsonContains('accomodation_id', (int)$accommodationId)
                                  ->orWhere('accomodation_id', '=', (string)$accommodationId)
                                  ->orWhere('accomodation_id', '=', (int)$accommodationId)
                                  ->orWhere('accomodation_id', 'LIKE', '%"'.$accommodationId.'"%')
                                  ->orWhere('accomodation_id', 'LIKE', '%['.$accommodationId.']%');
                    });
            } else {
                // MULTI-DAY STAY LOGIC (your existing logic)
                $reservationQuery = DB::table('reservation_details')
                    ->whereIn('reservation_status', ['reserved', 'checked-in'])
                    ->where(function($query) use ($checkInFormatted, $checkOutFormatted) {
                        $query->where(function($q) use ($checkInFormatted, $checkOutFormatted) {
                            $q->where('reservation_check_in_date', '<', $checkOutFormatted)
                              ->where('reservation_check_out_date', '>', $checkInFormatted);
                        });
                    })
                    ->where(function($jsonQuery) use ($accommodationId) {
                        $jsonQuery->whereJsonContains('accomodation_id', (string)$accommodationId)
                                  ->orWhereJsonContains('accomodation_id', (int)$accommodationId)
                                  ->orWhere('accomodation_id', '=', (string)$accommodationId)
                                  ->orWhere('accomodation_id', '=', (int)$accommodationId)
                                  ->orWhere('accomodation_id', 'LIKE', '%"'.$accommodationId.'"%')
                                  ->orWhere('accomodation_id', 'LIKE', '%['.$accommodationId.']%');
                    });
            }
            
            $reservationRecords = $reservationQuery->get();
            $bookedFromReservations = (int)$reservationQuery->sum('quantity');
            
            // WALKIN QUERY with consistent date logic
            if ($checkInFormatted === $checkOutFormatted) {
                // ONE-DAY STAY LOGIC for walk-ins
                $walkinQuery = DB::table('walkin_guests')
                    ->where('accomodation_id', $accommodationId)
                    ->whereIn('reservation_status', ['reserved', 'checked-in'])
                    ->where(function($query) use ($checkInFormatted) {
                        $query->where(function($q) use ($checkInFormatted) {
                            $q->where('reservation_check_in_date', '<=', $checkInFormatted)
                              ->where('reservation_check_out_date', '>', $checkInFormatted);
                        })->orWhere(function($q) use ($checkInFormatted) {
                            $q->where('reservation_check_in_date', '=', $checkInFormatted)
                              ->where('reservation_check_out_date', '=', $checkInFormatted);
                        });
                    });
            } else {
                // MULTI-DAY STAY LOGIC for walk-ins
                $walkinQuery = DB::table('walkin_guests')
                    ->where('accomodation_id', $accommodationId)
                    ->whereIn('reservation_status', ['reserved', 'checked-in'])
                    ->where(function($query) use ($checkInFormatted, $checkOutFormatted) {
                        $query->where(function($q) use ($checkInFormatted, $checkOutFormatted) {
                            $q->where('reservation_check_in_date', '<', $checkOutFormatted)
                              ->where('reservation_check_out_date', '>', $checkInFormatted);
                        });
                    });
            }
                
            $walkinRecords = $walkinQuery->get();
            $bookedFromWalkins = (int)$walkinQuery->sum('quantity');
            
            $totalBooked = $bookedFromReservations + $bookedFromWalkins;
            $availableRooms = max(0, $totalRooms - $totalBooked);
            
            // DETAILED DEBUG LOGGING
            Log::info("ACCOMMODATION DEBUG", [
                'id' => $accommodationId,
                'name' => $accommodation->accomodation_name,
                'total_rooms' => $totalRooms,
                'reservations_found' => $reservationRecords->count(),
                'walkins_found' => $walkinRecords->count(),
                'booked_reservations' => $bookedFromReservations,
                'booked_walkins' => $bookedFromWalkins,
                'total_booked' => $totalBooked,
                'available' => $availableRooms,
                'is_one_day_stay' => $checkInFormatted === $checkOutFormatted
            ]);
            
            $availableQuantities[$accommodationId] = $availableRooms;
        }
        
        return response()->json($availableQuantities);
        
    } catch (\Exception $e) {
        Log::error('Availability Check Error', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

    public function paymentProcess($reservationId = null)
{
    // Get the specific reservation by ID or get the latest reservation for the logged-in user
    if ($reservationId) {
        $reservationDetails = DB::table('reservation_details')
            ->where('reservation_id', $reservationId)
            ->where('user_id', Auth::id())
            ->first();
    } else {
        $reservationDetails = DB::table('reservation_details')
            ->where('user_id', Auth::id())
            ->latest('created_at')
            ->first();
    }

    // If no reservation is found, return error
    if (!$reservationDetails) {
        return back()->with('error', 'No reservation found. Please complete the reservation first.');
    }

    // Convert stdClass to array for consistency
    $reservationDetails = (array) $reservationDetails;

    $packages = Package::all();

    // Ensure accommodation IDs are properly handled
    $accomodationIds = isset($reservationDetails['accomodation_id']) 
        ? json_decode($reservationDetails['accomodation_id'], true) 
        : [];

    // Fetch accommodation details
    $accomodations = DB::table('accomodations')
        ->whereIn('accomodation_id', $accomodationIds)
        ->get();

    // Calculate total accommodation price based on quantity and number of nights
    $baseAccomodationPrice = $accomodations->sum('accomodation_price');
    $quantity = $reservationDetails['quantity'] ?? 1;
    
    // Calculate number of nights from reservation dates
    $checkInDate = new \DateTime($reservationDetails['reservation_check_in_date']);
    $checkOutDate = new \DateTime($reservationDetails['reservation_check_out_date']);
    $numberOfNights = $checkInDate->diff($checkOutDate)->days;
    
    // Ensure at least 1 night for calculation
    $numberOfNights = max(1, $numberOfNights);
    
    // Calculate total accommodation price: base price × quantity × nights
    $totalAccomodationPrice = $baseAccomodationPrice * $quantity * $numberOfNights;

    // Get entrance fee from transaction table (if needed for display)
    $adultTransaction = DB::table('transaction')->where('type', 'adult')->first();
    $kidTransaction = DB::table('transaction')->where('type', 'kid')->first();
    
    // Calculate entrance fee based on guests (if applicable)
    $adultFee = $adultTransaction ? $adultTransaction->entrance_fee : 0;
    $kidFee = $kidTransaction ? $kidTransaction->entrance_fee : 0;
    
    $totalEntranceFee = ($reservationDetails['number_of_adults'] * $adultFee) + 
                       ($reservationDetails['number_of_children'] * $kidFee);

    return view('Reservation.paymentProcess', compact(
        'reservationDetails', 
        'packages', 
        'totalEntranceFee', 
        'totalAccomodationPrice', 
        'accomodations',
        'numberOfNights',
        'baseAccomodationPrice'
    ));
}

    public function summary(){
        return view('Reservation.summary');
    }

    public function EventsReservation(){
        return view('Reservation.Events_Reservation');
    }

    public function fetchUserData(){
        $user = User::find(Auth::user()->id);
        return $user;
    }
    
public function saveReservationDetails(Request $request) 
{
    $userId = Auth::id();
    if (!$userId) {
        return redirect()->route('login')->with('error', 'Login first.');
    }
        
    // Retrieve reservation details from session instead of database
    $reservationDetails = session('reservation_details');

    if (!$reservationDetails) {
        return redirect()->route('selectPackage')->with('error', 'No reservation details found. Please start the reservation process again.');
    }

    // Fetch user details automatically (assuming they are stored in Auth or another source)
    $user = Auth::user();
    $reservationDetails['name'] = $user->name ?? 'Guest';
    $reservationDetails['email'] = $user->email ?? null;
    $reservationDetails['mobileNo'] = $user->mobileNo ?? null;
    $reservationDetails['address'] = $user->address ?? null;

    // Update session with new details
    session(['reservation_details' => $reservationDetails]);

    // Retrieve related package and accommodations
    $selectedPackage = Package::find($reservationDetails['package_id'] ?? null);
    $accommodationIds = json_decode($reservationDetails['accomodation_id'] ?? '[]', true);
    $accommodations = DB::table('accomodations')->whereIn('accomodation_id', $accommodationIds)->get();
    $activityIds = json_decode($reservationDetails['activity_id'] ?? '[]', true);
    $activities = DB::table('activitiestbl')->whereIn('id', $activityIds)->get();

    return redirect()->route('paymentProcess')->with([
        'success' => 'Reservation details stored successfully.',
        'selectedPackage' => $selectedPackage,
        'accommodations' => $accommodations,
        'activities' => $activities
    ]);
}
    
    public function getSessionTimes(Request $request) {
        $session = $request->query('session');

        // Get session times and entrance fee from transaction table
        $transaction = \App\Models\Transaction::where('session', $session)->first();

        if ($transaction) {
            $start_time = $transaction->start_time;
            $end_time = $transaction->end_time;
            $entrance_fee = $transaction->entrance_fee;
        } else {
            // Default values if no session found
            $start_time = null;
            $end_time = null;
            $entrance_fee = null;
        }
        $adultTransaction = Transaction::where('type', 'adult')
        ->where('session', $session)
        ->first();
        
        $kidTransaction = Transaction::where('type', 'kid')
            ->where('session', $session)
            ->first();

        return response()->json([
            'start_time' => $start_time,
            'end_time' => $end_time,
            'entrance_fee' => $entrance_fee,
            'adultFee' => $adultTransaction->entrance_fee,
            'kidFee' => $kidTransaction->entrance_fee
        ]);
    }


    public function SessionTimeOnly(Request $request) {
        $session = $request->query('session');
        // Get session times and entrance fee from transaction table
        $transaction = \App\Models\Transaction::where('session', $session)->first();
        
        if ($transaction) {
            $start_time = $transaction->start_time;
            $end_time = $transaction->end_time;
        } else {
            // Default values if no session found
            $start_time = null;
            $end_time = null;
        }

        return response()->json([
            'start_time' => $start_time,
            'end_time' => $end_time
        ]);
    }
    private function isDateAvailable($date)
    {
        return !Reservation::where('reservation_check_in_date', $date)
            ->orWhere('reservation_check_out_date', $date)
            ->exists();
    }


public function savePaymentProcess(Request $request)
{
    $userId = Auth::id();
    if (!$userId) {
        return redirect()->route('login')->with('error', 'Login first.');
    }

    // Validate only the required fields
    $request->validate([
        'upload_payment' => 'required|image|mimes:jpeg,png,jpg',
        'reference_num' => 'required|string|size:13',
        'balance' => 'required|numeric',
        'downpayment' => 'required|numeric|min:0' // Downpayment is a numeric amount
    ]);

    // Get the latest reservation for the user
    $reservation = DB::table('reservation_details')
        ->where('user_id', $userId)
        ->latest('created_at')
        ->first();

    if (!$reservation) {
        return redirect()->back()->with('error', 'No reservation found.');
    }

    // Get the payment amount
    $downpaymentAmount = str_replace(['₱', ' ', ','], '', $request->input('downpayment'));
    $balance = str_replace(['₱', ' ', ','], '', $request->input('balance'));
    
    // Determine if it's full payment or partial downpayment
    $isFullPayment = ($downpaymentAmount >= $reservation->amount);
    
    // Set payment status based on payment amount
    $paymentStatus = $isFullPayment ? 'paid' : 'partial';

    $data = [
        'reference_num' => $request->input('reference_num'),
        'downpayment' => $downpaymentAmount, // Store the actual amount paid
        'balance' => $balance,
        'payment_status' => $paymentStatus,
        'updated_at' => now()
    ];

    // If partial payment, set reservation status to on-hold
    if (!$isFullPayment) {
        $data['reservation_status'] = 'on-hold';
    } else {
        // If full payment, set reservation status to reserved
        $data['reservation_status'] = 'reserved';
    }

    // Handle file upload for proof of payment
    if ($request->hasFile('upload_payment')) {
        if (isset($reservation->upload_payment) && $reservation->upload_payment) {
            Storage::disk('public')->delete($reservation->upload_payment);
        }

        // Store new proof of payment
        $proofOfPaymentPath = $request->file('upload_payment')->store('payments', 'public');
        $data['upload_payment'] = $proofOfPaymentPath;
    }

    // Update the reservation with payment details
    DB::table('reservation_details')
        ->where('user_id', $userId)
        ->where('id', $reservation->id)
        ->update($data);

    // Get the updated reservation to check the status
    $updatedReservation = DB::table('reservation_details')
        ->where('id', $reservation->id)
        ->first();

    // Determine success message based on reservation status
    $successMessage = '';
    if ($updatedReservation->reservation_status === 'on-hold') {
        $successMessage = 'Downpayment of ₱' . number_format($downpaymentAmount, 2) . ' submitted successfully. Reservation #' . $updatedReservation->reservation_id . ' is on hold. Please pay the remaining balance to complete your reservation.';
    } else if ($updatedReservation->reservation_status === 'reserved') {
        $successMessage = 'Full payment of ₱' . number_format($downpaymentAmount, 2) . ' submitted successfully. Reservation #' . $updatedReservation->reservation_id . ' is now confirmed!';
    } else {
        $successMessage = 'Payment of ₱' . number_format($downpaymentAmount, 2) . ' submitted successfully for Reservation #' . $updatedReservation->reservation_id . '.';
    }

    return redirect()->route('summary')->with('success', $successMessage);
}
private function generateReservationId()
{
    // Get the latest reservation ID from database
    $latestReservation = DB::table('reservation_details')
        ->whereNotNull('reservation_id')
        ->where('reservation_id', 'like', 'RES%')
        ->orderBy('reservation_id', 'desc')
        ->first();
    
    if ($latestReservation) {
        // Extract number from latest reservation ID (e.g., RES0001 -> 1)
        $lastNumber = (int) substr($latestReservation->reservation_id, 3);
        $nextNumber = $lastNumber + 1;
    } else {
        // First reservation
        $nextNumber = 1;
    }
    
    // Format with leading zeros (RES0001, RES0002, etc.)
    return 'RES' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
}
    public function displayReservationSummary()
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to view your reservation summary.');
        }

        $userId = Auth::user()->id;

        // Fetch latest reservation
        $reservationDetails = DB::table('reservation_details')
        ->where('reservation_details.user_id', $userId)
        ->select('reservation_details.*')
        ->latest('reservation_details.created_at')
        ->first();


        // Redirect if no reservation found
        if (!$reservationDetails) {
            return redirect()->back()->with('error', 'No reservations found.');
        }

        // --- Fetch Activities ---
        $activityIds = json_decode($reservationDetails->activity_id, true);
        $activities = [];

        if (is_array($activityIds) && count($activityIds) > 0) {
            $activities = DB::table('activitiestbl')
                ->whereIn('id', $activityIds)
                ->pluck('activity_name')
                ->toArray();
        } elseif (is_numeric($activityIds)) { // Handle single integer
            $activities = DB::table('activitiestbl')
                ->where('id', $activityIds)
                ->pluck('activity_name')
                ->toArray();
        }

        // --- Fetch Accommodations ---
        $accommodationIds = json_decode($reservationDetails->accomodation_id, true);
        $accommodations = [];

        if (is_array($accommodationIds) && count($accommodationIds) > 0) {
            $accommodations = DB::table('accomodations')
                ->whereIn('accomodation_id', $accommodationIds)
                ->pluck('accomodation_name')
                ->toArray();
        } elseif (is_numeric($accommodationIds)) { // Handle single integer
            $accommodations = DB::table('accomodations')
                ->where('accomodation_id', $accommodationIds)
                ->pluck('accomodation_name')
                ->toArray();
        }
        return view('Reservation.summary', [
            'reservationDetails' => $reservationDetails,
            'activities' => $activities,
            'accommodations' => $accommodations
        ]);
    }

public function showReservationsInCalendar()
{
    $userId = Auth::id();
    $events = [];

    // Fetch user's own reservations
    $userReservations = DB::table('reservation_details')
        ->where('user_id', $userId)
        ->whereIn('reservation_status', ['reserved', 'checked-in'])
        ->get();

    foreach ($userReservations as $reservation) {
        $accommodationIds = json_decode($reservation->accomodation_id, true);
        $accommodations = DB::table('accomodations')
            ->whereIn('accomodation_id', (array) $accommodationIds)
            ->pluck('accomodation_name')
            ->toArray();

        $activityIds = json_decode($reservation->activity_id, true);
        $activities = DB::table('activitiestbl')
            ->whereIn('id', (array) $activityIds)
            ->pluck('activity_name')
            ->toArray();

        $events[] = [
            'title' => 'Your Reservation',
            'start' => \Carbon\Carbon::parse($reservation->reservation_check_in_date)->format('Y-m-d'),
            'allDay' => true,
            'color' => $reservation->reservation_status === 'checked-in' ? '#2ecc71' : '#97a97c',
            'extendedProps' => [
                'user_id' => (int) $reservation->user_id,
                'name' => $reservation->name,
                'check_in' => $reservation->reservation_check_in,
                'check_out' => $reservation->reservation_check_out,
                'room_type' => $package->package_room_type ?? '',
                'accommodations' => implode(", ", $accommodations),
                'activities' => implode(", ", $activities),
                'status' => $reservation->reservation_status
            ],
        ];
    }

    // Get Fully Booked Dates
    $fullyBookedDates = DB::table('reservation_details')
        ->whereIn('reservation_status', ['reserved', 'checked-in'])
        ->select('reservation_check_in_date')
        ->groupBy('reservation_check_in_date')
        ->havingRaw('COUNT(*) >= (SELECT COUNT(*) FROM accomodations)')
        ->pluck('reservation_check_in_date')
        ->toArray();

    // Add Fully Booked events
    foreach ($fullyBookedDates as $date) {
        $events[] = [
            'title' => 'Fully Booked',
            'start' => $date,
            'allDay' => true,
            'color' => '#FF0000',
            'textColor' => 'white'
        ];
    }

    return view('Reservation.Events_reservation', compact('events', 'userId'));
}
    public function guestcancelReservation(Request $request, $id)
    {
        $request->validate([
            'cancel_reason' => 'required|string|max:255'
        ]);

        $reservation = DB::table('reservation_details')->where('id', $id)->first();

        if (!$reservation) {
            return redirect()->back()->with('error', 'Reservation not found.');
        }

        // Update status to "cancelled" and save the reason
        DB::table('reservation_details')->where('id', $reservation->id)->update([
            'cancel_reason' => $request->cancel_reason,
            'payment_status' => 'cancelled',
            'reservation_status' => 'cancelled'
        ]);

        return redirect()->route('profile')->with('success', 'Reservation cancelled successfully.');
    }
    
    public function reservationSummary()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'User not authenticated.');
        }

        $reservations = Reservation::where('user_id', $user->id)->latest()->get();
        if ($reservations->isEmpty()) {
            return redirect()->back()->with('error', 'No reservations found.');
        }

        return view('FrontEnd.profilepageReservation', compact('reservations'));
    }
    public function getAvailableAccommodations(Request $request)
    {
        $selectedDate = $request->input('date');

        // Kunin lahat ng accommodations
        $accommodations = Accomodation::all();

        // Kunin lahat ng reservations sa napiling date
        $reservedAccommodations = Reservation::where('reservation_check_in_date', '<=', $selectedDate)
            ->where('reservation_check_out_date', '>', $selectedDate)
            ->whereNotIn('reservation_status', ['checked_out', 'cancelled'])
            ->pluck('accomodation_id')
            ->toArray();

        // Markahan ang mga hindi available
        foreach ($accommodations as $accommodation) {
            $accommodation->is_available = !in_array($accommodation->id, $reservedAccommodations);
        }

        return redirect()->back()->with('accommodations', $accommodations);
    }
    public function homepageReservation(Request $request)
    {
        // Validate ang request
        $validated = $request->validate([
            'accomodation_id' => 'required|exists:accomodations,accomodation_id',
            'number_of_adults' => 'required|integer|min:1',
            'number_of_children' => 'required|integer|min:0', // Changed min to 0 as children can be 0
            'total_guest' =>'required|integer|min:1',
            'reservation_check_in_date' => 'required|date',
            'reservation_check_in' => 'required',
            'reservation_check_out' => 'required',
            'reservation_check_out_date' => 'required|date',
            'activity_id' => 'nullable|array', // Changed to nullable array
            'quantity' => 'required|integer|min:1' // Added validation for quantity
        ]);
    
        try {
            // Kunin ang accommodation details
            $accommodation = Accomodation::findOrFail($request->accomodation_id);
    
            // Calculate total price (assuming price is per unit of quantity)
            $totalPrice = $accommodation->accomodation_price * $request->quantity;
    
            // Calculate total guests
            $totalGuests = $request->number_of_adults + $request->number_of_children;
    
            // Handle activity selection (store as JSON if multiple)
            $activityIds = $request->input('activity_id', []);
            $selectedActivityId = count($activityIds) > 1 ? json_encode($activityIds) : (count($activityIds) === 1 ? $activityIds[0] : null);
    
            // I-prepare ang reservation details para sa session
            $reservationDetails = [
                'user_id' => Auth::id(),
                'accomodation_id' => json_encode([$request->accomodation_id]),
                'activity_id' => $selectedActivityId, // Add activity_id to reservation details
                'number_of_adults' => $request->number_of_adults,
                'number_of_children' => $request->number_of_children,
                'total_guest' => $totalGuests,
                'reservation_check_in_date' => $request->reservation_check_in_date,
                'reservation_check_in' => $request->reservation_check_in,
                'reservation_check_out' => $request->reservation_check_out,
                'reservation_check_out_date' => $request->reservation_check_out_date,
                'quantity' => $request->quantity, // Added quantity to session details
                'amount' => $totalPrice
            ];
    
            // I-save sa session ang reservation details
            session(['reservation_details' => $reservationDetails]);
    
            return redirect()->route('paymentProcess')->with('success', 'Reservation saved.Wait for the staff to process your reservation.Thank you!');

        } catch (\Exception $e) {
            Log::error('Reservation save error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error saving reservation.');
        }
    }

public function feedback(Request $request)
{
    try {
        // Validate request
        $validated = $request->validate([
            'rating' => 'required|integer|max:5',
            'comment' => 'required|string|max:500',
            'reservation_id' => 'required|exists:reservation_details,id'
        ]);

        // Find the reservation
        $reservation = Reservation::findOrFail($validated['reservation_id']);

        // Store feedback
        $feedback = $reservation->feedback()->create([
            'user_id' => Auth::id(),
            'rating' => $validated['rating'],
            'comment' => $validated['comment']
        ]);

        return redirect()->back()
            ->with('success', 'Thank you for your feedback!');

    } catch (\Exception $e) {
        return redirect()->back()
            ->with('error', 'Error submitting feedback: ' . $e->getMessage());
    }
}

}