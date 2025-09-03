<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Artisan;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        // Update rooms at midnight
        $schedule->call(function () {
            Artisan::call('route:call', ['uri' => route('admin.update.rooms')]);
        })->dailyAt('00:01'); // Runs every midnight

        // Staff auto cancellation at midnight
        $schedule->call('App\Http\Controllers\StaffController@AutoCancellation')
                 ->dailyAt('00:00'); // Runs at midnight every day
        
        // Auto cancel reservations every minute
        $schedule->command('autocancel:reservations')
                 ->everyMinute()
                 ->withoutOverlapping() // Prevent overlapping executions
                 ->appendOutputTo(storage_path('logs/autocancel.log'));
        
        // Auto cancel on-hold reservations every minute
        $schedule->command('reservations:auto-cancel-onhold')
                 ->everyMinute()
                 ->withoutOverlapping() // Prevent overlapping executions
                 ->appendOutputTo(storage_path('logs/onhold-cancellations.log'));
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
    
    protected $commands = [
        \App\Console\Commands\UpdateAccommodationStatus::class,
        \App\Console\Commands\AutoCancelReservations::class,
        \App\Console\Commands\AutoCancelReservationsForOnHold::class,
    ];
}