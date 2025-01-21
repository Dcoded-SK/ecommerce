<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderRegardMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data; // Make $data public to pass it to the view

    public function __construct($data)
    {
        $this->data = $data; // Correct assignment
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->data['subject'],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'adminFolder.order_regard_mail',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
