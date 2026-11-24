<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use App\Models\Egresado;
use App\Models\Telefono;
use App\Models\Correo;
use App\Traits\EnviaAvisoPrivacidad;
use Illuminate\Support\Collection;


class PersonalData extends Component
{
    use EnviaAvisoPrivacidad;
    // Datos del modelo principal
    public $egresado;
    public $encuesta;
    public $typeStudy;
    public $plan;
    public $programa; 
    public $carrera;
    public $plantel;
    public $section = null; 
    public $tieneSecciones = false;




   public function mount($egresado, $encuesta, $typeStudy, $carrera = null, $plantel = null, $section = null, $tieneSecciones = false)
    {
        $this->egresado = $egresado;
        $this->encuesta = $encuesta;
        $this->typeStudy = $typeStudy;
        $this->carrera = $carrera;
        $this->plantel = $plantel;
        $this->section = $section;
        $this->tieneSecciones = $tieneSecciones;

        //$this->cargarContactos();


    }

    #[Computed]
    public function telefonos()
    {
        return Telefono::where('cuenta', $this->egresado->cuenta)->get();
    }

    #[Computed]
    public function correos()
    {
        return Correo::where('cuenta', $this->egresado->cuenta)->get();
    }

    #[On('contactoActualizado')]
    public function refrescar()
    {
        // vacío: el evento fuerza el render
    }




    // Método  para cerrar modals
    public function cerrarModal()
    {
        $this->showPhoneModal = false;
        $this->showEmailModal = false;
        $this->resetValidation();
    }




    public function render()
    {
        $secciones = $this->tieneSecciones ? $this->obtenerSecciones() : [];

        return view('livewire.personal-data', [
            'secciones' => $secciones,
        ]);
    }

    private function obtenerSecciones()
    {
        // Mapea las secciones según el tipo de estudio sin enredar la vista Blade
        return match($this->typeStudy) {
            'seg' => [
                ['clave' => 'A', 'etiqueta' => 'Sección A', 'completada' => $this->encuesta->sec_a == 1, 'url' => route('edit_22', [$this->encuesta->registro, 'A'])],
                ['clave' => 'E', 'etiqueta' => 'Sección E', 'completada' => $this->encuesta->sec_e == 1, 'url' => route('edit_22', [$this->encuesta->registro, 'E'])],
                ['clave' => 'F', 'etiqueta' => 'Sección F', 'completada' => $this->encuesta->sec_f == 1, 'url' => route('edit_22', [$this->encuesta->registro, 'F'])],
                ['clave' => 'C', 'etiqueta' => 'Sección C', 'completada' => $this->encuesta->sec_c == 1, 'url' => route('edit_22', [$this->encuesta->registro, 'C'])],
                ['clave' => 'D', 'etiqueta' => 'Sección D', 'completada' => $this->encuesta->sec_d == 1, 'url' => route('edit_22', [$this->encuesta->registro, 'D'])],
                ['clave' => 'G', 'etiqueta' => 'Sección G', 'completada' => $this->encuesta->sec_g == 1, 'url' => route('edit_22', [$this->encuesta->registro, 'G'])],
            ],
            'posgrado' => [
                ['clave' => 'pA', 'etiqueta' => 'Sección A', 'completada' => ($this->encuesta->sec_pa ?? 0) == 1, 'url' => route('posgrado.show', ['pA', $this->encuesta->registro])],
                ['clave' => 'pB', 'etiqueta' => 'Sección B', 'completada' => ($this->encuesta->sec_pb ?? 0) == 1, 'url' => route('posgrado.show', ['pB', $this->encuesta->registro])],
                ['clave' => 'pC', 'etiqueta' => 'Sección C', 'completada' => ($this->encuesta->sec_pc ?? 0) == 1, 'url' => route('posgrado.show', ['pC', $this->encuesta->registro])],
                ['clave' => 'pD', 'etiqueta' => 'Sección D', 'completada' => ($this->encuesta->sec_pd ?? 0) == 1, 'url' => route('posgrado.show', ['pD', $this->encuesta->registro])],
                ['clave' => 'pE', 'etiqueta' => 'Sección E', 'completada' => ($this->encuesta->sec_pe ?? 0) == 1, 'url' => route('posgrado.show', ['pE', $this->encuesta->registro])],
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