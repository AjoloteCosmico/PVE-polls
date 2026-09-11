<?php
namespace App\Services;

class ReporteEncuestaService
{   

    public function ReportSeg($start = null, $end = null)
    {
        // Fecha del reporte: semana anterior (lunes a domingo)
        $this->start = $start ?? Carbon::now()->subWeek()->startOfWeek();
        $this->end   = $end ?? Carbon::now()->subWeek()->endOfWeek();

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


    $emails = [
        ['correo' => 'ivyanalitycs@gmail.com', 'nombre' => 'Analytics Team'],
        ['correo' => 'felmiquiztli@gmail.com', 'nombre' => 'Fel'],
        // ['correo' => 'marthaunam@hotmail.com', 'nombre' => 'Martha'],
        
        // ['correo' => 'marthaunam@hotmail.com', 'nombre' => 'Martha'], aki hay q poner el de mcnava
        
        //  ['correo' => 'malu2806@gmail.com', 'nombre' => 'Malu'], 
    ];

   
    // ========== 5. Preparar datos para el correo ==========
    $data = [
        'start'             => $start->toDateString(),
        'end'               => $end->toDateString(),
        'rows'              => $rows,
        'correo'            => ' ',
        'correo_id'         => '0',
        'nombre'            => ' ',
        'extra_items' =>[],
        'totalTelefonicas'  => $totalTelefonicas,
        'totalInternet'     => $totalInternet,
        'totalGeneral'      => $totalGeneral,
        'title'             => 'REPORTE SEMANAL DE ENCUESTAS',
    ];

    // ========== 6. Enviar correo ==========
     foreach ($emails as $recipient) {
        $data['correo'] = $recipient['correo'];
        $data['nombre'] = $recipient['nombre'];
        Mail::to($recipient['correo'])->queue((new ReportMail($data))->onQueue('high'));
    }
        
        $this->info('Reporte semanal enviado correctamente.');
        
        return 0;
    }
   
}