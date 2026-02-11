<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\respuestas20;
use App\Models\respuestasPosgrado;
use App\Models\respuestas_continua;
use App\Models\respuestas3;
use App\Models\respuestas16;
use App\Models\Correo;
use App\Models\Egresado;
use App\Models\EgresadoPosgrado;
use App\Models\Carrera;
use App\Models\Comentario;
use App\Models\Telefono;
use DB;
use App\Models\Recado;
use Session;
class LlamadasController extends Controller
{
    public function llamar($gen,$id,$carrera){

        if (!auth()->user()->can('aplicar_encuesta_actualizacion') && !auth()->user()->can('aplicar_encuesta_seguimiento')) {
            return redirect()->back()->with('error', 'No tienes permisos para la muestra ' . $gen);
        }

    
        $Egresado=Egresado::where('cuenta','=',$id)
        ->where('carrera',$carrera)
        ->first();


        $Carrera= Carrera::where('clave_carrera',$Egresado->carrera)->where('clave_plantel',$Egresado->plantel)->first();
        
        if($gen=='2020' || $gen == '2022'){
            $Encuesta= ($gen == '2020') ? 'ENCUESTA DE SEGUIMIENTO 2020' : 'ENCUESTA DE SEGUIMIENTO 2022';;
            $Encuesta=respuestas20::where('cuenta','=',$Egresado->cuenta)->first();
        }else{
            $Encuesta='ENCUESTA DE ACTUALIZACION 2016';
            $Encuesta=respuestas16::where('cuenta','=',$Egresado->cuenta)->first();
        }

        $Telefonos=DB::table('telefonos')->where('cuenta','=',$Egresado->cuenta)
        ->leftJoin('codigos','codigos.code','=','telefonos.status')
        ->select('telefonos.*','codigos.color_rgb','codigos.description')
        ->get();
        $Recados=DB::table('recados')->where('cuenta','=',$Egresado->cuenta)
        ->orderBy('fecha','asc')
        ->leftJoin('codigos','codigos.code','=','recados.status')
        ->leftJoin('users','users.id','=','recados.user_id')
        ->select('recados.*','codigos.color_rgb','codigos.description','users.name as user_name')
        ->get();
        $Codigos=DB::table('codigos')
        ->where('internet','=',0)
        ->orderBy('color')->get();
        $Codigos_all=DB::table('codigos')
        ->orderBy('color')->get();
        return view('muestras.seg20.llamar',compact('Egresado','Telefonos','Recados','Carrera','Codigos','Codigos_all','Encuesta','gen'));

    }

    public function llamar_continua($gen,$id,$carrera)
    {
        
        //if (!auth()->user()->can('aplicar_encuesta_continua')) {
          //  return redirect()->back()->with('error', 'No tienes permisos para la muestra continua');
        //}

    
        $Egresado=Egresado::where('cuenta','=',$id)
        ->where('carrera',$carrera)
        ->first();

        $Carrera = Carrera::where('clave_carrera',$Egresado->carrera)->where('clave_plantel',$Egresado->plantel)->first();
        $Encuesta= respuestas_continua::where('cuenta','=',$Egresado->cuenta)->first();

        $Telefonos=DB::table('telefonos')->where('cuenta','=',$Egresado->cuenta)
        ->leftJoin('codigos','codigos.code','=','telefonos.status')
        ->select('telefonos.*','codigos.color_rgb','codigos.description')
        ->get();
        $Recados=DB::table('recados')->where('cuenta','=',$Egresado->cuenta)
        ->orderBy('fecha','asc')
        ->leftJoin('codigos','codigos.code','=','recados.status')
        ->leftJoin('users','users.id','=','recados.user_id')
        ->select('recados.*','codigos.color_rgb','codigos.description','users.name as user_name')
        ->get();
        $Codigos=DB::table('codigos')
        ->where('internet','=',0)
        ->orderBy('color')->get();
        $Codigos_all=DB::table('codigos')
        ->orderBy('color')->get();
        return view('muestras.ed_continua.llamar_continua',compact('Egresado','Telefonos','Recados','Carrera','Codigos','Codigos_all','Encuesta','gen'));
    }


