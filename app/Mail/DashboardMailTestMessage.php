<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class DashboardMailTestMessage extends Mailable
{
    use Queueable;

    public function __construct(public string $generatedAt)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Tes SMTP MBMT Dashboard',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.dashboard_mail_test',
            with: [
                'generatedAt' => $this->generatedAt,
            ],
        );
    }
}
