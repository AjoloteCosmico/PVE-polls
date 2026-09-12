<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;


class ReportMail extends BaseMail
{
    use Queueable, SerializesModels;
    protected function defineSubject(): string {
        return "SEGUIMIENTO Reporte Semanal Encuestas PVEAJU UNAM";
    }

    protected function defineView(): string {
        return 'mails.report'; 
    }
    
    protected function defineType(): string {
        return 'report'; 
    }
}