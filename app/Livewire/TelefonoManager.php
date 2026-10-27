<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Telefono;


class TelefonoManager extends Component
{
    
    public $cuenta;
    public $telefonos = [];

    public $showPhoneModal = false;
    public $phoneId = null;
    public $telefonoInput = '';
    public $telefonoStatus = 13; // Valor por defecto para el status del teléfono
    public $telefonoDescripcion = '';


    public function mount($cuenta){
        $this->cuenta = $cuenta;
        $this->cargarTelefonos();
    }


    public function cargarTelefonos()
    {
        $this->telefonos = Telefono::where('cuenta', $this->cuenta)->get();
    }

    #[On('nuevoTelefono')]
    public function nuevoTelefono()
    {
        $this->resetValidation();
        $this->phoneId = null;
        $this->telefonoInput = '';
        $this->telefonoDescripcion = '';
        $this->telefonoStatus = '13';
        $this->showPhoneModal = true;
    }

    #[On('editarTelefono')]
    public function editarTelefono($id)
    {
        $this->resetValidation();
        $tel = Telefono::findOrFail($id);
        $this->phoneId = $tel->id;
        $this->telefonoInput = $tel->telefono;
        $this->telefonoDescripcion = $tel->descripcion;
        $this->telefonoStatus = $tel->status;
        $this->showPhoneModal = true;
    }

    public function guardarTelefono()
    {
        $this->validate([
            'telefonoInput' => 'required|string|max:20|unique:telefonos,telefono,' . ($this->phoneId ?? 'NULL'),
            'telefonoDescripcion' => 'nullable|string|max:255',
        ], [
            'telefonoInput.required' => 'El campo teléfono es obligatorio.',
            'telefonoInput.unique' => 'Este número ya está registrado.',
        ]);


        if ($this->phoneId) {
            // Editar tel
            $tel = Telefono::find($this->phoneId);
            $tel->telefono = $this->telefonoInput;
            $tel->descripcion = $this->telefonoDescripcion;
            $tel->status = $this->telefonoStatus;
            $tel->save();
            $mensaje = 'Teléfono editado correctamente';
        } else {
            // Nuevo tel
            $tel = new Telefono();
            $tel->cuenta = $this->cuenta;
            $tel->telefono = $this->telefonoInput;
            $tel->descripcion = $this->telefonoDescripcion;
            $tel->status = $this->telefonoStatus;
            $tel->save();
            $mensaje = 'Teléfono agregado correctamente';
        }


        $this->showPhoneModal = false;
        $this->cargarTelefonos();
        $this->dispatch('contactoActualizado');
        $this->dispatch('swal:success', message: $mensaje);


    }


    public function cerrarModal()
    {
        $this->showPhoneModal = false;
        $this->resetValidation();
    }


    public function render(){
        return view('livewire.telefono-manager');
    }

}