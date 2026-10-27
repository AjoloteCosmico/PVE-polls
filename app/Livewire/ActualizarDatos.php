<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Egresado;
use App\Models\Telefono;
use App\Models\Correo;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\DB;

class ActualizarDatos extends Component
{
    public $egresado;
    public $telefonoEnLlamada;
    public $carrera;
    public $plantel;
    public $gen;
    public $typeStudy;

    //public $telefonos = [];
    //public $correos = [];

    public function mount($egresado, $telefonoEnLlamada, $carrera = null, $plantel = null, $gen, $typeStudy)
    {
        $this->egresado = $egresado;
        $this->telefonoEnLlamada = $telefonoEnLlamada;
        $this->carrera = $carrera;
        $this->plantel = $plantel;
        $this->gen = $gen;
        $this->typeStudy = $typeStudy;

        //$this->cargarContactos();
    }

    #[Computed]
    public function telefonos()
    {
        return DB::table('telefonos')
            ->where('telefonos.cuenta', $this->egresado->cuenta)
            ->leftJoin('codigos', 'codigos.code', '=', 'telefonos.status')
            ->select('telefonos.*', 'codigos.description as status_description')
            ->orderBy('telefonos.id')
            ->get();
    }

    #[Computed]
    public function correos()
    {
        return Correo::where('correos.cuenta', $this->egresado->cuenta)
            ->leftJoin('codigos', 'codigos.code', '=', 'correos.status')
            ->select('correos.*', 'codigos.description as status_description')
            ->get();
    }

    //#[On('contactoActualizado')]
    //public function cargarContactos()
    //{
    //    $this->telefonos = Telefono::where('cuenta', $this->egresado->cuenta)->get();
    //    $this->correos = Correo::where('cuenta', $this->egresado->cuenta)->get();
    //}

    #[On('contactoActualizado')]
    public function refrescar()
    {
        unset($this->telefonos);
        unset($this->correos);
        // vacío a propósito: el evento fuerza el re-render y las computadas se reconsultan
    }


    public function config(): array
    {
        return match ($this->typeStudy) {
            'act' => [ 
                    'mailType' => 'act_encuesta',
                    'permiso'  => 'aplicar_encuesta_actualizacion',
                    'comenzar' => 'comenzar_encuesta_2018',
                    'muestraRoute' => route('muestras16.show', [$this->egresado->carrera, $this->egresado->plantel]),
                    'botonReturn' => route('llamar', [2018, $this->egresado->cuenta, $this->egresado->carrera])
                ],
            'seg' => [
                    'mailType' => 'correo_seg_22',
                    'permiso'  => 'aplicar_encuesta_seguimiento',
                    'comenzar' => 'comenzar_encuesta_2022',
                    'muestraRoute' => route('muestras22.show22', [$this->egresado->carrera, $this->egresado->plantel]),
                    'botonReturn' => route('llamar', [2022, $this->egresado->cuenta, $this->egresado->carrera])
            ],

             'ed_continua' => [
                    'mailType' => 'correo_seg_22',
                    'permiso'  => 'aplicar_encuesta_seguimiento',
                    'comenzar' => 'comenzar_encuesta_2022',
                    'muestraRoute' => route('muestras.show_unificado', [$this->egresado->carrera, $this->egresado->plantel, 897]),
                    'botonReturn' => route('llamar_continua', [$this->egresado->anio_egreso, $this->egresado->cuenta, $this->egresado->carrera, 897])
            ],

            'encuesta_verde' => [
                    'mailType' => 'correo_seg_22',
                    'permiso'  => 'aplicar_encuesta_seguimiento',
                    'comenzar' => 'comenzar_encuesta_2022',
                    'muestraRoute' => route('muestras.show_unificado_verde', [$this->egresado->carrera, $this->egresado->plantel, 898]),
                    'botonReturn' => route('llamar_verde', [$this->egresado->anio_egreso, $this->egresado->cuenta, $this->egresado->carrera, 898])
            ],

            'credencial' => [
                    'mailType' => 'correo_seg_22',
                    'permiso'  => 'aplicar_encuesta_seguimiento',
                    'comenzar' => 'comenzar_encuesta_2022',
                    'muestraRoute' => route('muestras.show_unificado', [$this->egresado->carrera, $this->egresado->plantel, 899]),
                    'botonReturn' => route('llamar_credencial', [$this->egresado->anio_egreso, $this->egresado->cuenta, $this->egresado->carrera, 899])
            ],

            'posgrado' => [
                'mailType' => 'posgrado',
                'permiso'  => 'aplicar_encuesta_posgrado',
                'comenzar' => 'comenzar_encuesta_posgrado',
                'muestraRoute' => '#',
            ],
            'esp' => [
                'mailType' => 'especialidad',
                'permiso'  => 'aplicar_encuesta_posgrado',
                'comenzar' => 'comenzar_encuesta_especialidad',
                'muestraRoute' => '#',
            ],
            default => ['mailType' => null, 'permiso' => null, 'comenzar' => null, 'muestraRoute' => '#'],
        };
    }

    public function render()
    {
        return view('livewire.actualizar-datos', [
            'config' => $this->config(),
        ]);
    }
}