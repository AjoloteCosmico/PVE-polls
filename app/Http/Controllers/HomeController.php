<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\respuestas16;

use App\Models\respuestas20;
use App\Models\respuestas14;

use App\Models\respuestasPosgrado;
use App\Models\Carrera;
use App\Models\Correo;
use DB;

use App\Models\User;
use App\Models\Estudio;
use App\Models\Egresado;
use App\Models\EgresadoPosgrado;
use App\Models\Muestra;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use ArielMejiaDev\LarapexCharts\Facades\LarapexChart;
use App\Traits\ChartDataProcessor;

use Symfony\Component\Process\Process; 
use Symfony\Component\Process\Exception\ProcessFailedException; 


class HomeController extends Controller
{
use ChartDataProcessor;
    
    public function index()
    {
        $nuevos_datos=DB::table('egresados')->where('muestra','=','3')->where('actualized','=','2025-06-19')
        ->leftJoin('codigos','codigos.code','=','egresados.status')
        ->leftJoin('carreras', function($join)
  {
      $join->on('carreras.clave_carrera', '=', 'egresados.carrera');
      $join->on('carreras.clave_plantel', '=', 'egresados.plantel');                             
  })
        ->select('egresados.*','codigos.color_rgb','codigos.description','carreras.carrera as name_carrera','carreras.plantel as name_plantel')
        ->get();

        return view('home',compact('nuevos_datos'));
    }
    
