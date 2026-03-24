<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\respuestas16;

use App\Models\respuestas20;
use App\Models\respuestas14;
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

use Symfony\Component\Process\Process; 
use Symfony\Component\Process\Exception\ProcessFailedException; 


class HomeController extends Controller
{
    
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
    $stats20 = Respuesta20::where('completed', 1)
        ->where('gen_dgae', 2022)
        ->select('aplica', DB::raw('count(*) as total'))
        ->groupBy('aplica')
        ->pluck('total', 'aplica'); // Retorna un array [id_encuestador => total]

    $stats16 = Respuesta16::where('completed', 1)
        ->select('aplica', DB::raw('count(*) as total'))
        ->groupBy('aplica')
        ->pluck('total', 'aplica');

    // Mapeo de nombres (Esto podrías traerlo de una tabla 'users' o 'encuestadores' para que sea 100% dinámico)
    $nombresEncuestadores = [
        '17' => 'Erendira', '22' => 'Elizabeth', '23' => 'Sandra', 
        '25' => 'Amanda', '26' => 'Elizabeth Maldonado'
    ];

    $data20 = []; $data16 = []; $labels = [];
    foreach ($nombresEncuestadores as $id => $nombre) {
        $labels[] = $nombre;
        $data20[] = $stats20[$id] ?? 0;
        $data16[] = $stats16[$id] ?? 0;
    }

    $aplica_chart = LarapexChart::barChart()
        ->setTitle('Conteo por encuestador')
        ->addData('2022', $data20)
        ->addData('2016', $data16)
        ->setXAxis($labels);

    // 2. Nueva Gráfica: Encuestas por Semana (Año en curso)
    // Usamos YEARWEEK para agrupar fechas por semana de forma eficiente
    $encuestasSemanales = Respuesta20::where('completed', 1)
        ->whereYear('created_at', $currentYear)
        ->select(DB::raw('WEEK(created_at) as semana'), DB::raw('count(*) as total'))
        ->groupBy('semana')
        ->orderBy('semana')
        ->pluck('total', 'semana');

    $weeklyChart = LarapexChart::lineChart()
        ->setTitle("Encuestas Totales por Semana - $currentYear")
        ->addData('Encuestas', $encuestasSemanales->values()->toArray())
        ->setXAxis($encuestasSemanales->keys()->map(fn($s) => "Sem $s")->toArray());

    // 3. Totales y cálculos rápidos (Sin traer todos los modelos a memoria)
    $total22 = Respuesta20::where('completed', 1)->count();
    $total16 = Respuesta16::where('completed', 1)->count();
    $internet22 = Respuesta20::where('completed', 1)->whereIn('aplica', ['111', '104', '20'])->count();
    
    // Cálculo de requeridas optimizado (Haciendo el conteo en SQL, no en un loop de PHP)
    $realizadasPorCarrera = Respuesta20::where('completed', 1)
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

    return view('stats', compact(
        'aplica_chart', 'weeklyChart', 'total22', 'total16', 
        'internet22', 'requeridas' // agrega las demás variables necesarias
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

    public function enviar_encuesta($id_correo, $id_egresado,$telefono,$posgrado=null){
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
       
        return view('invitacion.encuesta_por_correo',compact('Egresado','Correo','Carrera','telefono','posgrado'));
    }
}

