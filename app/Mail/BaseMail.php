<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

use Illuminate\Support\Str;
use DB;

abstract class BaseMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $data;
    public string $trackingUuid;

    public function __construct($data)
    { 
        $this->data = $data;
         // 2. Insertar registro en BD con estado 'pending'
        // $this->trackingId = DB::table('email_tracking')->insertGetId([
        //     'uuid' => $this->trackingUuid,
        //     'recipient_email' => $this->getRecipientEmail(), // Debes definir este método en hijas
        //     'status' => 'pending',
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);

        $tracking_id = (string) Str::uuid();
        $this->trackingUuid=$tracking_id;
        DB::table('email_tracking')->insert([
            'email_id' => $data['correo_id'],
            'recipient_email' => $data['correo'],
            'tracking_uuid' => $tracking_id,
            'type' => $this->defineType(),
            'created_at' => now(),
            'updated_at' => now(),
            'sended_at' => now(),
        ]);
    }

    public function build()
    {
        return $this->from('vinculacion@exalumno.pve.unam.mx', 'VINCULACIÓN UNAM')
                    ->subject($this->defineSubject())
                    ->view($this->defineView()) // Usarás vistas Blade
                    ->with([
                        'payload' => $this->data,
                        'tracking_uuid' => $this->trackingUuid,
                    ]);
       
    }


    // Este callback se ejecuta DESPUÉS de que el SMTP confirme el envío
    public function after(): array
    {
        return [
            function () {
                DB::table('email_tracking')
                  ->where('tracking_uuid', $this->trackingUuid)
                  ->update(['sended_at' => now(),
                            'updated_at' => now()]);
            }
        ];
    }
    
}
