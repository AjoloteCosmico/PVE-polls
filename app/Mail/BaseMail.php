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

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        return $this->from('vinculacion@exalumno.pve.unam.mx', 'VINCULACIÓN UNAM')
                    ->subject($this->defineSubject())
                    ->view($this->defineView()) // Usarás vistas Blade
                    ->with([
                        'payload' => $this->data,
                        'footer_img' => 'cid:footer_img' // Ejemplo de imagen fija
                    ]);
       
    }
    
}
