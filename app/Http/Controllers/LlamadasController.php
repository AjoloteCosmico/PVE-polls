<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\respuestas20;
use App\Models\respuestas3;
use App\Models\respuestas14;
use App\Models\Egresado;
use App\Models\Carrera;
use App\Models\Comentario;
use App\Models\Telefono;
use DB;
use App\Models\Recado;
class LlamadasController extends Controller
{
    public function llamar_20($id){
        $Egresado=Egresado::where('cuenta','=',$id)->where('muestra','=',3)->first();
        $Carrera= Carrera::where('clave_carrera',$Egresado->carrera)->where('clave_plantel',$Egresado->plantel)->first();
        
        $Encuesta=respuestas20::where('cuenta','=',$Egresado->cuenta)->first();
        

        $Telefonos=DB::table('telefonos')->where('cuenta','=',$Egresado->cuenta)
        ->leftJoin('codigos','codigos.code','=','telefonos.status')
        ->select('telefonos.*','codigos.color_rgb','codigos.description')
        ->get();
        $Recados=DB::table('recados')->where('cuenta','=',$Egresado->cuenta)
        ->leftJoin('codigos','codigos.code','=','recados.status')
        ->select('recados.*','codigos.color_rgb','codigos.description')
        ->get();
        $Codigos=DB::table('codigos')
        ->where('internet','=',0)
        ->orderBy('color')->get();
        $Codigos_all=DB::table('codigos')
        ->orderBy('color')->get();
        return view('muestras.seg20.llamar',compact('Egresado','Telefonos','Recados','Carrera','Codigos','Codigos_all','Encuesta'));

    }
}
