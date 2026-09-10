<?php

namespace App\Console\Commands;
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
use Illuminate\Console\Command;

use App\Models\User;
use App\Models\Estudio;
use App\Models\Egresado;
use App\Models\EgresadoPosgrado;
use App\Models\Muestra;
use Carbon\Carbon;

use App\Services\ReportEncuestaService;

class SendWeeklyReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:send-weekly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enviar reporte semanal';

    /**
     * Execute the console command.
     */
    public function handle(ReportEncuestaService $reporteService)
    {
        $this->info('Enviando reporte semanal...');
        
        $reporteService->ReportSeg();

        $this->info('¡Listo!');
        return Command::SUCCESS;

    
    }
}
