<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class EmailVerification extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    
    public function __construct($user)
    {
        $this->user = $user;
    }

    public function build()
    {
        return $this->view('clients.email_verification')
            ->subject('Email Verification')
            ->with([
                'user' => $this->user,
                'verificationLink' => route('email.verify', $this->user->email_verification_token)
            ]);
    }

    public function attachments(): array
    {
        return [];
    }
}