    public function optimized_stats(){
        
    if (!auth()->user()->can('ver_graficas')) {
        return redirect()->route('home')->with('error', 'No tienes acceso.');
    }

    $currentYear = Carbon::now()->year;

    // 1. Optimización de Conteo por Encuestador (Generalizado)
    // Agrupamos por el ID del encuestador ('aplica') y contamos en una sola query.
    $stats20 = respuestas20::where('completed', 1)
        ->where('gen_dgae', 2022)
        ->select('aplica', DB::raw('count(*) as total'))
        ->groupBy('aplica')
        ->pluck('total', 'aplica'); // Retorna un array [id_encuestador => total]

    $stats16 = respuestas16::where('completed', 1)
        ->select('aplica', DB::raw('count(*) as total'))
        ->groupBy('aplica')
        ->pluck('total', 'aplica');

    // Mapeo de nombres (Esto podrías traerlo de una tabla 'users' o 'encuestadores' para que sea 100% dinámico)
    $nombresEncuestadores = [
        '17' => 'Erendira','26' => 'Eli Maldonado',
        '27' => 'Alondra','28' => 'Ana K','29' => 'Alejandro',
        '23' => 'Sandra','25' => 'Amanda','22' => 'Eli Vazquez',
        '30' => 'Susana'
    ];

    $data20 = []; $data16 = []; $labels = [];
    foreach ($nombresEncuestadores as $id => $nombre) {
        $labels[] = $nombre;
        $data20[] = $stats20[$id] ?? 0;
        $data16[] = $stats16[$id] ?? 0;
    }



    // 3. Totales y cálculos rápidos (Sin traer todos los modelos a memoria)
    $total22 = respuestas20::where('completed', 1)->whereNull('aplica2')->where('gen_dgae', 2022)->count();
    
    $total16 = respuestas16::where('completed', 1)->count();
    $internet22 = respuestas20::where('completed', 1)
            ->whereNull('aplica2')
            ->where('gen_dgae', 2022)
            ->whereIn('aplica', ['111', '104', '20'])
            ->get()->count();
    
    // Cálculo de requeridas optimizado (Haciendo el conteo en SQL, no en un loop de PHP)
    $realizadasPorCarrera = respuestas20::where('completed', 1)
        ->where('gen_dgae', 2022)
        ->whereNull('aplica2')
        ->select('carrera', DB::raw('count(*) as total'))
        ->groupBy('carrera')
        ->pluck('total', 'carrera');
    $metas = DB::table('muestras')->where('estudio_id', '5')->get();
    $requeridas = $metas->sum(function($m) use ($realizadasPorCarrera) {
        return max(0, $m->requeridas_5 - ($realizadasPorCarrera[$m->carrera_id] ?? 0));
    });
   

    // ... (Repetir lógica similar para chart y chart16 con los nuevos totales)
    $internet=respuestas20::whereIn('aplica',['111','104','20'])->whereNull('aplica2')->where('gen_dgae', 2022)->count();
    $Internet16=respuestas16::where('completed','1')->where('aplica','111')->count();
    $telefonicas=$total22-$internet22;
    
    $telefonicas16=$total16-$Internet16;
    $Internet=respuestas20::where('completed','=',1)->where('gen_dgae', 2022)
    ->where('aplica','=',111)->get()->count();
    $queryBase = respuestas20::join('users','aplica','clave')
        ->where('completed','=',1)
        ->whereNull('aplica2')
        ->where('gen_dgae',2022);

    $chartName22 = $this->generateChartData($queryBase->whereNotIn('aplica',['104','105','20','30','31']), 'name', 'name');
    
    // GRAFICA DE STAKET DABRS POR ENCUESTADOR
    $labels = ['Act 2016', 'Seg 2022'];

    // Consultas de ejemplo: Obtener los totales agrupados por encuestador en cada periodo
    $encuestadores16 = DB::table('respuestas16')->join('users','aplica','clave')->where('completed', '=', 1)
                        ->select('name', DB::raw('count(*) as total'))->groupBy('name')->get();
    $encuestadores22 = DB::table('respuestas20')->join('users','aplica','clave')->whereNull('aplica2')
    ->where('completed', '=', 1)->where('gen_dgae', 2022)
    ->select('name', DB::raw('count(*) as total'))->groupBy('name')->get();

    // Unificamos los nombres de todos los encuestadores únicos involucrados
    $todosLosEncuestadores = $encuestadores16->pluck('name')
        ->merge($encuestadores22->pluck('name'))
        ->unique();

    $datasets = [];
    $paletaColores = [
        ['rgba(243, 156, 18, 0.7)', 'rgba(243, 156, 18, 1)'], 
        ['rgba(5, 63, 102, 0.7)', 'rgba(5, 63, 102, 1)'],   
        ['rgba(40, 167, 69, 0.7)', 'rgba(40, 167, 69, 1)'],   
        ['rgba(220, 53, 69, 0.7)', 'rgb(43, 7, 11)']  ,
         ['rgba(129, 86, 16, 0.7)', 'rgb(107, 68, 6)'], 
        ['rgba(13, 118, 189, 0.7)', 'rgb(22, 69, 100)'],   
        ['rgba(3, 99, 25, 0.7)', 'rgb(26, 65, 35)'],   
        ['rgba(199, 90, 101, 0.7)', 'rgb(85, 49, 53)']    
    ];
    
    $i = 0;
    foreach ($todosLosEncuestadores as $encuestador) {
        // Buscamos cuántas encuestas hizo en 2016 y en 2022
        $subtotal16 = $encuestadores16->firstWhere('name', $encuestador)->total ?? 0;
        $subtotal22 = $encuestadores22->firstWhere('name', $encuestador)->total ?? 0;

        $colorAsignado = $paletaColores[$i % count($paletaColores)];

        $datasets[] = [
            'label' => $encuestador ? $encuestador : 'Sin Asignar',
            'data' => [$subtotal16, $subtotal22], // Mismo orden que las $labels
            'backgroundColor' => $colorAsignado[0],
            'borderColor' => $colorAsignado[1],
            'borderWidth' => 1
        ];
        $i++;
    }
        // 1. Define tu query base limpia (sin selectRaw, solo los filtros de Eloquent)
    $queryWeekly22 = respuestas20::where('completed', '=', 1)
        ->whereNull('aplica2')
        ->where('gen_dgae', 2022);

    // 2. Le pasas la expresión de truncado de fecha directamente al Trait
    $chartWeekly22 = $this->generateChartData(
        $queryWeekly22,
        "date_trunc('week', fec_capt)",
        "to_char(date_trunc('week', fec_capt), 'YYYY-MM-DD')"
    );
   
    return view('stats', compact(
        'chartWeekly22', 'total22', 'total16', 'chartName22',
        'internet22', 'requeridas', 'internet', 'telefonicas','Internet16','telefonicas16','Internet',
        'labels', 'datasets'
        ));

    }

public function stats()
    {
        if (!auth()->user()->can('ver_graficas')) {
            return redirect()->route('home')->with('error', 'No tienes acceso.');
            }
            
        //2022
        $encuestas20=DB::table('respuestas20')
        ->select('respuestas20.*')
        ->where('completed','=',1)
        ->whereNull('aplica2')
        ->get();

        $carreras=DB::table('muestras')
        ->leftJoin('carreras', function($join)
                         {
                             $join->on('carreras.clave_carrera', '=', 'muestras.carrera_id');
                             $join->on('carreras.clave_plantel', '=', 'muestras.plantel_id');                             
                         })
        ->where('estudio_id','5')
        //->get()
        //nueva
        ->select(
        'muestras.*',
        'carreras.carrera as nombre_carrera',
        'carreras.plantel as nombre_plantel'
        )
        ->get();

        $requeridas = $carreras->sum(function ($carrera){
            $realizadas = DB::table('respuestas20')
                ->where('completed', '=', 1)
                ->where('gen_dgae', '=', 2022)
                ->whereNull('aplica2')
                ->where('carrera', '=', $carrera->carrera_id)
                ->count();
            return max(0, $carrera->requeridas_5 - $realizadas);
        });
        


        
        $internet=$encuestas20->whereIn('aplica',['111','104','20'])->count();
        $telefonicas=$encuestas20->count()-$internet;


        //grafica1 encuestas telefono vs internet de 2022
        $chart = LarapexChart::setTitle('Encuestas realizadas 2022')
        ->setColors(['#D1690E', '#D1330E','#D19914'])
            ->setLabels(['Realizadas por Internet','Realizadas Telefonica', 'Por hacer'])
            ->setDataset([$internet,$telefonicas, $requeridas]);

        


        //2016
        $encuestas16=DB::table('respuestas16')
        ->select('respuestas16.*')
        ->where('respuestas16.completed', '=',1)
        ->get();
        
        $requeridas16=Egresado::where('act_suvery','1')->count() - $encuestas16->count();
        $Internet16=respuestas16::where('completed','1')->where('aplica','111')->count();
        $telefonicas16= $encuestas16->count() -$Internet16;
    

        //grafica1.2 encuestas telefono vs internet de 2016
        $chart16 = LarapexChart::setTitle('Encuestas realizadas 2016')
        ->setColors(['#D1690E', '#D1330E','#D19914'])
            ->setLabels(['Realizadas por Internet','Realizadas Telefonica', 'Por hacer'])
            ->setDataset([$Internet16,$telefonicas16, $requeridas16]);

        $encuestas16=respuestas16::all();
        $encuestas20=respuestas20::where('completed','=',1)->get();


        #Grafica de encuestadores       
       $ere20 = respuestas20::where('completed', '=', 1)->where('gen_dgae', '=', 2022)->where('aplica', '=', '17')->count();
       $eli20 = respuestas20::where('completed', '=', 1)->where('gen_dgae', '=', 2022)->where('aplica', '=', '22')->count();
       $sandy20 = respuestas20::where('completed', '=', 1)->where('gen_dgae', '=', 2022)->where('aplica', '=', '23')->count();
       $amanda20 = respuestas20::where('completed', '=', 1)->where('gen_dgae', '=', 2022)->where('aplica', '=', '25')->count();
       $eliMal20 = respuestas20::where('completed', '=', 1)->where('gen_dgae', '=', 2022)->where('aplica', '=', '26')->count();
       
        $ere16=respuestas16::where('aplica', '=' ,'17')->count();
        $eli16=respuestas16::where('aplica', '=' ,'22')->count();
        $sandy16=respuestas16::where('aplica', '=' ,'23')->count();
        $amanda16=respuestas16::where('aplica', '=' ,'25')->count();
        
        $aplica_chart = LarapexChart::barChart()
        ->setTitle('Conteo por encuestador')
        ->setSubtitle('enc2022 vs enc2016 actualizacion')
         ->addData('2022', [ $ere20,$eli20,$sandy20,$amanda20,$eliMal20])
         ->addData('2016', [ $ere16,$eli16,$sandy16,$amanda16])
         ->setColors(['#D1690E', '#EB572F','#f3b87c'])
         ->setXAxis(['Erendira', 'Elizabeth', 'Sandra','Amanda','Elizabeth Maldonado']);

         //totales

        $total22=$encuestas20->count();
        $total16=$encuestas16->count();
        $Internet=respuestas20::where('completed','=',1)
        ->where('aplica','=',111)->get()->count();
        return view('stats',compact('encuestas20','carreras',
        'chart','chart16','aplica_chart','total22','total16','Internet',
         'Internet16'));
    }


