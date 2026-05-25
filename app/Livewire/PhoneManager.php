<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Telefono;
use App\Traits\LogEvents;

class PhoneManager extends Component
{
    use LogEvents;

    public $showModal = false;
    public $isEditing = false;
    
    // Propiedades de formulario
    public $telefono = '';
    public $description = '';
    public $telefono_id = '';
    
    // Datos necesarios
    public $cuenta;
    public $respuestasKey;
    public $typeStudy;
    public $telefonos = [];
    
    protected $rules = [
        'telefono' => 'required|string|min:10|max:20',
        'description' => 'nullable|string|max:255',
    ];
    
    protected $messages = [
        'telefono.required' => 'El teléfono es requerido',
        'telefono.min' => 'El teléfono debe tener al menos 10 dígitos',
        'telefono.max' => 'El teléfono no puede exceder 20 caracteres',
    ];
    
    public function mount($cuenta, $respuestasKey, $typeStudy)
    {
        $this->cuenta = $cuenta;
        $this->respuestasKey = $respuestasKey;
        $this->typeStudy = $typeStudy;
        $this->cargarTelefonos();
    }
    
    public function cargarTelefonos()
    {
        $this->telefonos = Telefono::where('cuenta', $this->cuenta)
            ->get()
            ->toArray();
    }
    
    // Abrir modal para crear
    public function openCreateModal()
    {
        $this->reset(['telefono', 'description', 'telefono_id']);
        $this->isEditing = false;
        $this->showModal = true;
    }
    
    // Abrir modal para editar
    public function openEditModal($id, $telefono, $description)
    {
        $this->telefono_id = $id;
        $this->telefono = $telefono;
        $this->description = $description;
        $this->isEditing = true;
        $this->showModal = true;
    }
    
    // Guardar (crear o editar)
    public function save()
    {
        $this->validate();
        
        try {
            if ($this->isEditing) {
                $tel = Telefono::find($this->telefono_id);
                $tel->update([
                    'telefono' => $this->telefono,
                    'description' => $this->description,
                ]);
                
                $this->recordEvent($tel->id, 'edit_telefono', 'Telefono actualizado desde Livewire');
                
                // Dispara evento con SweetAlert2
                $this->dispatch('show-swal', 
                    title: '¡Actualizado!',
                    message: 'Teléfono actualizado correctamente',
                    icon: 'success'
                );
            } else {
                $tel = Telefono::create([
                    'telefono' => $this->telefono,
                    'description' => $this->description,
                    'cuenta' => $this->cuenta,
                    'status' => 0,
                ]);
                
                $this->recordEvent($tel->id, 'create_telefono', 'Telefono creado desde Livewire');
                
                $this->dispatch('show-swal',
                    title: '¡Guardado!',
                    message: 'Teléfono guardado correctamente',
                    icon: 'success'
                );
            }
            
            $this->closeModal();
            $this->cargarTelefonos();
            $this->dispatch('phoneChanged');
            
        } catch (\Exception $e) {
            $this->dispatch('show-swal',
                title: 'Error',
                message: 'Hubo un error: ' . $e->getMessage(),
                icon: 'error'
            );
        }
    }
    
    // Eliminar teléfono
    public function eliminarTelefono($id)
    {
        try {
            Telefono::find($id)->delete();
            $this->recordEvent($id, 'delete_telefono', 'Telefono eliminado desde Livewire');
            
            $this->dispatch('show-swal',
                title: '¡Eliminado!',
                message: 'Teléfono eliminado correctamente',
                icon: 'success'
            );
            
            $this->cargarTelefonos();
            $this->dispatch('phoneChanged');
            
        } catch (\Exception $e) {
            $this->dispatch('show-swal',
                title: 'Error',
                message: 'No se pudo eliminar: ' . $e->getMessage(),
                icon: 'error'
            );
        }
    }
    
    // Cerrar modal
    public function closeModal()
    {
        $this->showModal = false;
        $this->resetErrorBag();
    }
    
    public function render()
    {
        return view('livewire.phone-manager');
    }
}
