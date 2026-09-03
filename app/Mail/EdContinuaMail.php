<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EdContinuaMail extends BaseMail
{
    use Queueable, SerializesModels;
    protected function defineSubject(): string {
        return "Invitación a Encuesta Educación Continua UNAM";
    }

    protected function defineView(): string {
        return 'mails.ed_continua'; 
    }
    
    protected function defineType(): string {
        return 'continua'; 
    }
}
