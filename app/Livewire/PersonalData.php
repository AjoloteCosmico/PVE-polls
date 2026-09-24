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
    public $typeStudy; 
    public $carrera;
    public $plantel;
    public $section = null; 
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

        $this->cargarContactos();


    }

    public function cargarContactos()
    {
        $this->telefonos = Telefono::where('cuenta', $this->egresado->cuenta)->get();
        $this->correos = Correo::where('cuenta', $this->egresado->cuenta)->get();
    }

   

    // --- TELÉFONO ---

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
            $tel->cuenta = $this->egresado->cuenta;
            $tel->telefono = $this->telefonoInput;
            $tel->descripcion = $this->telefonoDescripcion;
            $tel->status = 0;
            $tel->save();
            $mensaje = 'Teléfono agregado correctamente';
        }


        $this->showPhoneModal = false;
        $this->cargarContactos();
        $this->dispatch('swal:success', message: $mensaje);
    }



    
    // --- CORREO ---


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
            $correo->cuenta = $this->egresado->cuenta;
            $correo->correo = $this->correoInput;
            $correo->status = $this->correoStatus;
            $correo->descripcion = 'en Uso';
            $correo->save();
        }



        $this->showEmailModal = false;
        $this->cargarContactos();
        $this->dispatch('swal:success', message: 'Correo guardado y aviso enviado correctamente');

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