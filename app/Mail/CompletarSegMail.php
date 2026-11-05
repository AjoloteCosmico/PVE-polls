<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CompletarSegMail extends BaseMail
{
    use Queueable, SerializesModels;
    protected function defineSubject(): string {
        return "POSGRADO UNAM: Completa tu encuesta ";
    }

    protected function defineView(): string {
        return 'mails.completar_posgrado'; 
    }
    
    protected function defineType(): string {
        return 'posgrado'; 
    }
}