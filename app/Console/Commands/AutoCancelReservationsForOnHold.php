<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Mail\ReservationCancelled;
use App\Models\User;

class AutoCancelReservationsForOnHold extends Command
{
    protected $signature = 'reservations:auto-cancel-onhold';
    protected $description = 'Auto cancel reservations that are on-hold for more than 2 hours';

    public function handle()
    {
        // Auto-detect environment
        $isLocal = app()->environment('local');
        $cutoffMinutes = $isLocal ? 1 : 120; // 1 min locally, 2 hours production
        
        Log::info("AutoCancelReservationsForOnHold started in " . ($isLocal ? 'LOCAL' : 'PRODUCTION') . " mode");
        $this->info("Running in " . ($isLocal ? 'LOCAL' : 'PRODUCTION') . " mode");
        
        $cutoffTime = Carbon::now()->subMinutes($cutoffMinutes);
        $this->info("Cutoff time: " . $cutoffTime->toDateTimeString());

        // Get expired reservations
        $expiredReservations = DB::table('reservation_details')
            ->where('reservation_status', 'on-hold')
            ->where('created_at', '<', $cutoffTime->toDateTimeString())
            ->get();

        $this->info("Found " . $expiredReservations->count() . " expired reservations.");

        // Process each reservation
        foreach ($expiredReservations as $reservation) {
            $this->cancelReservation($reservation);
        }

        $this->info("Command finished. Processed " . $expiredReservations->count() . " reservations.");
        return 0;
    }

    private function cancelReservation($reservation)
    {
        try {
            DB::beginTransaction();

            // Update the reservation status
            DB::table('reservation_details')
                ->where('id', $reservation->id)
                ->update([
                    'reservation_status' => 'cancelled',
                    'updated_at' => Carbon::now(),
                    'cancellation_reason' => 'Automatically cancelled after exceeding time limit'
                ]);

            $this->info("Cancelled reservation ID: {$reservation->id}");

            // Send email notification
            $user = User::find($reservation->user_id);
            if ($user) {
                $emailData = [
                    'customer_name' => $user->name,
                    'reservation_id' => $reservation->id,
                    'reservation_date' => $reservation->created_at,
                    'cancellation_reason' => 'Your reservation was automatically cancelled because it exceeded the time limit for on-hold status.',
                    'cancellation_time' => Carbon::now()->toDateTimeString()
                ];

                Mail::to($user->email)->send(new ReservationCancelled($emailData));
                $this->info("Sent cancellation email for reservation ID: {$reservation->id}");
            }

            DB::commit();
            
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("Failed to cancel reservation ID {$reservation->id}: " . $e->getMessage());
            Log::error("Failed to cancel reservation ID {$reservation->id}: " . $e->getMessage());
        }
    }
}