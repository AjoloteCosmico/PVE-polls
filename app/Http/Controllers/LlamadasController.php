<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\respuestas20;
use App\Models\respuestas3;
use App\Models\respuestas14;
use App\Models\Correo;
use App\Models\Egresado;
use App\Models\Carrera;
use App\Models\Comentario;
use App\Models\Telefono;
use DB;
use App\Models\Recado;
use Session;
class LlamadasController extends Controller
{
    public function llamar($gen,$id){
        $Encuesta='ENCUESTA DE SEGUIMIENTO'.$gen;
        $Egresado=Egresado::where('cuenta','=',$id)
        ->where('muestra','3')
        ->first();
        //identificar si el egresado viene de la 2016
        if(!$Egresado){
        $Encuesta='ENCUESTA DE ACTUALIZACION 2016'; 
        $Egresado=Egresado::where('cuenta','=',$id)
        ->where('act_suvery','1')
        ->first();
        }
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
        return view('muestras.seg20.llamar',compact('Egresado','Telefonos','Recados','Carrera','Codigos','Codigos_all','Encuesta','gen'));

    }

    public function act_data($cuenta, $carrera, $gen,$telefono_id)
    {

        Session::put('telefono_encuesta',$telefono_id);
        $TelefonoEnLlamada=Telefono::find($telefono_id);
        $Egresado = Egresado::where("cuenta", $cuenta)
            ->where("carrera", $carrera)
            ->first();
        $Telefonos = DB::table("telefonos")
            ->where("cuenta", "=", $cuenta)
            ->leftJoin("codigos", "codigos.code", "=", "telefonos.status")
            ->get();
        $Correos = Correo::where("cuenta", "=", $cuenta)
            ->Join("codigos", "codigos.code", "=", "correos.status")
            ->get();
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
    
        return view(
            "encuesta.seg20.actualizar_datos",
            compact(
                "TelefonoEnLlamada",
                "Egresado",
                "Telefonos",
                "Correos",
                "Carrera",
                "Plantel",
                "gen"
            )
        );
    }
}
