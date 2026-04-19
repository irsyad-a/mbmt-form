<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class CommitmentDocumentMail extends Mailable
{
    use Queueable;

    /**
     * @param  array<string, mixed>  $data
     */
    public function __construct(public array $data)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Bukti Lembar Komitmen - MBMT 2026',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.lembar_komitmen',
            with: ['data' => $this->data],
        );
    }
}
