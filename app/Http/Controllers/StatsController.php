<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\respuestas16;

use App\Models\respuestas20;
use App\Models\respuestas14;

use App\Models\respuestas_verdes;
use App\Models\respuestasPosgrado;
use App\Models\respuestasEspecialidad;
use App\Models\RespuestasContinua;
use App\Models\RespuestasVerdes;
use App\Models\Carrera;
use App\Models\Correo;
use App\Models\Event;
use App\Models\Recado;
use App\Models\EmailTracking;
use DB;

use App\Mail\ReportMail;
use Illuminate\Support\Facades\Mail;

use App\Models\User;
use App\Models\Estudio;
use App\Models\Egresado;
use App\Models\EgresadoPosgrado;
use App\Models\Muestra;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use App\Traits\ChartDataProcessor;

use Symfony\Component\Process\Process; 
use Symfony\Component\Process\Exception\ProcessFailedException; 

class StatsController extends Controller
{
   use ChartDataProcessor;
   public function optimized_stats()
{
    if (!auth()->user()->can('ver_graficas')) {
        return redirect()->route('home')->with('error', 'No tienes acceso.');
    }

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
        [
            // Asumiendo modelo RespuestasVerdes con campo fec_capt
            'query'       => respuestasEspecialidad::where('completed','1'),
            'label'       => 'Epecialidad',
            'color'       => 'rgba(176, 143, 26, 0.2)',
            'borderColor' => 'rgb(248, 192, 51)',
        ],
        
    ];

    $chartWeeklyAll = $this->generateMultiSeriesChartData(
        "date_trunc('week', updated_at)",
        "to_char(date_trunc('week', updated_at), 'YYYY-MM-DD')",
        $seriesSemanales
    );
    // ========== 4. Gráfica semanal multilínea (email tracking) ==========
    $seriesEnvios = [
        [
            'query'       => EmailTracking::where('type', 'aviso'),
            'label'       => 'Aviso',
            'color'       => 'rgba(54, 162, 235, 0.2)',
            'borderColor' => 'rgba(54, 162, 235, 1)',
        ],
         [
            'query'       => EmailTracking::where('type', 'especialidad'),
            'label'       => 'Especialidad',
            'color'       => 'rgba(54, 162, 235, 0.2)',
            'borderColor' => 'rgb(251, 184, 49)',
        ],
         [
            'query'       => EmailTracking::where('type', 'act_encuesta'),
            'label'       => 'Actualización',
            'color'       => 'rgba(54, 162, 235, 0.2)',
            'borderColor' => 'rgb(5, 103, 132)',
        ],
        [
            'query'       => EmailTracking::where('type', 'posgrado'),
            'label'       => 'Invitación Posgrado',
            'color'       => 'rgba(255, 99, 132, 0.2)',
            'borderColor' => 'rgba(255, 99, 132, 1)',
        ],
        [
            // Asumiendo modelo RespuestasPosgrado con campo fec_capt
            'query'       => EmailTracking::where('type', 'verde'),
            'label'       => 'Verde',
            'color'       => 'rgba(75, 192, 192, 0.2)',
            'borderColor' => 'rgba(75, 192, 192, 1)',
        ],
        [
            // Asumiendo modelo RespuestasVerdes con campo fec_capt
            'query'       => EmailTracking::where('type', 'correo_seg_22'),
            'label'       => 'Invitación Lics',
            'color'       => 'rgba(153, 102, 255, 0.2)',
            'borderColor' => 'rgba(153, 102, 255, 1)',
        ],
    ];

    $chartEmailTracking = $this->generateMultiSeriesChartData(
        "date_trunc('week', created_at)",
        "to_char(date_trunc('week', created_at), 'YYYY-MM-DD')",
        $seriesEnvios
    );

    // ========== Pasar datos a la vista ==========
    
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

// ==========  Encuestas 2022 vs Recados por encuestador (barras horizontales apiladas) ==========
    // Query 1: Encuestas 2022 completadas por encuestador
    $queryEncuestasEncuestador = respuestas20::join('users', 'aplica', 'clave')
        ->where('completed', 1)
        ->whereNull('aplica2')
        ->where('gen_dgae', 2022)
        ->whereIn('aplica', ['27','26','28','17','30'])
        ->where('fec_capt','>=',carbon::now()->subdays(30));

    // Query 2: Recados tipo 'seg' por encuestador
    $queryRecadosEncuestador = Recado::join('users', 'users.id', 'recados.user_id')
        ->where('recados.type', 'seg')
        ->whereIn('user_id',[893,891,892,13,898])
        ->where('recados.created_at','>=',carbon::now()->subdays(30));

    $chartEncuestasVsRecados = $this->generateHorizontalStackedWithEffectiveness(
        $queryEncuestasEncuestador,
        $queryRecadosEncuestador,
        'name',
        'Encuestas 2022',
        'Recados Seg',
        'rgba(52, 152, 219, 0.7)',      // color encuestas
        'rgba(52, 152, 219, 1)',         // borderColor encuestas
        'rgba(243, 156, 18, 0.7)',       // color recados
        'rgba(243, 156, 18, 1)'          // borderColor recados
    );

