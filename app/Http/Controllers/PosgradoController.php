<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bloqueo;
use App\Models\Carrera;
use App\Models\Correo;
use App\Models\Egresado;
use App\Models\Telefono;
use App\Models\respuestas20;
use App\Models\Reactivo;
use App\Models\Option;
use DB;

class PosgradoController extends Controller
{
    //
    public function show($section){
        $Egresado=Egresado::find(1);
        $Encuesta=respuestas20::find(235);
        $Telefonos=Telefono::where('id','<',3)->get();
        $Correos=Correo::where('id','<',3)->get();
        $Carrera = Carrera::where(
            "clave_carrera",
            "=",
            $Egresado->carrera
        )->first()->carrera;
        $Plantel = Carrera::where(
            "clave_plantel",
            "=",
            $Egresado->plantel
        )->first()->plantel;

        $Reactivos=Reactivo::where('section',$section)->get();
        $Opciones=Option::where('clave','like','%p%r')->get();
        $Bloqueos=Bloqueo::where('clave_reactivo','like','p%')->get();

        // dd($Bloqueos->unique('valor')->pluck('valor'));
        return view('posgrado.section', 
                    compact('Egresado', 'Encuesta',
                    'Telefonos','Correos','Carrera','Plantel',
                'Reactivos','Opciones','Bloqueos'));
    }
    
    
}
