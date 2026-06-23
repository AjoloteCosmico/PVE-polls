<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\respuestas16;

use App\Models\respuestas20;
use App\Models\respuestas14;

use App\Models\respuestas_verdes;
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
         $currentYear = Carbon::now()->year;

    // ========== 1. Conteo por encuestador (barras simples por encuestador - chartName22) ==========
    $queryBase22 = respuestas20::join('users', 'aplica', 'clave')
        ->where('completed', 1)
        ->whereNull('aplica2')
        ->where('gen_dgae', 2022)
        ->whereNotIn('aplica', ['104','105','20','30','31']);
    $chartName22 = $this->generateChartData($queryBase22, 'name', 'name');

    // ========== 2. Totales y cálculos rápidos ==========
    // Consultas optimizadas con agregados condicionales para evitar múltiples viajes
    $stats = respuestas20::where('completed', 1)
        ->where('gen_dgae', 2022)
        ->whereNull('aplica2')
        ->selectRaw("
            count(*) as total22,
            count(*) filter (where aplica in ('111','104','20')) as internet22,
            count(*) filter (where aplica =' 111') as internet_111
        ")
        ->first();

    $total22 = $stats->total22;
    $internet22 = $stats->internet22;
    $telefonicas22 = $total22 - $internet22;
    $internetTotal = $stats->internet_111; // Aplicaciones internet de tipo 111

    // Para 2016
    $stats16 = respuestas16::where('completed', 1)
        ->selectRaw("
            count(*) as total16,
            count(*) filter (where aplica = '111') as internet16
        ")
        ->first();

    $total16 = $stats16->total16;
    $internet16 = $stats16->internet16;
    $telefonicas16 = $total16 - $internet16;

    // Cálculo de requeridas (sin cargar todos los modelos a memoria)
    $realizadasPorCarrera = respuestas20::where('completed', 1)
        ->where('gen_dgae', 2022)
        ->whereNull('aplica2')
        ->select('carrera', DB::raw('count(*) as total'))
        ->groupBy('carrera')
        ->pluck('total', 'carrera');

    $metas = DB::table('muestras')->where('estudio_id', '5')->get();
    $requeridas = $metas->sum(function ($m) use ($realizadasPorCarrera) {
        return max(0, $m->requeridas_5 - ($realizadasPorCarrera[$m->carrera_id] ?? 0));
    });
    $requeridas16=Egresado::where('act_suvery',1)->count();
    // ========== 3. Gráfica apilada por encuestador (migrada al trait) ==========
    $query16Enc = DB::table('respuestas16')
        ->join('users', 'aplica', 'clave')
        ->where('completed', 1);
    $query22Enc = DB::table('respuestas20')
        ->join('users', 'aplica', 'clave')
        ->whereNull('aplica2')
        ->where('completed', 1)
        ->where('gen_dgae', 2022);
    $queryPosEnc = DB::table('respuestas_posgrado')
    ->join('users', function ($join) {
        $join->on(DB::raw('CAST(respuestas_posgrado.aplica AS varchar)'), '=', 'users.clave');
    })
    ->where('respuestas_posgrado.completed', '1')
    ->whereIn('respuestas_posgrado.anio_egreso', [2019, 2020, 2021, 2022]);
    $paletaColores = [
        ['rgba(243, 156, 18, 0.7)', 'rgba(243, 156, 18, 1)'],
        ['rgba(5, 63, 102, 0.7)', 'rgba(5, 63, 102, 1)'],
        ['rgba(40, 167, 69, 0.7)', 'rgba(40, 167, 69, 1)'],
        ['rgba(220, 53, 69, 0.7)', 'rgb(43, 7, 11)'],
        ['rgba(129, 86, 16, 0.7)', 'rgb(107, 68, 6)'],
        ['rgba(13, 118, 189, 0.7)', 'rgb(22, 69, 100)'],
        ['rgba(3, 99, 25, 0.7)', 'rgb(26, 65, 35)'],
        ['rgba(199, 90, 101, 0.7)', 'rgb(85, 49, 53)'],
    ];

    $stackedEnc = $this->generateStackedBarByCategoryAcrossPeriods(
        [$query16Enc, $query22Enc,$queryPosEnc],
        'name',
        ['Act 2016', 'Seg 2022','Posgrado'],
        $paletaColores
    );

    // ========== 4. Gráfica semanal multilínea (todos los estudios) ==========
    $seriesSemanales = [
        [
            'query'       => respuestas20::where('completed', '1')->whereNull('aplica2')->where('gen_dgae', 2022),
            'label'       => 'Respuestas 2022',
            'color'       => 'rgba(54, 162, 235, 0.2)',
            'borderColor' => 'rgba(54, 162, 235, 1)',
        ],
        [
            'query'       => respuestas16::where('completed', '1'),
            'label'       => 'Respuestas 2016',
            'color'       => 'rgba(255, 99, 132, 0.2)',
            'borderColor' => 'rgba(255, 99, 132, 1)',
        ],
        [
            // Asumiendo modelo RespuestasPosgrado con campo fec_capt
            'query'       => respuestasPosgrado::where('completed', '1')->whereIn('anio_egreso',[2019,2020,2021,2022]),
            'label'       => 'Posgrado',
            'color'       => 'rgba(75, 192, 192, 0.2)',
            'borderColor' => 'rgba(75, 192, 192, 1)',
        ],
        [
            // Asumiendo modelo RespuestasVerdes con campo fec_capt
            'query'       => respuestas_verdes::whereNotNull('vr1'),
            'label'       => 'Verdes',
            'color'       => 'rgba(153, 102, 255, 0.2)',
            'borderColor' => 'rgba(153, 102, 255, 1)',
        ],
    ];

    $chartWeeklyAll = $this->generateMultiSeriesChartData(
        "date_trunc('week', updated_at)",
        "to_char(date_trunc('week', updated_at), 'YYYY-MM-DD')",
        $seriesSemanales
    );
      // ========== 2. Totales y cálculos rápidos ==========
    // Consultas optimizadas con agregados condicionales para evitar múltiples viajes
    $stats = respuestas20::where('completed', 1)
        ->where('gen_dgae', 2022)
        ->whereNull('aplica2')
        ->selectRaw("
            count(*) as total22,
            count(*) filter (where aplica in ('111','104','20')) as internet22,
            count(*) filter (where aplica =' 111') as internet_111
        ")
        ->first();

    $total22 = $stats->total22;
    $internet22 = $stats->internet22;
    $telefonicas22 = $total22 - $internet22;
    $internetTotal = $stats->internet_111; // Aplicaciones internet de tipo 111

    // Para 2016
    $stats16 = respuestas16::where('completed', 1)
        ->selectRaw("
            count(*) as total16,
            count(*) filter (where aplica = '111') as internet16
        ")
        ->first();

    $total16 = $stats16->total16;
    $internet16 = $stats16->internet16;
    $telefonicas16 = $total16 - $internet16;

    // Cálculo de requeridas (sin cargar todos los modelos a memoria)
    $realizadasPorCarrera = respuestas20::where('completed', 1)
        ->where('gen_dgae', 2022)
        ->whereNull('aplica2')
        ->select('carrera', DB::raw('count(*) as total'))
        ->groupBy('carrera')
        ->pluck('total', 'carrera');

    $metas = DB::table('muestras')->where('estudio_id', '5')->get();
    $requeridas = $metas->sum(function ($m) use ($realizadasPorCarrera) {
        return max(0, $m->requeridas_5 - ($realizadasPorCarrera[$m->carrera_id] ?? 0));
    });
    $requeridas16=Egresado::where('act_suvery',1)->count();
$Internet=respuestas20::whereIn('aplica',['111','104','20','105'])
    ->whereNull('aplica2')->where('gen_dgae', 2022)->get()->count();
    $Internet16=respuestas16::where('completed','1')->where('aplica','111')->count();
    $requeridas = $metas->sum(function($m) use ($realizadasPorCarrera) {
        return max(0, $m->requeridas_5 - ($realizadasPorCarrera[$m->carrera_id] ?? 0));
    });
   
    $telefonicas=$total22-$internet22;

    // ========== DATOS PARA POSGRADO =================
    $InternetPos=respuestasPosgrado::whereIn('aplica',['111','104','20','105'])
    ->whereIn('anio_egreso', [2019,2020,2021,2022])
    ->where('completed','1')->get()->count();
    $TotalPos=respuestasPosgrado::whereIn('anio_egreso', [2019,2020,2021,2022])
    ->where('completed','1')
    ->get()->count();
    $telefonicasPos=$TotalPos-$InternetPos;

    $requeridasPos=EgresadoPosgrado::whereIn('anio_egreso', [2019,2020,2021,2022])
    ->where('fuente','base original')->get()->count();


        return view('home',compact('chartWeeklyAll','stackedEnc','chartName22',
        'Internet16','telefonicas16','requeridas16' ,
        'InternetPos','telefonicasPos', 'requeridasPos','total16',
        'Internet','telefonicas', 'requeridas','Internet','total22','TotalPos'));
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


    public function enviar_aviso(Request $request){
            
        $correoBD = DB::table('correos')->where('correo', $request->correo)->first();

        if ($correoBD) {
            $emailId = $correoBD->id; // Encontró el registro, tomamos su ID (int4)
        } else {
            // OPCIÓN A: Si el correo no existe en el sistema, detenemos el proceso con un error
            return redirect()->back()->with('error', 'El correo ingresado no está registrado en el sistema.');
            
            // OPCIÓN B: Si prefieres que se envíe de todos modos aunque no exista en tu catálogo, 
            // puedes asignarle un ID genérico/falso temporal (por ejemplo, 0) descomentando la siguiente línea:
            // $emailId = 0; 
        }

        $this->enviarAviso($emailId, $request->correo, $request->nombre);
        return redirect()->route('aviso'); 
            
        
       /* 
            $tracking_id = (string) \Str::uuid();
            $ahora = now();
            
            DB::table('email_tracking')->insert([
                'email_id' => $emailId,
                'recipient_email' => $request->correo,
                'tracking_uuid' => $tracking_id,
                'type' => 'aviso',
                'created_at' => $ahora,
                'sended_at' => $ahora,
                'updated_at' => $ahora,
            ]);
           $caminoalpoder=public_path();
           $process = new Process([
                env('PY_COMAND'),
                $caminoalpoder.'/aviso.py',
                $request->nombre,
                $request->correo,
                $tracking_id
            ]);
           $process->run();
           if (!$process->isSuccessful()) {
               throw new ProcessFailedException($process);
           }
           $data = $process->getOutput();
           return redirect()->route('aviso');

        */
    
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

