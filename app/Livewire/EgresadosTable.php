<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class EgresadosTable extends Component
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
        $query = DB::table('egresados')
            ->leftJoin('carreras', function($join){
                $join->on('carreras.clave_carrera', '=', 'egresados.carrera');
                $join->on('carreras.clave_plantel', '=', 'egresados.plantel');                                           
            })
            ->leftJoin('codigos', 'codigos.code', '=', 'egresados.status')

            //continua 
            ->leftJoin('egresado_muestra as em_continua', function($join) {
                $join->on('em_continua.egresado_id', '=', 'egresados.id')
                     ->where('em_continua.muestra_id', '=', 897);
            })
            ->leftJoin('codigos as c_continua', 'c_continua.code', '=', 'em_continua.status')

            //VERDE
            ->leftJoin('egresado_muestra as em_verde', function($join) {
                $join->on('em_verde.egresado_id', '=', 'egresados.id')
                    ->where('em_verde.muestra_id', '=', 898);
            })
            ->leftJoin('codigos as c_verde', 'c_verde.code', '=', 'em_verde.status')

            ->leftJoin('respuestas16', 'respuestas16.cuenta', '=', 'egresados.cuenta')
            ->leftJoin('users as u16', 'u16.clave', '=', 'respuestas16.aplica')
            ->leftJoin('respuestas20', 'respuestas20.cuenta', '=', 'egresados.cuenta')
            ->leftJoin('users as u20', 'u20.clave', '=', 'respuestas20.aplica')
            //->leftJoin('egresado_muestra', 'egresado_muestra.egresado_id', '=', 'egresados.id')
            ->select(
                'egresados.*',
                'carreras.carrera as nombre_carrera',
                'carreras.plantel as nombre_plantel',
                'codigos.description as estado_lic',
                'codigos.color_rgb as color_codigo',
                //campos continua
                //'egresado_muestra.status as estado_continua',
                //'c_continua.description as descripcion_continua',
                //'c_continua.color_rgb as color_continua',
                // Campos Muestra Continua
                'em_continua.status as status_continua',
                'c_continua.description as desc_continua',
                'c_continua.color_rgb as color_continua',
                'em_continua.egresado_id as es_continua',

                // Campos Muestra Verde
                'em_verde.status as status_verde',
                'c_verde.description as desc_verde',
                'c_verde.color_rgb as color_verde',
                'em_verde.egresado_id as es_verde',



                'respuestas16.updated_at as fecha_16', 
                'respuestas16.fec_capt as fechaFinal_16',
                'respuestas20.fec_capt as fechaFinal_20', 
                'respuestas20.updated_at as fecha_20', 
                'u16.name as aplicador16', 
                'u20.name as aplicador20', 
                'respuestas16.nbr2 as r16_nbr2', 
                'respuestas20.nbr2 as r20_nbr2', 
                'respuestas16.completed as r16_completed', 
                'respuestas20.completed as r20_completed', 
            );

            //2 metodos de busqueda

            if(!empty($this->nc)){
                $query->where('egresados.cuenta', 'LIKE', '%' . $this->nc . '%');
            }
            if (!empty($this->nombre_completo)) {
                $partes = explode(' ', mb_strtoupper($this->nombre_completo, 'UTF-8'));
                $query->where(function($q) use ($partes) {
                    foreach ($partes as $parte) {
                        $p = trim($parte);
                        if($p != "") {
                            $q->where(function($sub) use ($p) {
                                $sub->where('egresados.nombre', 'LIKE', "%{$p}%")
                                    ->orWhere('egresados.paterno', 'LIKE', "%{$p}%")
                                    ->orWhere('egresados.materno', 'LIKE', "%{$p}%");
                            });
                        }
                    }
                });
            }
            
            // --- NUEVA FUNCIONALIDAD: Filtro por Status ---
            if (!empty($this->filtro_status)) {
                $query->where('egresados.status', $this->filtro_status);
            }
            


            //->where('egresados.cuenta', 'LIKE', '%' . $this->nc . '%')
            //->orderBy('egresados.cuenta', 'asc')
            //->where('egresados.cuenta', 'LIKE', substr($this->nc, 0, 6) . '%')
            
            //->get();

            return view('livewire.egresados-table', [
                'egresados' => $query->orderBy('egresados.id', 'asc')
                                      ->paginate(15)
        ]);
    }
}