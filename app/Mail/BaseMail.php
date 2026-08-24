<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

abstract class BaseMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public string $trackingUuid;

    public function __construct($data)
    {
        $this->data = $data;
         // 2. Insertar registro en BD con estado 'pending'
        $this->trackingId = DB::table('email_tracking')->insertGetId([
            'uuid' => $this->trackingUuid,
            'recipient_email' => $this->getRecipientEmail(), // Debes definir este método en hijas
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function build()
    {
        return $this->from('vinculacion@exalumno.pve.unam.mx', 'VINCULACIÓN UNAM')
                    ->subject($this->defineSubject())
                    ->view($this->defineView()) // Usarás vistas Blade
                    ->with([
                        'payload' => $this->data
                    ]);
       
    }


    // Este callback se ejecuta DESPUÉS de que el SMTP confirme el envío
    public function after(): array
    {
        return [
            function () {
                DB::table('email_tracking')
                  ->where('id', $this->trackingId)
                  ->update(['status' => 'sent', 'sent_at' => now()]);
            }
        ];
    }
    
}
