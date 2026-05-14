<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Correo;
use Illuminate\Support\Facades\Auth;

class EmailManager extends Component
{
    public $showModal = false;
    public $isEditing = false;
    
    public $correo = '';
    public $description = '';
    public $status = '13';
    public $correo_id = '';
    
    public $cuenta;
    public $respuestasKey;
    public $typeStudy;
    public $egName;
    
    protected $rules = [
        'correo' => 'required|email',
        'description' => 'nullable|string',
        'status' => 'required',
    ];
    
    protected $messages = [
        'correo.required' => 'El correo es requerido',
        'correo.email' => 'Ingresa un correo válido',
    ];
    
    public function mount($cuenta, $respuestasKey, $typeStudy, $egName)
    {
        $this->cuenta = $cuenta;
        $this->respuestasKey = $respuestasKey;
        $this->typeStudy = $typeStudy;
        $this->egName = $egName;
    }
    
    public function openCreateModal()
    {
        $this->reset(['correo', 'description', 'correo_id']);
        $this->status = '13';
        $this->isEditing = false;
        $this->showModal = true;
    }
    
    public function openEditModal($id, $correo, $description, $status)
    {
        $this->correo_id = $id;
        $this->correo = $correo;
        $this->description = $description;
        $this->status = $status ?? '13';
        $this->isEditing = true;
        $this->showModal = true;
    }
    
    public function save()
    {
        $this->validate();
        
        try {
            if ($this->isEditing) {
                Correo::find($this->correo_id)->update([
                    'correo' => $this->correo,
                    'description' => $this->description,
                    'status' => $this->status,
                ]);
                
                $this->dispatch('show-swal',
                    title: 'Actualizado',
                    message: 'Correo actualizado correctamente',
                    icon: 'success'
                );
            } else {
                Correo::create([
                    'correo' => $this->correo,
                    'description' => $this->description,
                    'status' => $this->status,
                    'cuenta' => $this->cuenta,
                    'respuestas_id' => $this->respuestasKey,
                    'type_study' => $this->typeStudy,
                ]);
                
                $this->dispatch('show-swal',
                    title: 'Guardado',
                    message: 'Correo guardado correctamente',
                    icon: 'success'
                );
            }
            
            $this->closeModal();
            $this->dispatch('emailChanged');
            
        } catch (\Exception $e) {
            $this->dispatch('show-swal',
                title: 'Error',
                message: 'Hubo un error: ' . $e->getMessage(),
                icon: 'error'
            );
        }
    }
    
    public function closeModal()
    {
        $this->showModal = false;
        $this->resetErrorBag();
    }
    
    public function render()
    {
        return view('livewire.email-manager');
    }
}