    // ==========  Encuestas posgrado vs Recados por encuestador (barras horizontales apiladas) ==========
    // Query 1: Encuestas posgrado completadas por encuestador
    $queryEncuestasEncuestadorPos = respuestasPosgrado::join('users', function ($join) {
        $join->on(DB::raw('CAST(aplica AS varchar)'), '=', 'users.clave');
    })
        ->where('completed', 1)
        ->whereIn('aplica', ['25','22','23'])
        ->where('fec_capt','>=',carbon::now()->subdays(30));

    // Query 2: Recados tipo 'pos o esp' por encuestador
    $queryRecadosEncuestadorPos = Recado::join('users', 'users.id', 'recados.user_id')
        ->whereIn('recados.type', ['pos'])
        ->whereIn('user_id',[9,16,20])
        ->where('recados.created_at','>=',carbon::now()->subdays(30));

    $chartEncuestasVsRecadosPos = $this->generateHorizontalStackedWithEffectiveness(
        $queryEncuestasEncuestadorPos,
        $queryRecadosEncuestadorPos,
        'name',
        'Encuestas Posgrado',
        'Recados Pos',
        'rgba(52, 152, 219, 0.7)',      // color encuestas
        'rgba(52, 152, 219, 1)',         // borderColor encuestas
        'rgba(243, 156, 18, 0.7)',       // color recados
        'rgba(243, 156, 18, 1)'          // borderColor recados
    );

    //Eventos de llamadas
    // Calcular tasa de apertura por tipo usando la tabla email_tracking
    $tasa_apertura = EmailTracking::select(
            'type',
            DB::raw('COUNT(*) AS enviados'),
            DB::raw("SUM(CASE WHEN opened_at IS NOT NULL THEN 1 ELSE 0 END) AS abiertos")
        )
        ->groupBy('type')
        ->get()
        ->map(function ($row) {
            return [
                'type' => $row->type,
                'enviados' => (int) $row->enviados,
                'abiertos' => (int) $row->abiertos,
            ];
        })
        ->toArray();

    return view('stats', compact(
        'chartName22','telefonicas','requeridas',
        'total22', 'total16', 'Internet','Internet16','requeridas16',
        'internet22', 'internet16', 'telefonicas22', 'telefonicas16', 'internetTotal',
        'requeridas',
        'stackedEnc',        // Contiene ['labels' => [...], 'datasets' => [...]]
        'chartWeeklyAll','chartEmailTracking','chartEncuestasVsRecados',
        'chartEncuestasVsRecadosPos', 'requeridasPos','telefonicasPos','InternetPos','TotalPos',
        'tasa_apertura'
    ));
}

