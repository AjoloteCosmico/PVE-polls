<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Correo;
use App\Traits\EnviaAvisoPrivacidad;
use Illuminate\Support\Facades\Auth;

class EmailManager extends Component
{
    use EnviaAvisoPrivacidad;

    public $cuenta;
    public $egresado;
    public $correos = [];

    public $showEmailModal = false;
    public $emailId = null;
    public $correoInput = '';
    public $correoStatus = '13'; // Default 'En uso'
    public $correoDescripcion = '';

    public function mount($cuenta, $egresado){
        $this->cuenta = $cuenta;
        $this->egresado = $egresado;
        $this->cargarCorreos();
    }

    public function cargarCorreos()
    {
        $this->correos = Correo::where('cuenta', $this->cuenta)->get();
    }

    public function nuevoCorreo()
    {
        $this->resetValidation();
        $this->emailId = null;
        $this->correoInput = '';
        $this->correoStatus = '13';
        $this->correoDescripcion = '';
        $this->showEmailModal = true;
        
    }

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
            $correo->descripcion = $this->correoDescripcion;
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
