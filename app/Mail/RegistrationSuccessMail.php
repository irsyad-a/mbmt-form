<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class RegistrationSuccessMail extends Mailable
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
            subject: 'Bukti Pengisian Form - MBMT 2026',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.pendaftaran_berhasil',
            with: ['data' => $this->data],
        );
    }
}
