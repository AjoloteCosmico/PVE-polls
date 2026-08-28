<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PosMail extends BaseMail
{
    use Queueable, SerializesModels;
    protected function defineSubject(): string {
        return "Invitación a Encuesta de Posgrado";
    }

    protected function defineView(): string {
        return 'mails.encuesta_posgrado'; 
    }
    
    protected function defineType(): string {
        return 'posgrado'; 
    }
}
