<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class GlobalBookingMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $bookingData;

    /**
     * Create a new message instance.
     */
    public function __construct(array $bookingData)
    {
        $this->bookingData = $bookingData;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $type = ucfirst($this->bookingData['booking_type'] ?? 'Booking');

        return new Envelope(
            subject: "New {$type} Enquiry Received",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.global-booking',
            with: [
                'booking' => $this->bookingData,
            ],
        );
    }
}