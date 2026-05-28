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
        $queryPosgrado = DB::table('egresados_posgrado')
            ->leftJoin('codigos as c_posgrado', function($join){
                $join->on(DB::raw('CAST(c_posgrado.code AS TEXT)'), '=', DB::raw('CAST(egresados_posgrado.status AS TEXT)'));
            })
            ->leftJoin('respuestas_posgrado', function($join){
                $join->on(DB::raw('CAST(respuestas_posgrado.cuenta AS TEXT)'), '=', DB::raw('CAST(egresados_posgrado.cuenta AS TEXT)'));
            })
            ->leftJoin('users as u_posgrado', function($join){
                $join->on(DB::raw('CAST(u_posgrado.clave AS TEXT)'), '=', DB::raw('CAST(respuestas_posgrado.aplica AS TEXT)'));
            })
            /*
            // --- RELACIONES PARA ESPECIALIDAD ---
            ->leftJoin('egresados_especialidad', function($join){
                $join->on(DB::raw('CAST(egresados_especialidad.cuenta AS TEXT)'), '=', DB::raw('CAST(egresados_posgrado.cuenta AS TEXT)'));
            })
            ->leftJoin('codigos as c_especialidad', function($join){
                $join->on(DB::raw('CAST(c_especialidad.code AS TEXT)'), '=', DB::raw('CAST(egresados_especialidad.status AS TEXT)'));
            })
                */

            ->select(
                'egresados_posgrado.id as id_original',
                DB::raw("'posgrado' as universo_origen"), // Flag para saber de dónde viene originalmente
                'egresados_posgrado.nombre',
                'egresados_posgrado.paterno',
                'egresados_posgrado.materno',
                'egresados_posgrado.cuenta',
                'egresados_posgrado.anio_egreso',
                'egresados_posgrado.status as status_posgrado_num',
                'c_posgrado.description as estado_posgrado', 
                'c_posgrado.color_rgb as color_posgrado', 
                'respuestas_posgrado.updated_at as fecha_posgrado', 
                'respuestas_posgrado.fec_capt as fechaFinal_posgrado', 
                'u_posgrado.name as aplicador_posgrado',

                // Columnas espejo vacías para Especialidad (para que cuadre el UNION)
                DB::raw('NULL as id_especialidad'),
                DB::raw('NULL as status_especialidad_num'),
                DB::raw('NULL as programa_especialidad'),
                DB::raw('NULL as plan_especialidad'),
                DB::raw('NULL as estado_especialidad'),
                DB::raw('NULL as color_especialidad')
                //'egresados_posgrado.*', 
                //'egresados_posgrado.cuenta as cuenta_posgrado', 
                //'egresados_posgrado.programa as programa_posgrado', 
                //'egresados_posgrado.plan as plan_posgrado', 

                
                // Campos de respuesta y estatus: POSGRADO
                //'c_posgrado.description as estado_posgrado', 
                //'c_posgrado.color_rgb as color_posgrado', 
                //'respuestas_posgrado.updated_at as fecha_posgrado', 
                //'respuestas_posgrado.fec_capt as fechaFinal_posgrado', 
                //'respuestas_posgrado.completed as rpos20_completed', 
                //'u_posgrado.name as aplicador_posgrado',

                // Campos de respuesta y estatus: ESPECIALIDAD
                //'egresados_especialidad.id as es_especialidad',
                //'egresados_especialidad.status as status_especialidad_num',
                //'egresados_especialidad.especialidad as programa_especialidad',
                //'egresados_especialidad.car_carrer as plan_especialidad'    ,
                // 'c_especialidad.description as estado_especialidad',
                //'c_especialidad.color_rgb as color_especialidad'
            )
            ->whereBetween('egresados_posgrado.anio_egreso', [2019, 2022]
            );
            $queryEspecialidad = DB::table('egresados_especialidad')
                ->leftJoin('codigos as c_especialidad', function($join){
                    $join->on(DB::raw('CAST(c_especialidad.code AS TEXT)'), '=', DB::raw('CAST(egresados_especialidad.status AS TEXT)'));
                })
                ->leftJoin('respuestas_especialidad', function($join){
                    $join->on(DB::raw('CAST(respuestas_especialidad.cuenta AS TEXT)'), '=', DB::raw('CAST(egresados_especialidad.cuenta AS TEXT)'));
                })
                ->leftJoin('users as u_especialidad', function($join){
                    $join->on(DB::raw('CAST(u_especialidad.clave AS TEXT)'), '=', DB::raw('CAST(respuestas_especialidad.aplica AS TEXT)'));
                })
                
                ->select(
                    'egresados_especialidad.id as id_original',
                    DB::raw("'especialidad' as universo_origen"),
                    'egresados_especialidad.nombre',
                    'egresados_especialidad.paterno',
                    'egresados_especialidad.materno',
                    'egresados_especialidad.cuenta',
                    'egresados_especialidad.anio_egreso',

                    // Columnas espejo vacías para Posgrado
                    DB::raw('NULL as status_posgrado_num'),
                    DB::raw('NULL as estado_posgrado'),
                    DB::raw('NULL as color_posgrado'),
                    DB::raw('NULL as fecha_posgrado'),
                    DB::raw('NULL as fechaFinal_posgrado'),
                    DB::raw('NULL as aplicador_posgrado'),

                    // Columnas reales de Especialidad mapeadas de tu imagen
                    'egresados_especialidad.id as id_especialidad',
                    'egresados_especialidad.status as status_especialidad_num',
                    'egresados_especialidad.especialidad as programa_especialidad', 
                    'egresados_especialidad.car_carrer as plan_especialidad',      
                    'c_especialidad.description as estado_especialidad',
                    'c_especialidad.color_rgb as color_especialidad'

                )
                ->where('egresados_especialidad.created_at', '<', '2026-05-01');


            //2 metodos de busqueda

            if (!empty($this->nc)) {
                //$query->where(DB::raw('CAST(egresados_posgrado.cuenta AS TEXT)'), 'LIKE', trim($this->nc) . '%');
                $cuentaBusqueda = trim($this->nc) . '%';
                $queryPosgrado->where(DB::raw('CAST(egresados_posgrado.cuenta AS TEXT)'), 'LIKE', $cuentaBusqueda);
                $queryEspecialidad->where(DB::raw('CAST(egresados_especialidad.cuenta AS TEXT)'), 'LIKE', $cuentaBusqueda);
            } 
            elseif (!empty($this->nombre_completo)) {
                $nombre_alto = mb_strtoupper(trim($this->nombre_completo), 'UTF-8');
                $partes_nombre = array_filter(explode(' ', $nombre_alto));

                if(count($partes_nombre) >0) {
                    foreach ([$queryPosgrado, $queryEspecialidad] as $query) {
                        $query->where(function($mainQ) use ($partes_nombre) {
                            foreach ($partes_nombre as $parte) {
                                $mainQ->where(function($sub) use ($parte) {
                                    $sub->where('nombre', 'LIKE', "%{$parte}%")
                                             ->orWhere('paterno', 'LIKE', "%{$parte}%")
                                             ->orWhere('materno', 'LIKE', "%{$parte}%");
                                });
                            }
                        });
                    }
                }
                
                /*
                if (count($partes_nombre) > 0) {
                    $query->where(function($q) use ($partes_nombre) {
                        foreach ($partes_nombre as $parte) {
                            $q->where(function($subQuery) use ($parte) {
                                $subQuery->where('egresados_posgrado.nombre', 'LIKE', "%{$parte}%")
                                         ->orWhere('egresados_posgrado.paterno', 'LIKE', "%{$parte}%")
                                         ->orWhere('egresados_posgrado.materno', 'LIKE', "%{$parte}%");
                                });
                            }
                    });
                }*/

            }
            // 4. FILTRO DE STATUS GLOBAL (Se evalúa dependiendo del origen)
            if (!empty($this->filtro_status)) {
                $queryPosgrado->where('egresados_posgrado.status', $this->filtro_status);
                $queryEspecialidad->where('egresados_especialidad.status', $this->filtro_status);
            }

            // 5. UNIFICACIÓN DE DATOS (UNION)
            // Creamos una subconsulta a partir del UNION para poder ordenar y paginar correctamente
            $queryFinal = $queryPosgrado->unionAll($queryEspecialidad);

            $resultadoPaginado = DB::table(DB::raw("({$queryFinal->toSql()}) as universo_egresados"))
                ->mergeBindings($queryFinal) // Pasamos todos los parámetros de los WHERE (fechas, años, búsquedas)
                ->orderBy('nombre', 'asc')
                ->paginate(15);

            return view('livewire.egresados-posgrado-table', [
                'egresados_posgrado' => $resultadoPaginado
            ]);


    }

}   