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
    public function __construct($Egresado, $horario_programado,$recado,$TypeStudy='seg')
    {
        $this->Egresado = $Egresado;
        $this->horario_programado = $horario_programado;
        $this->recado = $recado;
        $this->TypeStudy = $TypeStudy;
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
        switch($this->TypeStudy){
            case 'act':
                $url=route('llamar',['gen'=>2016,'id'=>$this->Egresado->cuenta,'carrera'=>$this->Egresado->carrera]);
                break;
            case 'seg':
                $url=route('llamar',['gen'=>2022,'id'=>$this->Egresado->cuenta,'carrera'=>$this->Egresado->carrera]);
                break;
            case 'pos':
                $url=route('llamar_posgrado',['id'=>$this->Egresado->cuenta,'plan'=>$this->Egresado->plan,'programa'=>$this->Egresado->programa]);
                break;
            case 'esp':
                $url=route('llamar',['gen'=>2020,'id'=>$this->Egresado->cuenta,'carrera'=>$this->Egresado->carrera]);
                break;
            case 'verde':
                $url=route('llamar_verde',['gen'=>$this->Egresado->anio_egreso,'id'=>$this->Egresado->cuenta,'carrera'=>$this->Egresado->carrera,'muestra_id'=>898]);
                break;
            case 'cont':
                $url=route('llamar_continua',['gen'=>$this->Egresado->anio_egreso,'id'=>$this->Egresado->cuenta,'carrera'=>$this->Egresado->carrera,'muestra_id'=>897]);
             
                break;
            default:
                $url=route('dashboard');
        }
        return [
            'message' => 'Llamada programada'.$this->horario_programado.' para: '.$this->Egresado->nombre.' '.$this->Egresado->paterno.' '.$this->Egresado->materno,
            'cuenta'=>$this->Egresado->cuenta,
            'horario_programado'=>$this->horario_programado,
            'recado'=>$this->recado,
            'action_url'=>$url ?? route('dashboard')
        ];
    }
}