public function weeklyReportSeg()
{
    // Fecha del reporte: semana anterior (lunes a domingo)
    $start = Carbon::now()->subWeek()->startOfWeek();
    $end   = Carbon::now()->subWeek()->endOfWeek();

    // ========== 1. Construir consultas base ==========
    // Gen 2022
    $query22 = Respuestas20::where('completed', 1)
        ->whereNull('aplica2')
        ->where('gen_dgae', 2022)
        ->where('fec_capt', '>', $start)
        ->where('fec_capt', '<=', $end);

    // Todas las generaciones (aplica2 = '1')
    $queryRG = Respuestas20::where('completed', 1)
        ->where('aplica2', '1')
        ->where('fec_capt', '>', $start)
        ->where('fec_capt', '<=', $end);

    // Act 2016
    $cuentas16 = Egresado::where('act_suvery', 1)->pluck('cuenta');
    $query16 = Respuestas16::where('completed', 1)
        ->whereIn('cuenta', $cuentas16)
        ->where('fec_capt', '>', $start)
        ->where('fec_capt', '<=', $end);

    // Act 2018 (usa created_at según el script Python)
    $cuentas18 = Egresado::where('act_suvery', 2)->pluck('cuenta');
    $query18 = Respuestas16::where('completed', 1)
        ->whereIn('cuenta', $cuentas18)
        ->where('created_at', '>', $start)
        ->where('created_at', '<=', $end);

    // Posgrado (generaciones 2019-2022)
    $queryPos = RespuestasPosgrado::where('completed', '1')
        ->whereIn('anio_egreso', [2019, 2020, 2021, 2022])
        ->where('fec_capt', '>', $start)
        ->where('fec_capt', '<=', $end);

    // Posgrado (otras generaciones)
    $queryPosg = RespuestasPosgrado::where('completed', '1')
        ->whereNotIn('anio_egreso', [2019, 2020, 2021, 2022])
        ->where('fec_capt', '>', $start)
        ->where('fec_capt', '<=', $end);

    // Especialidad
    $queryEsp = RespuestasEspecialidad::where('completed', '1')
        ->where('fec_capt', '>', $start)
        ->where('fec_capt', '<=', $end);

    // Continua (usa updated_at)
    $queryCont = RespuestasContinua::where('updated_at', '>', $start)
        ->where('updated_at', '<=', $end);

    // Verde (vr1 not null)
    $queryVerde = RespuestasVerdes::whereNotNull('vr1')
        ->where('updated_at', '>', $start)
        ->where('updated_at', '<=', $end);

    // ========== 2. Función auxiliar para conteos (por defecto internet = '111') ==========
    $countTelefonicasInternet = function ($query, $internetValues = ['111']) {
        $internet = (clone $query)->whereIn('aplica', $internetValues)->count();
        $telefonicas = (clone $query)->whereNotIn('aplica', $internetValues)->count();
        return ['telefonicas' => $telefonicas, 'internet' => $internet, 'total' => $telefonicas + $internet];
    };

    // ========== 3. Generar filas ==========
    $rows = [];

    // Gen 2022
    $data = $countTelefonicasInternet($query22);
    $rows[] = ['generacion' => 'Gen 2022', 'telefonicas' => $data['telefonicas'], 'internet' => $data['internet'], 'total' => $data['total']];

    // Todas las generaciones
    $data = $countTelefonicasInternet($queryRG);
    $rows[] = ['generacion' => 'Todas las generaciones', 'telefonicas' => $data['telefonicas'], 'internet' => $data['internet'], 'total' => $data['total']];

    // Act 2016
    $data = $countTelefonicasInternet($query16);
    $rows[] = ['generacion' => 'Act 2016', 'telefonicas' => $data['telefonicas'], 'internet' => $data['internet'], 'total' => $data['total']];

    // Act 2018
    $data = $countTelefonicasInternet($query18);
    $rows[] = ['generacion' => 'Act 2018', 'telefonicas' => $data['telefonicas'], 'internet' => $data['internet'], 'total' => $data['total']];

    // Posgrado
    $data = $countTelefonicasInternet($queryPos);
    $rows[] = ['generacion' => 'Posgrado', 'telefonicas' => $data['telefonicas'], 'internet' => $data['internet'], 'total' => $data['total']];

    // Posgrado (otras generaciones)
    $data = $countTelefonicasInternet($queryPosg);
    $rows[] = ['generacion' => 'Posgrado (otras generaciones)', 'telefonicas' => $data['telefonicas'], 'internet' => $data['internet'], 'total' => $data['total']];

    // Especialidad
    $data = $countTelefonicasInternet($queryEsp);
    $rows[] = ['generacion' => 'Especialidad', 'telefonicas' => $data['telefonicas'], 'internet' => $data['internet'], 'total' => $data['total']];

    // Continua (telefónicas = '30', internet ≠ '30')
    $contTelefonicas = (clone $queryCont)->where('aplica', '30')->count();
    $contInternet    = (clone $queryCont)->where('aplica', '!=', '30')->count();
    $rows[] = ['generacion' => 'Continua', 'telefonicas' => $contTelefonicas, 'internet' => $contInternet, 'total' => $contTelefonicas + $contInternet];

    // Verde (igual que Continua)
    $verdeTelefonicas = (clone $queryVerde)->where('aplica', '30')->count();
    $verdeInternet    = (clone $queryVerde)->where('aplica', '!=', '30')->count();
    $rows[] = ['generacion' => 'Verde', 'telefonicas' => $verdeTelefonicas, 'internet' => $verdeInternet, 'total' => $verdeTelefonicas + $verdeInternet];

    // ========== 4. Totales ==========
    $totalTelefonicas = array_sum(array_column($rows, 'telefonicas'));
    $totalInternet    = array_sum(array_column($rows, 'internet'));
    $totalGeneral     = array_sum(array_column($rows, 'total'));



    $correo='felmiquiztli@gmail.com';
    // ========== 5. Preparar datos para el correo ==========
    $data = [
        'start'             => $start->toDateString(),
        'end'               => $end->toDateString(),
        'rows'              => $rows,
        'correo'            => $correo,
        'correo_id'         => '0',
        'nombre'            => 'Fel',
        'totalTelefonicas'  => $totalTelefonicas,
        'totalInternet'     => $totalInternet,
        'totalGeneral'      => $totalGeneral,
        'title'             => 'REPORTE SEMANAL DE ENCUESTAS',
    ];

    // ========== 6. Enviar correo ==========
     Mail::to($correo)->queue((new ReportMail($data))->onQueue('high'));

    // Opcional: también puedes enviar a varios destinatarios
    // $emails = ['admin@ejemplo.com', 'reportes@ejemplo.com'];
    // foreach ($emails as $email) {
    //     Mail::to($email)->send(new WeeklyReportMail($data));
    // }

    return response()->json(['message' => 'Reporte semanal enviado']);
}

}
