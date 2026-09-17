<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EspecialidadConvocatoriaMail extends BaseMail
{
    use Queueable, SerializesModels;
    protected function defineSubject(): string {
        return "Convocatoria Titulación 2026 Especialidad Derecho UNAM";
    }

    protected function defineView(): string {
        return 'mails.convocatoria_especialidad'; 
    }
    
    protected function defineType(): string {
        return 'conv_esp'; 
    }
}
