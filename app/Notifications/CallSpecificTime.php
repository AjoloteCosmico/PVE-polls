<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CallSpecificTime extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct($Egresado, $horario_programado,$recado)
    {
        $this->Egresado = $Egresado;
        $this->horario_programado = $horario_programado;
        $this->recado = $recado;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        if($this->egresado->act_suvery='1'){
            $url=route('llamar',['gen'=>2016,'id'=>$this->Egresado->cuenta,'carrera'=>$this->Egresado->carrera]);
        }
        return [
            'message' => 'Llamada programada para el egresado: '.$this->Egresado->nombre.' '.$this->Egresado->paterno.' '.$this->Egresado->materno,
            'cuenta'=>$this->Egresado->cuenta,
            'horario_programado'=>$this->horario_programado,
            'recado'=>$this->recado,
            'action_url'=>$url ?? route('dashboard')
        ];
    }
}
