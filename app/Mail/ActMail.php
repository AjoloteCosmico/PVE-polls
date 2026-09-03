<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ActMail extends BaseMail
{
    use Queueable, SerializesModels;
    protected function defineSubject(): string {
        return "Seguimiento A egresados Encuesta de Actualización";
    }

    protected function defineView(): string {
        return 'mails.actualizacion'; 
    }
    
    protected function defineType(): string {
        return 'act_encuesta'; 
    }
}
