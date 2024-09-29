<?php

namespace App\Mail;

use Illuminate\Mail\Mailables\Address;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Reset extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('Reset Password'),
            from: new Address(env('MAIL_NOREPLAY_ADDRESS'), env('MAIL_NAME')),
            to: is_array($this->data['to']) ? $this->data['to'] : [$this->data['to']],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.reset',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
