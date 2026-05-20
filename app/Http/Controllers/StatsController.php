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
    ];

    $chartWeeklyAll = $this->generateMultiSeriesChartData(
        "date_trunc('week', updated_at)",
        "to_char(date_trunc('week', updated_at), 'YYYY-MM-DD')",
        $seriesSemanales
    );

    // ========== 5. Pasar datos a la vista ==========
    
    $Internet=respuestas20::whereIn('aplica',['111','104','20','105'])
    ->whereNull('aplica2')->where('gen_dgae', 2022)->get()->count();
    $Internet16=respuestas16::where('completed','1')->where('aplica','111')->count();
    $requeridas = $metas->sum(function($m) use ($realizadasPorCarrera) {
        return max(0, $m->requeridas_5 - ($realizadasPorCarrera[$m->carrera_id] ?? 0));
    });
   
    $telefonicas=$total22-$internet22;
    return view('stats', compact(
        'chartName22','telefonicas','requeridas',
        'total22', 'total16', 'Internet','Internet16','requeridas16',
        'internet22', 'internet16', 'telefonicas22', 'telefonicas16', 'internetTotal',
        'requeridas',
        'stackedEnc',        // Contiene ['labels' => [...], 'datasets' => [...]]
        'chartWeeklyAll'     // Contiene ['labels' => [...], 'datasets' => [...]]
    ));
}

}
