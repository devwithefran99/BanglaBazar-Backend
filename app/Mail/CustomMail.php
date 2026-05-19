<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CustomMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $mailSubject;
    public string $body;
    public string $name;

    public function __construct(string $subject, string $body, string $name = '')
    {
        $this->mailSubject = $subject;
        $this->body        = $body;
        $this->name        = $name;
    }

    public function envelope(): Envelope
    {
        return new Envelope(subject: $this->mailSubject);
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.custom',
            with: [
                'body' => $this->body,
                'name' => $this->name,
            ],
        );
    }
}