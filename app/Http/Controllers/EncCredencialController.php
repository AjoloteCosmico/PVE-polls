<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\respuestas_credencial;
use App\Models\respuestas_verdes;
use App\Models\Egresado;
use App\Models\Empresas;
use App\Models\Carrera;
use App\Models\Correo;
use App\Models\Telefono;
use App\Models\Reactivo;
use App\Models\Bloqueo;
use App\Models\Option;
use App\Models\multiple_option_answer;
use Session;
use DB;
use File;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use App\Traits\LogEvents;
class EncCredencialController extends Controller
{
    //
}