    public function links()
    {
        return view('links');
    } 

    public function aviso(){
      
        return view('aviso');
    }

    public function invitacion($registro){
        $Egresado=respuestas14::find($registro);   
        return view('invitacion',compact('Egresado'));
   
      }
    public function invitacion19($id){
        $Egresado=Egresado::find($id);   
        $Carrera=Carrera::where('clave_carrera','=',$Egresado->carrera)->first()->carrera;
        $Plantel=Carrera::where('clave_plantel','=',$Egresado->plantel)->first()->plantel;
         
        return view('invitacion19',compact('Egresado','Carrera','Plantel'));
    }

    public function buscar(){
        return view('buscar');
    }
    
    public function resultado(Request $request){

        // --- 2. POSGRADO (Ajustado para campos INT) ---
    $egresados_posgrado = DB::table('egresados_posgrado')
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
            'egresados_posgrado.*', 'egresados_posgrado.cuenta as cuenta_posgrado', 'egresados_posgrado.programa as programa_posgrado', 'egresados_posgrado.plan as plan_posgrado', 'codigos.description as estado', 'codigos.color_rgb as color_codigo', 'respuestas_posgrado.updated_at as fecha_posgrado', 'respuestas_posgrado.fec_capt as fechaFinal_posgrado', 'respuestas_posgrado.completed as rpos20_completed', 'u_posgrado.name as aplicador_posgrado')
        ->where(DB::raw('CAST(egresados_posgrado.cuenta AS TEXT)'), 'LIKE', substr($request->nc, 0, 6) . '%')
        ->whereBetween('egresados_posgrado.anio_egreso', [2019, 2022])   
        ->get();      
        return view('resultado',[
        'egresados_posgrado' => $egresados_posgrado,
        'nc' => $request->nc,
        'nombre_completo' => null
    ]);
    }



    public function resultado_fonetico(Request $request){
        $nombre_completo = mb_strtoupper($request->nombre_completo, 'UTF-8');
        //$partes_nombre = explode(' ', $nombre_completo);  // Divide el nombre completo en palabras
        $partes_nombre = array_filter(explode(' ', $nombre_completo));

        // Obtener las partes necesarias
        $nombre = isset($partes_nombre[0]) ? $partes_nombre[0] : null;
        $segundo_nombre = isset($partes_nombre[1]) ? $partes_nombre[1] : null;
        $paterno = isset($partes_nombre[count($partes_nombre) - 2]) ? $partes_nombre[count($partes_nombre) - 2] : null;
        $materno = isset($partes_nombre[count($partes_nombre) - 1]) ? $partes_nombre[count($partes_nombre) - 1] : null;

        // Consulta para la tabla `egresados`
        
        // --- 2. POSGRADO ---
        $egresados_posgrado = DB::table('egresados_posgrado')
            ->leftJoin('codigos', function($join){
                $join->on(DB::raw('CAST(codigos.code AS TEXT)'), '=', DB::raw('CAST(egresados_posgrado.status AS TEXT)'));
            })
            ->leftJoin('respuestas_posgrado', function($join){
                $join->on(DB::raw('CAST(respuestas_posgrado.cuenta AS TEXT)'), '=', DB::raw('CAST(egresados_posgrado.cuenta AS TEXT)'));
            })
            ->leftJoin('users as u_posgrado', function($join){
                $join->on(DB::raw('CAST(u_posgrado.clave AS TEXT)'), '=', DB::raw('CAST(respuestas_posgrado.aplica AS TEXT)'));
            })
            ->select('egresados_posgrado.*', 'egresados_posgrado.cuenta as cuenta_posgrado', 'egresados_posgrado.programa as programa_posgrado', 'egresados_posgrado.plan as plan_posgrado', 'codigos.description as estado', 'codigos.color_rgb as color_codigo', 'respuestas_posgrado.updated_at as fecha_posgrado', 'respuestas_posgrado.fec_capt as fechaFinal_posgrado', 'respuestas_posgrado.completed as rpos20_completed', 'u_posgrado.name as aplicador_posgrado')
            ->where(function($query) use ($partes_nombre) {
                foreach ($partes_nombre as $parte) {
                    $query->where(function($subQuery) use ($parte) {
                        $subQuery->where('egresados_posgrado.nombre', 'LIKE', "%{$parte}%")
                                ->orWhere('egresados_posgrado.paterno', 'LIKE', "%{$parte}%")
                                ->orWhere('egresados_posgrado.materno', 'LIKE', "%{$parte}%");
                    });
                }
            })
            ->whereBetween('egresados_posgrado.anio_egreso', [2019, 2022])
            ->limit(50)
            ->get();

        
        return view('resultado', [
            'egresados_posgrado' => $egresados_posgrado,
            'nc' => null, 
            'nombre_completo' => $request->nombre_completo 
        ]);
    }

    public function enviar_aviso(Request $request){
      
           $caminoalpoder=public_path();
           $process = new Process([env('PY_COMAND'),$caminoalpoder.'/aviso.py',$request->nombre,$request->correo]);
           $process->run();
           if (!$process->isSuccessful()) {
               throw new ProcessFailedException($process);
           }
           $data = $process->getOutput();
           return redirect()->route('aviso');
    
    }
    
    public function enviar_invitacion(Request $request){

        $links = [
            2016 => "https://encuestas.pveaju.unam.mx/encuesta_actualizacion/2016",
            2020 => "https://encuestas.pveaju.unam.mx/encuesta_generacion/2020",
            2021 => "https://encuestas.pveaju.unam.mx/encuesta_generacion/2021",
            2022 => "https://encuestas.pveaju.unam.mx/encuesta_generacion/2022",
        ];
        

        // Determinar el script Python que se utilizará

        $scripts = [
            2016 => 'invitacion16.py',
            2020 => 'invitacion20.py',
            2021 => 'invitacion21.py',
            2022 => 'invitacion22.py',
        ];
        
        $anio = $request->anio;

        // Validar que el año tenga script y link definido
        if (!isset($scripts[$anio]) || !isset($links[$anio])) {
            return redirect()->back()->with('swal_warning', true);
            //return response()->json(['error' => 'Año no válido para la invitación.'], 400);
          
        }


        $scriptPath = public_path($scripts[$anio]);
        $link = $links[$anio];
        $python = env('PY_COMAND');

        $process = new Process([
            $python,
            $scriptPath,
            $request->nombre,
            $request->correo,
            $request->cuenta,
            $request->carrera,
            $request->plantel,
            $link
        ]);

        $process->run();

        if(!$process->isSuccessful()){
            throw new ProcessFailedException($process);
        }

        $output = $process->getOutput();

        $egresado = Egresado::where('cuenta', $request->cuenta)->first();

        return redirect()->route('act_data', [
            $request->cuenta,
            $request->carrera_clave,
            $request->anio,
            $request->telefono
        ]);
    }

    public function enviar_invitacion_conteo(Request $request) {
        $links_conteo = [
            897 => "https://encuestas.pveaju.unam.mx/encuesta_continua/inicio", 
            898 => "https://encuestas.pveaju.unam.mx/pveaju/resource/enc_verde_correo",     
        ];

        $scripts_conteo = [
            897 => 'invitacion_continiua.py',
            898 => 'invitacion_verde.py',
        ];

        $muestra_id = $request->muestra_id;

        if (!isset($links_conteo[$muestra_id])) {
        return redirect()->back()->with('swal_warning', true);
    }

    $scriptPath = public_path($scripts_conteo[$muestra_id]);
    $link = $links_conteo[$muestra_id];
    $python = env('PY_COMAND');

    // 3. Ejecutar el proceso de Python
    // Nota: Pasamos los mismos datos, pero el $link ya es el de la muestra de conteo
    $process = new Process([
        $python,
        $scriptPath,
        $request->nombre,
        $request->correo,
        $request->cuenta,
        $request->carrera,
        $request->plantel,
        $link
    ]);

    $process->run();

    if (!$process->isSuccessful()) {
        throw new ProcessFailedException($process);
    }
    $params = [
        $request->cuenta,
        $request->carrera_clave,
        $request->anio,
        $request->telefono
    ];

    if ($muestra_id == 898) {
        return redirect()->route('act_data_verde', $params);
    } 
    
    if ($muestra_id == 897) {
        return redirect()->route('act_data_continua', $params);
    }
}

 public function enviar_invitacion_posgrado(Request $request){
        
        $link =  "https://encuestas.pveaju.unam.mx/encuesta_posgrado";
        // Determinar el script Python que se utilizará

        $script= 'invitacion_posgrado.py';
        
        $anio = $request->anio;

        $scriptPath = public_path($script);

        $python = env('PY_COMAND');

        $process = new Process([
            $python,
            $scriptPath,
            $request->nombre,
            $request->cuenta,
            $request->plan,
            $request->programa,
            $request->correo,
        ]);

        $process->run();

        if(!$process->isSuccessful()){
            throw new ProcessFailedException($process);
        }

        $output = $process->getOutput();

        $egresado = EgresadoPosgrado::where('cuenta', $request->cuenta)->where('plan', $request->plan)->first();

        return redirect()->route('act_data_posgrado', [
            $request->cuenta,
            $request->programa,
            $request->plan,
            $request->telefono
        ]);

    }

    public function enviar_encuesta($id_correo, $id_egresado,$telefono, $extra = null){
        $posgrado = ($extra === 'posgrado') ? 'posgrado' : null;
        $muestra_id = (is_numeric($extra)) ? $extra : null;
        
        if($posgrado!='posgrado'){
            $Egresado=Egresado::find($id_egresado);   
            $Correo=Correo::find($id_correo);
            $Carrera = DB::table('carreras')
            ->where('clave_carrera', '=', $Egresado->carrera)
            ->where('clave_plantel', '=', $Egresado->plantel)
            ->first();  
        }else{
            $Egresado=EgresadoPosgrado::find($id_egresado);   
            $Correo=Correo::find($id_correo);
            $Carrera = '';

        }
        //$vista = ($muestra_id) ? 'invitacion.encuesta_por_correo_conteo' : 'invitacion.encuesta_por_correo';
       
        return view('invitacion.encuesta_por_correo', compact('Egresado', 'Correo', 'Carrera', 'telefono', 'posgrado', 'muestra_id'));
    }
}

