<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BecomeRevisor extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public string $userMessage;

    public function __construct(User $user, string $userMessage)
    {
        $this->user = $user;
        $this->userMessage = $userMessage;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Richiesta per diventare revisore',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.become-revisor',
        );
    }
}
