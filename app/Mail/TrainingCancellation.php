<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TrainingCancellation extends Mailable
{

    use Queueable, SerializesModels;

    public function __construct()
    {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Training findet NICHT statt',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.training-cancellation',
        );
    }

    public function attachments(): array
    {
        return [];
    }

}
