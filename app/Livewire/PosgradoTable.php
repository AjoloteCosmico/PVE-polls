<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\DB;

class PosgradoTable extends Component
{
    use WithPagination;
    
    public $selecciones = [];

    //numero de cuenta
    public $nc ='';
    
    //nombre completo
    public $nombre_completo = '';

    //nueva funcionalidad filtro por estado
    public $filtro_status = '';

    protected $paginationTheme = 'bootstrap';

    // Agregamos esto para asegurar que el componente reaccione al buscador
    //protected $queryString = ['nc'];

    protected $queryString = [
        'nc' => ['except' => ''],
        'nombre_completo' => ['except' => ''],
        'filtro_status' => ['except' => '']
    ];

    // --- ESCUCHADORES DE EVENTOS GLOBALES ---
    #[On('filtrarPorCuenta')]
    public function aplicarFiltroCuenta($nc)
    {
        $this->nc = $nc;
        $this->resetPage();
    }

    #[On('filtrarPorNombre')]
    public function aplicarFiltroNombre($nombre_completo)
    {
        $this->nombre_completo = $nombre_completo;
        $this->resetPage();
    }

    public function updatingNc()
    {
        $this->resetPage();
    }

    public function updatingNombreCompleto()
    {
        $this->resetPage();
    }

    public function mount($nc =null, $nombre_completo = null)
    {
        $this->nc = $nc ?? '';
        $this->nombre_completo = $nombre_completo ?? '';
    }   

    public function seleccionarMuestra($id, $tipo)
    {
        $this->selecciones[$id] = $tipo;
    }

    public function render()
{
    // 1. Base principal: Catálogo unificado de cuentas de alumnos de posgrado y especialidad
    // Esto asegura que si está en una o en ambas, solo exista un registro base.
    $baseCuentas = DB::table('egresados_posgrado')
        ->select('cuenta', 'nombre', 'paterno', 'materno')
        ->union(
            DB::table('egresados_especialidad')
                ->select('cuenta', 'nombre', 'paterno', 'materno')
        );

    // 2. Consulta contenedora que une de forma HORIZONTAL ambos universos
    $query = DB::table(DB::raw("({$baseCuentas->toSql()}) as alumnos"))
        ->mergeBindings($baseCuentas) // Asegura que los parámetros del UNION no se rompan
        
        // --- JOIN UNIVERSO: POSGRADO ---
        ->leftJoin('egresados_posgrado as ep', 'ep.cuenta', '=', 'alumnos.cuenta')
        ->leftJoin('codigos as c_posgrado', function($join) {
            $join->on(DB::raw('CAST(c_posgrado.code AS TEXT)'), '=', DB::raw('CAST(ep.status AS TEXT)'));
        })
        ->leftJoin('respuestas_posgrado as rp', 'rp.cuenta', '=', 'alumnos.cuenta')
        // CORRECCIÓN POSTGRES: Cast de Clave y Aplica para evitar conflicto varchar = integer
        ->leftJoin('users as u_posgrado', function($join) {
            $join->on(DB::raw('CAST(u_posgrado.clave AS TEXT)'), '=', DB::raw('CAST(rp.aplica AS TEXT)'));
        })

        // --- JOIN UNIVERSO: ESPECIALIDAD ---
        ->leftJoin('egresados_especialidad as ee', 'ee.cuenta', '=', 'alumnos.cuenta')
        ->leftJoin('codigos as c_especialidad', function($join) {
            $join->on(DB::raw('CAST(c_especialidad.code AS TEXT)'), '=', DB::raw('CAST(ee.status AS TEXT)'));
        })
        ->leftJoin('respuestas_especialidad as re', 're.cuenta', '=', 'alumnos.cuenta')
        // CORRECCIÓN POSTGRES: Cast de Clave y Aplica para evitar conflicto varchar = integer
        ->leftJoin('users as u_especialidad', function($join) {
            $join->on(DB::raw('CAST(u_especialidad.clave AS TEXT)'), '=', DB::raw('CAST(re.aplica AS TEXT)'));
        })

        // Seleccionamos todo ordenado horizontalmente en la misma fila
        ->select(
            'alumnos.cuenta',
            'alumnos.nombre',
            'alumnos.paterno',
            'alumnos.materno',
            
            // Determinamos un origen por defecto para la vista inicial si está en ambos
            DB::raw("CASE WHEN ep.id IS NOT NULL THEN 'posgrado' ELSE 'especialidad' END as universo_origen"),
            
            // Datos específicos de Posgrado
            'ep.id as id_posgrado',
            'ep.anio_egreso as anio_posgrado',
            'ep.status as status_posgrado_num',
            'ep.programa as programa_posgrado',
            'ep.plan as plan_posgrado',
            'c_posgrado.description as estado_posgrado',
            'c_posgrado.color_rgb as color_posgrado',
            'rp.updated_at as fecha_posgrado',
            'rp.fec_capt as fechaFinal_posgrado',
            'u_posgrado.name as aplicador_posgrado',

            // Datos específicos de Especialidad
            'ee.id as id_especialidad',
            'ee.anio_egreso as anio_especialidad',
            'ee.status as status_especialidad_num',
            'ee.especialidad as programa_especialidad',
            'ee.car_carrer as plan_especialidad',
            'c_especialidad.description as estado_especialidad',
            'c_especialidad.color_rgb as color_especialidad'
        );

    // --- FILTROS DE BÚSQUEDA ---
    if (!empty($this->nc)) {
        $query->where('alumnos.cuenta', 'LIKE', trim($this->nc) . '%');
    } 
    elseif (!empty($this->nombre_completo)) {
        $partes = array_filter(explode(' ', mb_strtoupper(trim($this->nombre_completo), 'UTF-8')));

        if (count($partes) > 0) {
            $query->where(function($q) use ($partes) {
                foreach ($partes as $parte) {
                    $q->where(function($sub) use ($parte) {
                        $sub->where('alumnos.nombre', 'LIKE', "%{$parte}%")
                            ->orWhere('alumnos.paterno', 'LIKE', "%{$parte}%")
                            ->orWhere('alumnos.materno', 'LIKE', "%{$parte}%");
                    });
                }
            });
        }
    }

    // Filtro por estatus condicional adaptado a la fila unificada
    if (!empty($this->filtro_status)) {
        $query->where(function($q) {
            $q->where('ep.status', $this->filtro_status)
              ->orWhere('ee.status', $this->filtro_status);
        });
    }

    return view('livewire.egresados-posgrado-table', [
        'egresados' => $query->orderBy('alumnos.paterno', 'asc')->paginate(10)
    ]);
}

}   