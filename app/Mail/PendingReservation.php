<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PendingReservation extends Mailable
{
    use Queueable, SerializesModels;

    public $reservation;
    public $accommodationDetails;
    public $totalPrice;
    public $downpayment;

    /**
     * Create a new message instance.
     *
     * @param object $reservation
     * @param array $accommodationDetails
     * @param float $totalPrice
     * @param float $downpayment
     * @return void
     */
    public function __construct($reservation, $accommodationDetails, $totalPrice, $downpayment)
    {
        $this->reservation = $reservation;
        $this->accommodationDetails = $accommodationDetails;
        $this->totalPrice = $totalPrice;
        $this->downpayment = $downpayment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Your Reservation is Completed - Lelo\'s Resort')
                    ->view('emails.pendingReservation');
    }
}