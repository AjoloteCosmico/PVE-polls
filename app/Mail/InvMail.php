<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InvMail extends BaseMail
{
    protected function defineSubject(): string {
        return "Invitación a Encuesta de Seguimiento";
    }

    protected function defineView(): string {
        return 'mails.invitacion'; // Tu archivo .blade.php
    }
}