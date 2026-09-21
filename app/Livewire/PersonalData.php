<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Egresado;
use App\Models\Telefono;
use App\Models\Correo;
use Illuminate\Support\Collection;

class PersonalData extends Component
{
    // Datos del modelo principal
    public $egresado;
    public $encuesta;
    public $typeStudy; // 'esp', 'pos', 'seg', 'act', etc.
    public $carrera;
    public $plantel;
    public $section = null; // null si es encuesta SIN secciones
    public $tieneSecciones = false;


    public $telefonos = [];
    public $correos = [];

    // Propiedades reactive para Modals de Teléfono
    public $showPhoneModal = false;
    public $phoneId = null;
    public $telefonoInput = '';
    public $telefonoDescripcion = '';

    // Propiedades reactive para Modals de Correo
    public $showEmailModal = false;
    public $emailId = null;
    public $correoInput = '';
    public $correoStatus = '13'; // Default 'En uso'
    public $correoDescripcion = '';



   public function mount($egresado, $encuesta, $typeStudy, $carrera = null, $plantel = null, $section = null, $tieneSecciones = false)
    {
        $this->egresado = $egresado;
        $this->encuesta = $encuesta;
        $this->typeStudy = $typeStudy;
        $this->carrera = $carrera;
        $this->plantel = $plantel;
        $this->section = $section;
        $this->tieneSecciones = $tieneSecciones;


    }

   

    // --- ACCIONES REACTIVAS: TELÉFONO ---

    public function abrirModalTelefono($id = null)
    {
        $this->resetValidation();
        if ($id) {
            $tel = \App\Models\Telefono::findOrFail($id);
            $this->phoneId = $tel->id;
            $this->telefonoInput = $tel->telefono;
            $this->telefonoDescripcion = $tel->descripcion;
        } else {
            $this->phoneId = null;
            $this->telefonoInput = '';
            $this->telefonoDescripcion = '';
        }
        $this->showPhoneModal = true;
    }

    public function guardarTelefono()
    {
        $this->validate([
            'telefonoInput' => 'required|numeric',
        ]);

        \App\Models\Telefono::updateOrCreate(
            ['id' => $this->phoneId],
            [
                'cuenta' => $this->egresado->cuenta,
                'telefono' => $this->telefonoInput,
                'descripcion' => $this->telefonoDescripcion,
            ]
        );

        $this->showPhoneModal = false;
        $this->cargarContactos();
        $this->dispatch('swal:success', message: 'Teléfono guardado correctamente');
    }

    // --- ACCIONES REACTIVAS: CORREO ---

    public function abrirModalCorreo($id = null)
    {
        $this->resetValidation();
        if ($id) {
            $c = \App\Models\Correo::findOrFail($id);
            $this->emailId = $c->id;
            $this->correoInput = $c->correo;
            $this->correoStatus = $c->status ?? '13';
            $this->correoDescripcion = $c->descripcion;
        } else {
            $this->emailId = null;
            $this->correoInput = '';
            $this->correoStatus = '13';
            $this->correoDescripcion = '';
        }
        $this->showEmailModal = true;
    }

    public function guardarCorreo()
    {
        $this->validate([
            'correoInput' => 'required|email',
        ]);

        \App\Models\Correo::updateOrCreate(
            ['id' => $this->emailId],
            [
                'cuenta' => $this->egresado->cuenta,
                'correo' => $this->correoInput,
                'status' => $this->correoStatus,
                'descripcion' => $this->correoDescripcion,
            ]
        );

        $this->showEmailModal = false;
        $this->cargarContactos();
        $this->dispatch('swal:success', message: 'Correo guardado correctamente');
    }

    public function render()
    {
        $secciones = $this->tieneSecciones ? $this->obtenerSecciones() : [];

        return view('livewire.personal-data');
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