<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
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
        $query = DB::table('egresados_posgrado')
            ->leftJoin('codigos', function($join){
                $join->on(DB::raw('CAST(codigos.code AS TEXT)'), '=', DB::raw('CAST(egresados_posgrado.status AS TEXT)'));
            })
            ->leftJoin('respuestas_posgrado', function($join){
                $join->on(DB::raw('CAST(respuestas_posgrado.cuenta AS TEXT)'), '=', DB::raw('CAST(egresados_posgrado.cuenta AS TEXT)'));
            })
            ->leftJoin('users as u_posgrado', function($join){
                $join->on(DB::raw('CAST(u_posgrado.clave AS TEXT)'), '=', DB::raw('CAST(respuestas_posgrado.aplica AS TEXT)'));
            })
            ->select(
                'egresados_posgrado.*', 
                'egresados_posgrado.cuenta as cuenta_posgrado', 
                'egresados_posgrado.programa as programa_posgrado', 
                'egresados_posgrado.plan as plan_posgrado', 
                'codigos.description as estado', 
                'codigos.color_rgb as color_codigo', 
                'respuestas_posgrado.updated_at as fecha_posgrado', 
                'respuestas_posgrado.fec_capt as fechaFinal_posgrado', 
                'respuestas_posgrado.completed as rpos20_completed', 
                'u_posgrado.name as aplicador_posgrado'
            )
            ->whereBetween('egresados_posgrado.anio_egreso', [2019, 2022]
            );


            //2 metodos de busqueda

            if (!empty($this->nc)){
                $query->where(DB::raw('CAST(egresados_posgrado.cuenta AS TEXT)'), 'LIKE', substr($this->nc, 0, 6) . '%');
            }

            if (!empty($this->nombre_completo)) {
                $nombre_alto = mb_strtoupper($this->nombre_completo, 'UTF-8');
                $partes_nombre = array_filter(explode(' ', $nombre_alto));

                $query->where(function($q) use ($partes_nombre) {
                    foreach ($partes_nombre as $parte) {
                        $q->where(function($subQuery) use ($parte) {
                            $subQuery->where('egresados_posgrado.nombre', 'LIKE', "%{$parte}%")
                                    ->orWhere('egresados_posgrado.paterno', 'LIKE', "%{$parte}%")
                                    ->orWhere('egresados_posgrado.materno', 'LIKE', "%{$parte}%");
                        });
                    }
                });
            }
            return view('livewire.egresados-posgrado-table', [
                'egresados_posgrado' => $query->orderBy('egresados_posgrado.id', 'asc')->paginate(10)
            ]);


    }
}