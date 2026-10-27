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
    public $telefonoDescripcion = '';


    public function mount($cuenta){
        $this->cuenta = $cuenta;
        $this->cargarTelefonos();
    }


    public function cargarTelefonos()
    {
        $this->telefonos = Telefono::where('cuenta', $this->cuenta)->get();
    }

    public function nuevoTelefono()
    {
        $this->resetValidation();
        $this->phoneId = null;
        $this->telefonoInput = '';
        $this->telefonoDescripcion = '';
        $this->showPhoneModal = true;
    }

    public function editarTelefono($id)
    {
        $this->resetValidation();
        $tel = Telefono::findOrFail($id);
        $this->phoneId = $tel->id;
        $this->telefonoInput = $tel->telefono;
        $this->telefonoDescripcion = $tel->descripcion;
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
            $tel->save();
            $mensaje = 'Teléfono editado correctamente';
        } else {
            // Nuevo tel
            $tel = new Telefono();
            $tel->cuenta = $this->cuenta;
            $tel->telefono = $this->telefonoInput;
            $tel->descripcion = $this->telefonoDescripcion;
            $tel->status = 0;
            $tel->save();
            $mensaje = 'Teléfono agregado correctamente';
        }


        $this->showPhoneModal = false;
        $this->cargarTelefonos();
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