<?php

namespace App\Providers;
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

use Illuminate\Support\ServiceProvider;

class ReportEncuestasServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
