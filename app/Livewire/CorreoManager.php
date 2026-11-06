<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Correo;
use App\Models\Egresado;
use Illuminate\Http\Request;
use App\Traits\EnviaAvisoPrivacidad;
use App\Http\Controllers\SendMailController;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Http;

use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;


class CorreoManager extends Component
{
    use EnviaAvisoPrivacidad;

    public $cuenta;
    //public $nombreEgresado;
    public $egresado;
    public $correos = [];

    public $showEmailModal = false;
    public $emailId = null;
    public $correoInput = '';
    public $correoStatus = '13';
    public $correoDescripcion = '';

    //envio de  encuesta por correo:
    public $showSendModal = false;
    public $sendCorreoId = null;
    public $sendCorreo = '';
    public $sendMailType = '';
    public $sendProgAcad = '';


    public function mount($cuenta, $egresado){
        $this->cuenta = $cuenta;
        $this->egresado = $egresado;
        $this->cargarCorreos();
    }

    #[Computed]
    public function nombreEgresado()
    {
        if (is_object($this->egresado)) {
            return trim(($this->egresado->nombre ?? '') . ' ' . ($this->egresado->paterno ?? '') . ' ' . ($this->egresado->materno ?? ''));
        }
        return '';
    }



    #[On('solicitarEnvioCorreo')]
    public function solicitarEnvio($id, $mailType, $progAcad = null)
    {
        $c = Correo::where('cuenta', $this->cuenta)->findOrFail($id);
        $this->sendCorreoId = $c->id;
        $this->sendCorreo = $c->correo;
        $this->sendMailType = $mailType;
        $this->sendProgAcad = $progAcad ?? ($this->egresado->carrera ?? '');
        $this->showSendModal = true;
    }


    public function cerrarEnvio()
    {
        $this->showSendModal = false;
        $this->sendCorreoId = null;
        $this->sendCorreo = '';
        $this->sendMailType = '';
        $this->sendProgAcad = '';
    }

    public function confirmarEnvio(){


        try {
            
            $controller = app(SendMailController::class);
            $request = new Request([
                'encuesta_id' => 0,
                'correo_id'   => $this->sendCorreoId,
                'correo'      => $this->sendCorreo,
                'prog_acad'   => $this->sendProgAcad,
                'cuenta'      => $this->cuenta,
                'nombre'      => $this->nombreEgresado,
                'mail_type'   => $this->sendMailType,
            ]);

            $response = $controller->send_prioritary_mail($request);
            $data = $response->getData(true);

            if (isset($data['success']) && $data['success']) {
                $this->dispatch('swal:success', message: 'Encuesta enviada correctamente');
            } else {
                $this->dispatch('swal:error', message: 'No se pudo procesar el envío de la encuesta.');
            }
        } catch (\Exception $e) {
            $this->dispatch('swal:error', message: 'Error al enviar la encuesta: ' . $e->getMessage());
        }

        $this->cerrarEnvio();
        $this->dispatch('contactoActualizado');
    }

    

    public function cargarCorreos()
    {
        $this->correos = Correo::where('cuenta', $this->cuenta)->get();
    }

    #[On('nuevoCorreo')]
    public function nuevoCorreo()
    {
        $this->resetValidation();
        $this->emailId = null;
        $this->correoInput = '';
        $this->correoStatus = '13';
        $this->correoDescripcion = '';
        $this->showEmailModal = true;
        
    }

    #[On('editarCorreo')]
    public function editarCorreo($id)
    {
        $this->resetValidation();
        $correo = Correo::findOrFail($id);
        $this->emailId = $correo->id;
        $this->correoInput = $correo->correo;
        $this->correoStatus = $correo->status;
        $this->correoDescripcion = $correo->descripcion;
        $this->showEmailModal = true;
    }

    public function guardarCorreo()
    {
        $this->validate([
            'correoInput' => 'required|email|max:40|unique:correos,correo,' . ($this->emailId ?? 'NULL'),
        ], [
            'correoInput.required' => 'El correo es obligatorio.',
            'correoInput.email' => 'Ingrese una dirección de correo válida.',
            'correoInput.unique' => 'Este correo ya está registrado.',
        ]);

        if($this->emailId) {
            // Editar correo
            $correo = Correo::find($this->emailId);
            $correo->correo = $this->correoInput;
            $correo->status = $this->correoStatus;
            $correo->descripcion = 'sin Uso';
            $correo->enviado = 0;
            $correo->save();
        } else {
            // Nuevo correo
            $correo = new Correo();
            $correo->cuenta = $this->cuenta;
            $correo->correo = $this->correoInput;
            $correo->status = $this->correoStatus;
            $correo->descripcion = 'en Uso';
            $correo->save();
        }
 
        $this->showEmailModal = false;
        $this->cargarCorreos();
        $this->dispatch('contactoActualizado');
        $this->dispatch('swal:success', message: 'Correo guardado y aviso enviado correctamente');

    }

    public function enviarAvisoPrivacidad()
    {
        $correo = Correo::findOrFail($this->emailId);

        try {

            $this->enviarAviso($correo->id, $correo->correo, $this->egresado->nombre, $this->cuenta);
            $correo->enviado = 1;
            $correo->save();
            $this->dispatch('swal:success', message: 'Aviso de privacidad enviado correctamente');
        } catch (\Exception $e) {
            
            $correo->enviado = 2;
            $correo->save();
            $this->dispatch('swal:error', message: 'Error al enviar el aviso de privacidad: ' . $e->getMessage());
        }
        $this->cargarCorreos();
        $this->cerrarModal();

    }

    public function cerrarModal()
    {
        $this->showEmailModal = false;
        $this->resetValidation();
    }

    public function render(){
        return view('livewire.correo-manager');
    }
    
}