    public function llamar_egresadosPosgrado($id,$plan,$programa){

        if (!auth()->user()->can('ver_muestra_posgrado')) {
            return redirect()->back()->with('error', 'No tienes permisos para la muestra de posgrado');
        }

        $EgresadoPos=EgresadoPosgrado::where('cuenta', '=',$id)
        ->where('programa',$programa)
        ->where('plan',$plan)
        ->first();

        $EncuestaPos=respuestasPosgrado::where('cuenta','=',$EgresadoPos->cuenta)->where('plan',$EgresadoPos->plan)->first();

        $Telefonos=DB::table('telefonos')->where('cuenta','=',$EgresadoPos->cuenta)
        ->leftJoin('codigos','codigos.code','=','telefonos.status')
        ->select('telefonos.*','codigos.color_rgb','codigos.description')
        ->get();
        
        $Recados=DB::table('recados')->where('cuenta','=',$EgresadoPos->cuenta)
        ->orderBy('fecha','asc')
        ->leftJoin('codigos','codigos.code','=','recados.status')
        ->leftJoin('users','users.id','=','recados.user_id')
        ->select('recados.*','codigos.color_rgb','codigos.description','users.name as user_name')
        ->get();
        $Codigos=DB::table('codigos')
        ->where('internet','=',0)
        ->orderBy('color')->get();
        $Codigos_all=DB::table('codigos')
        ->orderBy('color')->get();
        return view('muestras.posgrado.llamar_posgrado',compact('EgresadoPos',
        'Telefonos','Recados','Codigos','Codigos_all','EncuestaPos','plan','programa'));
    }

    public function act_data($cuenta, $carrera, $gen,$telefono_id)
    {
        if (!auth()->user()->can('aplicar_encuesta_actualizacion') && !auth()->user()->can('aplicar_encuesta_seguimiento')) {
            return redirect()->back()->with('error', 'No tienes permisos para aplicar la encuesta ' . $gen);
        }

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
            ->leftJoin("codigos", "codigos.code", "=", "correos.status")
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

    public function act_data_continua($cuenta, $carrera, $gen,$telefono_id)
    {
        //if (!auth()->user()->can('aplicar_encuesta_continua')) {
          //  return redirect()->back()->with('error', 'No tienes permisos para aplicar la encuesta continua');
        //}

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
            ->leftJoin("codigos", "codigos.code", "=", "correos.status")
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
            "muestras.ed_continua.actualizar_datos_continua",
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


    public function act_data_posgrado($cuenta, $programa, $plan, $telefono_id)
    {
        if (!auth()->user()->can('aplicar_encuesta_posgrado')) {
            return redirect()->back()->with('error', 'No tienes permisos para aplicar la encuesta de posgrado');
        }

        Session::put('telefono_encuesta',$telefono_id);
        $TelefonoEnLlamada=Telefono::find($telefono_id);

        $EgresadoPos = EgresadoPosgrado::where("cuenta", $cuenta)
            ->where("programa", $programa)
            //->where("plan", $plan)
            ->first();
        
        if (!$EgresadoPos) {
            $EgresadoPos = EgresadoPosgrado::where("cuenta", $cuenta)->firstOrFail();
        }

        Session::put('plan_posgrado',$EgresadoPos->plan);
        $Telefonos = DB::table("telefonos")
            ->where("cuenta", "=", $cuenta)
            ->leftJoin("codigos", "codigos.code", "=", "telefonos.status")
            ->get();
        $Correos = Correo::where("cuenta", "=", $cuenta)
            ->leftJoin("codigos", "codigos.code", "=", "correos.status")
            ->get();
        $EncuestaInconclusa = respuestasPosgrado::where("cuenta", "=", $cuenta)
            ->first();
        return view(
            "muestras.posgrado.actualizar_datos_posgrado",
            compact(
                "TelefonoEnLlamada",
                "EgresadoPos",
                "Telefonos",
                "Correos",
                "programa",
                "plan","EncuestaInconclusa"
            )
        );
    }


}
