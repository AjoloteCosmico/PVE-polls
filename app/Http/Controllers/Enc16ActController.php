<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Egresado;
use App\Models\Carrera;
use App\Models\Correo;
use App\Models\Telefono;
use App\Models\respuestas16;
use App\Models\Reactivo;
use App\Models\Bloqueo;
use App\Models\Option;
use Session;
use DB;

use File;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
class Enc16ActController extends Controller
{

    public function comenzar($correo, $cuenta, $carrera)
    {
        $Correo = Correo::find($correo);
        // $Correo->status='pendiente16';
        // $Correo->save();
        $Egresado = Egresado::where("cuenta", $cuenta)
            ->where("carrera", $carrera)
            ->first();
        if ($Correo->enviado == 0) {
            $caminoalpoder = public_path();
            $process = new Process([
                env("PY_COMAND"),
                $caminoalpoder . "/aviso.py",
                $Egresado->nombre,
                $Correo->correo,
            ]);
            $process->run();
            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
                $Correo->enviado = 2;
                $Correo->save();
            } else {
                $Correo->enviado = 1;
                $Correo->save();
            }
            $data = $process->getOutput();
        }

        $Encuesta = respuestas16::where("cuenta", "=", $cuenta)
            ->where("nbr2", "=", $carrera)
            ->first();
        if (!$Encuesta) {
            $Encuesta = new respuestas16();
            $Encuesta->cuenta = $cuenta;
            $Encuesta->nombre = $Egresado->nombre;
            $Encuesta->paterno = $Egresado->paterno;
            $Encuesta->materno = $Egresado->materno;
            $Encuesta->nombre = $Egresado->nombre;
            $Encuesta->nombre = $Egresado->nombre;
            $Encuesta->nbr2 = $carrera;
            $Encuesta->nbr3 = $Egresado->plantel;
            $Encuesta->completed = 0;
            $Encuesta->save();
        }
        return redirect()->route('edit_16',$Encuesta->registro);
    }

    public function edit($id){
        $Encuesta=respuestas16::find($id);
        $Egresado = Egresado::where("cuenta", $Encuesta->cuenta)
            ->where("carrera", $Encuesta->nbr2)
            ->first();
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
        $Telefonos = Telefono::where("cuenta", $Egresado->cuenta)->get();
        $Correos = Correo::where("cuenta", $Egresado->cuenta)->get();
        
        $Reactivos=Reactivo::where('rules','act')->get();
        $Opciones=Option::where('clave','like','%p%r')->get();
        $Bloqueos=DB::table('bloqueos')->join('reactivos','reactivos.clave','bloqueos.clave_reactivo')
        ->where('reactivos.rules','act')
        ->whereIn('bloqueos.bloqueado',$Reactivos->pluck('clave')->toArray())
        ->select('bloqueos.*','reactivos.act_order')
        ->get();

        $Secciones=array(
            array('letter'=>'A',
                  'desc'=>'Datos socioeconómicos',
                  'number'=>'1'),
            array('letter'=>'E',
                  'desc'=>'Actualización académica',
                  'number'=>'2'),
            array('letter'=>'F',
                  'desc'=>'Titulación',
                  'number'=>'3'),            
            array('letter'=>'C',
                  'desc'=>'Datos laborales',
                  'number'=>'4'),
            array('letter'=>'D',
                'desc'=>'Incorporación laboral',
                'number'=>'5'),
            array('letter'=>'G',
                'desc'=>'Habilidades',
                'number'=>'6'),
        );
        return view('encuesta.show_16',compact('Encuesta','Egresado',
                                                'Carrera','Plantel',
                                                'Correos','Telefonos',
                                                'Reactivos','Opciones','Bloqueos',
                                                 'Secciones'));
    }
   
    public function validar($Encuesta){
        $logs="";
        $Reactivos=Reactivo::where('rules','act')->get();
        $Opciones=Option::where('clave','like','%p%r')->get();
        $Bloqueos=DB::table('bloqueos')->join('reactivos','reactivos.clave','bloqueos.clave_reactivo')
         ->where('reactivos.rules','act')
        ->select('bloqueos.*')
        ->get();
        foreach($Reactivos->sortBy('act_order')->where('type','!=','label') as $reactivo){
            $bloqueado=false;
            $field_presenter=$reactivo->clave;
            $logs=$logs."Checando el reactivo".$field_presenter." 
             ";
                if(!$Encuesta->$field_presenter){
                    $logs=$logs."       no hay valor unu <br>";
                    //check si deberia estar blokeadito
                    //bloqueos que bloquearian el rreactivo en cuestion
                    $ThisBloqueos=$Bloqueos->where('bloqueado',$field_presenter);
                    foreach($ThisBloqueos->unique('clave_reactivo')->pluck('clave_reactivo') as $r_block){
                        $OpcionesBloquen=$ThisBloqueos->where('clave_reactivo',$r_block)->pluck('valor');
                        $logs=$logs.'              revisando de los reactivos que bloequan '.$r_block." <br> ";
                        // dd($ThisBloqueos->unique('clave_reactivo')->pluck('clave_reactivo'),
                        //     $field_presenter,
                        //     $r_block,$Encuesta->$r_block,
                        //     $r_block, 
                        //     $OpcionesBloquen,
                        // $ThisBloqueos);
                        if(in_array($Encuesta->$r_block,
                        $OpcionesBloquen->toArray())){
                            $logs=$logs.' Si estaba bloqueado';
                            $bloqueado=true;
                        }
                         
                        }
                        if(!$bloqueado){
                            Session::put('logs',$logs);
                            Session::put('falta',$field_presenter);
                            Session::put('status','incompleta');
                            return false;} 
                }
        }
        
        Session::put('status','completa');
        return true;

    }

    public function update(Request $request,$id){
        // if($request->ncr19==null){
        //     dd('ncr19 es null');
        // }
        // dd($request);
        //for unuque  (clve,blokeado) in bloqueos:
            //
        $rules=[
            "nar8"=>"required",
            "nar9"=>"required",
        ];
        $Encuesta = respuestas16::find($id);
        $Egresado = Egresado::where("cuenta", $Encuesta->cuenta)
            ->where("carrera", $Encuesta->nbr2)
            ->first();
        $Encuesta->aplica = Auth::user()->clave;
        $Encuesta->fec_capt = now()->modify("-6 hours");
        // $request->validate($rules);
        $Encuesta->update($request->except(["_token", "_method"]));
        // 
        if( $this->validar($Encuesta)){
            $Encuesta->completed=1;
            $Encuesta->nbr7=2016;
            $Encuesta->save();
            $Egresado->status=1;
            $Egresado->save();
            //generar .json
            $fileName = $Encuesta->cuenta . ".json";
            $fileStorePath = public_path("storage/json/" . $fileName);

            File::put($fileStorePath, json_encode($Encuesta));

            return view("encuesta.saved", compact("Encuesta"));
            return redirect()->route('muestras16.show',[$Encuesta->nbr2,$Encuesta->nbr3])->with('encuesta','ok');
        }else{ 
            if($Encuesta->completed!=1){
                $Encuesta->save();
            }
            $Egresado->status=10;
            $Egresado->save();
            return back();
        }

    }


    public function  guardar_incompleta($id){
        $Encuesta = respuestas16::find($id);
        $Egresado = Egresado::where("cuenta", $Encuesta->cuenta)
            ->where("carrera", $Encuesta->nbr2)
            ->first();
        $Egresado->status=10;
        $Egresado->save();

           return view('encuesta.act16.inicio');
    }
}