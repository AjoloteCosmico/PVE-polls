<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AvisoPrivacidadMail extends BaseMail
{
    use Queueable, SerializesModels;
    protected function defineSubject(): string {
        return "Aviso de privacidad PVEAJU UNAM";
    }

    protected function defineView(): string {
        return 'mails.aviso'; 
    }
    
    protected function defineType(): string {
        return 'aviso'; 
    }
}
