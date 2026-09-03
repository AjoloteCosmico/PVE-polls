<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EspMail extends BaseMail
{
    use Queueable, SerializesModels;
    protected function defineSubject(): string {
        return "Especialidad Derecho Encuesta de Seguimiento";
    }

    protected function defineView(): string {
        return 'mails.especialidad'; 
    }
    
    protected function defineType(): string {
        return 'especialidad'; 
    }
}
