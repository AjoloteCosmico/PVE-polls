<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Egresado;
use App\Models\Telefono;
use App\Models\Correo;

class PersonalData extends Component
{
    public $typeStudy; // 'esp', '22', 'posgrado', 'actualizacion', 'continua'
    public $egresado;
    public $encuesta;
    public $carrera;
    public $plantel;
    public $section;

    // Estado para modales
    public $showPhoneModal = false;
    public $showEmailModal = false;
    
    // Formulario reactivo para Teléfono
    public $phone_id = null;
    public $nuevo_telefono = '';
    public $descripcion_telefono = '';

    // Formulario reactivo para Correo
    public $email_id = null;
    public $nuevo_correo = '';
    public $descripcion_correo = '';
    public $status_correo = '';

    public function mount($typeStudy=null, $egresado=null, $encuesta=null, $carrera = null, $plantel = null, $section = null)
    {
        $this->typeStudy = $typeStudy;
        $this->egresado = $egresado;
        $this->encuesta = $encuesta;
        $this->carrera = $carrera;
        $this->plantel = $plantel;
        $this->section = $section;
    }

    // --- ACCIONES REPACTIVAS ---
    
    public function openCreatePhone()
    {
        $this->reset(['phone_id', 'nuevo_telefono', 'descripcion_telefono']);
        $this->showPhoneModal = true;
    }

    public function editPhone($id, $telefono, $descripcion = '')
    {
        $this->phone_id = $id;
        $this->nuevo_telefono = $telefono;
        $this->descripcion_telefono = $descripcion;
        $this->showPhoneModal = true;
    }

    public function savePhone()
    {
        $this->validate([
            'nuevo_telefono' => 'required|numeric'
        ]);

        if ($this->phone_id) {
            Telefono::where('id', $this->phone_id)->update([
                'telefono' => $this->nuevo_telefono,
                'descripcion' => $this->descripcion_telefono
            ]);
        } else {
            Telefono::create([
                'cuenta' => $this->egresado->cuenta,
                'telefono' => $this->nuevo_telefono,
                'descripcion' => $this->descripcion_telefono
            ]);
        }

        $this->showPhoneModal = false;
        // Refresca la relación en memoria sin recargar la página
        $this->egresado->refresh(); 
    }

    public function render()
    {
        // Construcción unificada de secciones según tipo de estudio
        $secciones = $this->obtenerSecciones();

        return view('livewire.personal-data', [
            'telefonos' => $this->egresado->telefonos ?? [], 
            'correos'   => $this->egresado->correos ?? [],
            'secciones' => $secciones
        ]);
    }

    private function obtenerSecciones()
    {
        // Mapea las secciones según el tipo de estudio sin enredar la vista Blade
        return match($this->typeStudy) {
            '22' => [
                ['clave' => 'A', 'etiqueta' => 'Sección A', 'completada' => $this->encuesta->sec_a == 1, 'url' => route('edit_22', [$this->encuesta->registro, 'A'])],
                ['clave' => 'E', 'etiqueta' => 'Sección E', 'completada' => $this->encuesta->sec_e == 1, 'url' => route('edit_22', [$this->encuesta->registro, 'E'])],
                ['clave' => 'F', 'etiqueta' => 'Sección F', 'completada' => $this->encuesta->sec_f == 1, 'url' => route('edit_22', [$this->encuesta->registro, 'F'])],
                ['clave' => 'C', 'etiqueta' => 'Sección C', 'completada' => $this->encuesta->sec_c == 1, 'url' => route('edit_22', [$this->encuesta->registro, 'C'])],
                ['clave' => 'D', 'etiqueta' => 'Sección D', 'completada' => $this->encuesta->sec_d == 1, 'url' => route('edit_22', [$this->encuesta->registro, 'D'])],
                ['clave' => 'G', 'etiqueta' => 'Sección G', 'completada' => $this->encuesta->sec_g == 1, 'url' => route('edit_22', [$this->encuesta->registro, 'G'])],
            ],
            'esp' => [
                ['clave' => 'espA', 'etiqueta' => 'Sección A', 'completada' => $this->encuesta->sec_espa == 1, 'url' => route('especialidad.show', ['espA', $this->encuesta->registro])],
                ['clave' => 'espF', 'etiqueta' => 'Sección F', 'completada' => $this->encuesta->sec_espf == 1, 'url' => route('especialidad.show', ['espF', $this->encuesta->registro])],
                ['clave' => 'espE', 'etiqueta' => 'Sección E', 'completada' => $this->encuesta->sec_espe == 1, 'url' => route('especialidad.show', ['espE', $this->encuesta->registro])],
                ['clave' => 'espC', 'etiqueta' => 'Sección C', 'completada' => $this->encuesta->sec_espc == 1, 'url' => route('especialidad.show', ['espC', $this->encuesta->registro])],
                ['clave' => 'espG', 'etiqueta' => 'Sección G', 'completada' => $this->encuesta->sec_espg == 1, 'url' => route('especialidad.show', ['espG', $this->encuesta->registro])],
            ],
            default => []
        };
    }
}