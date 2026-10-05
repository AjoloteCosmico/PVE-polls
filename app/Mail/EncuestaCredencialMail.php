<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EncuestaCredencialMail extends BaseMail
{
    use Queueable, SerializesModels;
    protected function defineSubject(): string {
        return "Satisfacción con la Credencial de Egresado UNAM Invitación a Encuesta";
    }

    protected function defineView(): string {
        return 'mails.credencial'; 
    }
    
    protected function defineType(): string {
        return 'credencial'; 
    }
}
