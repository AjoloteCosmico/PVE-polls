<?php
namespace App\Services;

use App\Models\respuestas16;
use App\Models\respuestas20;
use App\Models\respuestasPosgrado;
use App\Models\respuestasEspecialidad;
use App\Models\RespuestasContinua;
use App\Models\RespuestasVerdes;
use App\Models\Egresado;

use App\Models\User;
use Carbon\Carbon;
use App\Mail\ReportMail;
use Illuminate\Support\Facades\Mail;
use DB;

class ReportEncuestaService
{ 
    public function ReportSeg($start = null, $end = null)
    {
        // Fecha del reporte: semana anterior (lunes a domingo)
        $start = $start ?? Carbon::now()->subWeek()->startOfWeek();
        $end   = $end ?? Carbon::now()->subWeek()->endOfWeek();

        // ========== 1. Construir consultas base ==========
        // Gen 2022
        $query22 = respuestas20::where('completed', 1)
            ->whereNull('aplica2')
            ->where('gen_dgae', 2022)
            ->where('fec_capt', '>', $start)
            ->where('fec_capt', '<=', $end);

        // Todas las generaciones (aplica2 = '1')
        $queryRG = respuestas20::where('completed', 1)
            ->where('aplica2', '1')
            ->where('fec_capt', '>', $start)
            ->where('fec_capt', '<=', $end);

        // Act 2016
        $cuentas16 = Egresado::where('act_suvery', 1)->pluck('cuenta');
        $query16 = respuestas16::where('completed', 1)
            ->whereIn('cuenta', $cuentas16)
            ->where('fec_capt', '>', $start)
            ->where('fec_capt', '<=', $end);

        // Act 2018
        $cuentas18 = Egresado::where('act_suvery', 2)->pluck('cuenta');
        $query18 = respuestas16::where('completed', 1)
            ->whereIn('cuenta', $cuentas18)
            ->where('created_at', '>', $start)
            ->where('created_at', '<=', $end);

        // Posgrado (generaciones 2019-2022)
        $queryPos = respuestasPosgrado::where('completed', '1')
            ->whereIn('anio_egreso', [2019, 2020, 2021, 2022])
            ->where('fec_capt', '>', $start)
            ->where('fec_capt', '<=', $end);

        // Posgrado (otras generaciones)
        $queryPosg = respuestasPosgrado::where('completed', '1')
            ->whereNotIn('anio_egreso', [2019, 2020, 2021, 2022])
            ->where('fec_capt', '>', $start)
            ->where('fec_capt', '<=', $end);

        // Especialidad
        $queryEsp = respuestasEspecialidad::where('completed', '1')
            ->where('fec_capt', '>', $start)
            ->where('fec_capt', '<=', $end);

        // Continua
        $queryCont = RespuestasContinua::where('updated_at', '>', $start)
            ->where('updated_at', '<=', $end);

        // Verde
        $queryVerde = RespuestasVerdes::whereNotNull('vr1')
            ->where('updated_at', '>', $start)
            ->where('updated_at', '<=', $end);

        // ========== 2. Función auxiliar para conteos ==========
        $countTelefonicasInternet = function ($query, $internetValues = ['111']) {
            $internet = (clone $query)->whereIn('aplica', $internetValues)->count();
            $telefonicas = (clone $query)->whereNotIn('aplica', $internetValues)->count();
            return ['telefonicas' => $telefonicas, 'internet' => $internet, 'total' => $telefonicas + $internet];
        };

        // ========== 3. Generar filas principales ==========
        $rows = [];

        $data = $countTelefonicasInternet($query22);
        $rows[] = ['generacion' => 'Gen 2022', 'telefonicas' => $data['telefonicas'], 'internet' => $data['internet'], 'total' => $data['total']];

        $data = $countTelefonicasInternet($queryRG);
        $rows[] = ['generacion' => 'Todas las generaciones', 'telefonicas' => $data['telefonicas'], 'internet' => $data['internet'], 'total' => $data['total']];

        $data = $countTelefonicasInternet($query16);
        $rows[] = ['generacion' => 'Act 2016', 'telefonicas' => $data['telefonicas'], 'internet' => $data['internet'], 'total' => $data['total']];

        $data = $countTelefonicasInternet($query18);
        $rows[] = ['generacion' => 'Act 2018', 'telefonicas' => $data['telefonicas'], 'internet' => $data['internet'], 'total' => $data['total']];

        $data = $countTelefonicasInternet($queryPos);
        $rows[] = ['generacion' => 'Posgrado', 'telefonicas' => $data['telefonicas'], 'internet' => $data['internet'], 'total' => $data['total']];

        $data = $countTelefonicasInternet($queryPosg);
        $rows[] = ['generacion' => 'Posgrado (otras generaciones)', 'telefonicas' => $data['telefonicas'], 'internet' => $data['internet'], 'total' => $data['total']];

        $data = $countTelefonicasInternet($queryEsp);
        $rows[] = ['generacion' => 'Especialidad', 'telefonicas' => $data['telefonicas'], 'internet' => $data['internet'], 'total' => $data['total']];

        $contTelefonicas = (clone $queryCont)->where('aplica', '30')->count();
        $contInternet    = (clone $queryCont)->where('aplica', '!=', '30')->count();
        $rows[] = ['generacion' => 'Continua', 'telefonicas' => $contTelefonicas, 'internet' => $contInternet, 'total' => $contCont = $contTelefonicas + $contInternet];

        $verdeTelefonicas = (clone $queryVerde)->where('aplica', '30')->count();
        $verdeInternet    = (clone $queryVerde)->where('aplica', '!=', '30')->count();
        $rows[] = ['generacion' => 'Verde', 'telefonicas' => $verdeTelefonicas, 'internet' => $verdeInternet, 'total' => $verdeTelefonicas + $verdeInternet];

        // ========== 4. Conteo de Telefónicas por Usuario (Modelo User -> clave vs aplica) ==========
        $users = User::whereNotNull('clave')->get();
        $telefonicasPorUsuario = [];

        // Agrupamos las consultas base de encuestas para evaluar el campo 'aplica' contra la 'clave' del usuario
        $allQueryBuilders = [$query22, $queryRG, $query16, $query18, $queryPos, $queryPosg, $queryEsp, $queryCont, $queryVerde];

        foreach ($users as $user) {
            $userCount = 0;
            foreach ($allQueryBuilders as $qBuilder) {
                $userCount += (clone $qBuilder)->where('aplica', $user->clave)->count();
            }

            if ($userCount > 0) {
                $telefonicasPorUsuario[] = [
                    'usuario' => $user->name ?? 'Usuario ' . $user->clave,
                    'clave' => $user->clave,
                    'total' => $userCount
                ];
            }
        }

        // ========== 5. Totales generales ==========
        $totalTelefonicas = array_sum(array_column($rows, 'telefonicas'));
        $totalInternet    = array_sum(array_column($rows, 'internet'));
        $totalGeneral     = array_sum(array_column($rows, 'total'));

        // ========== 6. Datos específicos por tipo de encuesta para gráficas individuales ==========
        // Solo respuestas20, respuestas16, respuestas_posgrado y respuestas_especialidad
        $chartrespuestas20 = [
            'titulo' => 'Respuestas 20 (Gen 2022 & General)',
            'total' => $query22->count() + $queryRG->count(),
            'datos' => [
                ['label' => 'Gen 2022', 'val' => (clone $query22)->count()],
                ['label' => 'Todas las gen.', 'val' => (clone $queryRG)->count()],
            ]
        ];

        $chartrespuestas16 = [
            'titulo' => 'Respuestas 16 (Act 2016 & 2018)',
            'total' => $query16->count() + $query18->count(),
            'datos' => [
                ['label' => 'Act 2016', 'val' => (clone $query16)->count()],
                ['label' => 'Act 2018', 'val' => (clone $query18)->count()],
            ]
        ];

        $chartrespuestasPosgrado = [
            'titulo' => 'Respuestas Posgrado',
            'total' => $queryPos->count() + $queryPosg->count(),
            'datos' => [
                ['label' => 'Gen 2019-2022', 'val' => (clone $queryPos)->count()],
                ['label' => 'Otras gen.', 'val' => (clone $queryPosg)->count()],
            ]
        ];

        $chartrespuestasEspecialidad = [
            'titulo' => 'Respuestas Especialidad',
            'total' => $queryEsp->count(),
            'datos' => [
                ['label' => 'Especialidad', 'val' => (clone $queryEsp)->count()],
            ]
        ];

        $emails = [
            ['correo' => 'ivyanalitycs@gmail.com', 'nombre' => 'Analytics Team'],
            ['correo' => 'felmiquiztli@gmail.com', 'nombre' => 'Fel'],
        ];

        // ========== 7. Preparar datos para el correo ==========
        $data = [
            'start'                 => $start->toDateString(),
            'end'                   => $end->toDateString(),
            'rows'                  => $rows,
            'telefonicasPorUsuario' => $telefonicasPorUsuario,
            'chartRespuestas20'         => $chartrespuestas20,
            'chartRespuestas16'         => $chartrespuestas16,
            'chartRespuestasPosgrado'   => $chartrespuestasPosgrado,
            'chartRespuestasEspecialidad' => $chartrespuestasEspecialidad,
            'correo'                => ' ',
            'correo_id'             => '0',
            'nombre'                => ' ',
            'extra_items'           => [],
            'totalTelefonicas'      => $totalTelefonicas,
            'totalInternet'         => $totalInternet,
            'totalGeneral'          => $totalGeneral,
            'title'                 => 'REPORTE SEMANAL DE ENCUESTAS',
        ];

        // ========== 8. Enviar correo ==========
        foreach ($emails as $recipient) {
            $data['correo'] = $recipient['correo'];
            $data['nombre'] = $recipient['nombre'];
            Mail::to($recipient['correo'])->queue((new ReportMail($data))->onQueue('high'));
        }
            
        return 0;
    }
}