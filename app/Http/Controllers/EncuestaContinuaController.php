<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\respuestas_continua;
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


class EncuestaContinuaController extends Controller
{
    
    

    public function comenzar($correo, $cuenta, $carrera)
    {
        $Correo = Correo::find($correo);
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
                $Correo->save();
            } else {
                $Correo->enviado = 1;
                $Correo->save();
            }
            $data = $process->getOutput();
        }

        $Encuesta = respuestas_continua::where("cuenta", $cuenta)
            ->where("nbr2", $carrera)
            ->first();
        if (!$Encuesta) {
            $Encuesta = new respuestas_continua();
            $Encuesta->cuenta = $cuenta;
            $Encuesta->paterno = $Egresado->paterno;
            $Encuesta->materno = $Egresado->materno;
            $Encuesta->nombre = $Egresado->nombre;
            $Encuesta->nbr2 = $carrera;
            $Encuesta->nbr3 = $Egresado->plantel;
            
            $Encuesta->anio_egreso = $Egresado->anio_egreso;
            $Encuesta->carrera = Carrera::where(
                "clave_carrera",
                "=",
                $Egresado->carrera
            )
                ->first()
                ->carrera;
            $Encuesta->completed = 0;
            $EgMuestra=DB::table('egresado_muestra')
                ->where('egresado_id',$Egresado->id)
                ->where('muestra_id',897) //ID de muestra de educación continua
                ->update(['status' => 10,
                'updated_at'=>now()]);
            $Encuesta->save();
        }
        return redirect()->route('completar_encuesta_continua', [$Encuesta->registro]);
    }



    public function edit($id)
    {
        $Encuesta=respuestas_continua::find($id);

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
        $Telefonos =Telefono::where("cuenta", $Egresado->cuenta)->get();
        
        $Correos = Correo::where("cuenta", $Egresado->cuenta)->get();
        $Reactivos = Reactivo::where('section','ed_continua')->get();


        $multiple_options = Option::whereIn('reactivo', $Reactivos->pluck('clave'))->get();
        $multiple_option_answers = multiple_option_answer::where('encuesta_id', $Encuesta->registro)->get();
        $RespuestasMultiples = $multiple_option_answers->groupBy('reactivo');
        
        $Opciones=Option::where('clave','like','%p%r')->get();

        $ReactivoClaves = $Reactivos->pluck('clave');
        $BloqueosSeccion = Bloqueo::whereIn('clave_reactivo', $ReactivoClaves)->get();
        
        
        return view('muestras.ed_continua.show_edit_continua',compact('Encuesta','Egresado',
                                                                       'Carrera','Plantel','Telefonos',
                                                                       'Correos','Reactivos','Opciones',
                                                                       'BloqueosSeccion','multiple_option_answers', 'multiple_options', 'RespuestasMultiples'));

    }

    
    public function update(Request $request, $id)
    {
        $Encuesta = respuestas_continua::find($id);
        $Egresado = Egresado::where("cuenta", $Encuesta->cuenta)
            ->where("carrera", $Encuesta->nbr2)
            ->first();

        //$Encuesta->aplica = Auth::user()->clave;
        $Encuesta->update($request->except(['_token', 'btn_pressed', 'aplica']));

        $reactivos_multiples = Reactivo::where('type', 'multiple_option')
                                   ->where('section', 'ed_continua')
                                   ->get();

        foreach ($reactivos_multiples as $r) {
        $clave = $r->clave;

        
        multiple_option_answer::where('encuesta_id', $Encuesta->registro) 
            ->where('reactivo', $clave)
            ->delete();

        foreach ($request->all() as $key => $value) {
            if (str_starts_with($key, $clave . 'opcion')) {
                $valor_opcion = str_replace($clave . 'opcion', '', $key);

                if (!empty($valor_opcion)) {
                    $answer = new multiple_option_answer();
                    $answer->encuesta_id = $Encuesta->registro; 
                    $answer->reactivo = $clave;
                    $answer->clave_opcion = $valor_opcion;
                    $answer->save();
                }
            }
        }
    }




        if($request->btn_pressed === 'guardar'){
            $this->validar($Encuesta);
 
            if($Encuesta->completed != 1){
                $Encuesta->save();
                $EgMuestra=DB::table('egresado_muestra')
                        ->where('egresado_id',$Egresado->id)
                        ->where('muestra_id',897) //ID de muestra de educación continua
                        ->update(['status' => 10,'updated_at'=>now()]);
            }else{
                 $EgMuestra=DB::table('egresado_muestra')
                        ->where('egresado_id',$Egresado->id)
                        ->where('muestra_id',897) //ID de muestra de educación continua
                        ->update(['status' => 1,'updated_at'=>now()]);
           
            }
            return back();
        }

        if($this->validar($Encuesta)){
            
            if ($Encuesta->completed != 1){
            $Encuesta->fec_capt = now()->modify("-6 hours");

                    }
            $Encuesta->completed=1;
            $Encuesta->aplica=Auth::user()->clave;
            $EgMuestra=DB::table('egresado_muestra')
                ->where('egresado_id',$Egresado->id)
                ->where('muestra_id',897) //ID de muestra de educación continua
                ->update(['status' => $request->code,'updated_at'=>now()]);
            $Encuesta->save();
            $EgMuestra=DB::table('egresado_muestra')
                        ->where('egresado_id',$Egresado->id)
                        ->where('muestra_id',897) //ID de muestra de educación continua
                        ->update(['status' => 1,'updated_at'=>now()]);
            $fileName = $Encuesta->cuenta . ".json";
            $fileStorePath = public_path("storage/json/" . $fileName);
            File::put($fileStorePath, json_encode($Encuesta));

            return view("encuesta.saved_continua", compact("Encuesta"));
            return redirect()->route('',[$Encuesta->nbr2,$Encuesta->nbr3])->with('encuesta','ok');
        } else {
          
            if($Encuesta->completed!=1){
                $Encuesta->save();
                $EgMuestra=DB::table('egresado_muestra')
                        ->where('egresado_id',$Egresado->id)
                        ->where('muestra_id',897) //ID de muestra de educación continua|    
                        ->update(['status' => 1,'updated_at'=>now()]);
            }
            $Encuesta->save();
                
            if($request->btn_pressed == "inconclusa"){
                $EgMuestra=DB::table('egresado_muestra')
                        ->where('egresado_id',$Egresado->id)
                        ->where('muestra_id',897) //ID de muestra de educación continua
                        ->update(['status' => 10,'updated_at'=>now()]);
                return redirect()->route('llamar',['2016',$Egresado->cuenta,$Egresado->carrera]);
            }
            return back();

        }

    }

    public function validar($Encuesta)
    {
        $Egresado = Egresado::where("cuenta", $Encuesta->cuenta)
                        ->where("carrera", $Encuesta->nbr2)
                        ->first();
        $logs = "";
        $Reactivos = Reactivo::where('section', 'ed_continua')->get();
    

        $Bloqueos = DB::table('bloqueos')
            ->join('reactivos', 'reactivos.clave', '=', 'bloqueos.clave_reactivo')
            ->where('reactivos.section', 'ed_continua')
            ->select('bloqueos.*')
            ->get();


        $RespuestasMultiples = multiple_option_answer::where('encuesta_id', $Encuesta->registro)->get();

        foreach ($Reactivos->sortBy('order')->where('type', '!=', 'label') as $reactivo) {
            $bloqueado = false;
            $field_presenter = $reactivo->clave;
            $logs .= "Checando el reactivo: " . $field_presenter . "<br>";

        
            $tieneValor = false;
            if ($reactivo->type == 'multiple_option') {
                
                $tieneValor = $RespuestasMultiples->where('reactivo', $field_presenter)->count() > 0;
            } else {
                
                $tieneValor = !empty($Encuesta->$field_presenter);
            }

            if (!$tieneValor) {
                $logs .= "       no hay valor unu <br>";
                $ThisBloqueos = $Bloqueos->where('bloqueado', $field_presenter);

                foreach ($ThisBloqueos->unique('clave_reactivo')->pluck('clave_reactivo') as $r_block) {
                    $OpcionesBloquen = $ThisBloqueos->where('clave_reactivo', $r_block)->pluck('valor');
                    $logs .= '              revisando reactivo bloqueante: ' . $r_block . " <br> ";

                    
                    $reactivoQueBloquea = $Reactivos->where('clave', $r_block)->first();

                    if ($reactivoQueBloquea && $reactivoQueBloquea->type == 'multiple_option') {
                        
                        $respuestasDadas = $RespuestasMultiples->where('reactivo', $r_block)->pluck('clave_opcion');
                        $interseccion = array_intersect($respuestasDadas->toArray(), $OpcionesBloquen->toArray());
                    
                        if (!empty($interseccion)) {
                            $logs .= ' Si estaba bloqueado por opción múltiple';
                            $bloqueado = true;
                        }
                    } else {
                        
                        if (in_array($Encuesta->$r_block, $OpcionesBloquen->toArray())) {
                            $logs .= ' Si estaba bloqueado';
                            $bloqueado = true;
                        }
                    }
                }

                if (!$bloqueado) {
                   
                    
                    Session::put('logs', $logs);
                    Session::put('falta', $field_presenter);
                    Session::put('status', 'incompleta');

                    $Encuesta->completed = 0;
                    $Encuesta->save();
                    $EgMuestra=DB::table('egresado_muestra')
                        ->where('egresado_id',$Egresado->id)
                        ->where('muestra_id',897) //ID de muestra de educación continua
                        ->update(['status' => 10,'updated_at'=>now()]);
                    return false;
                }
            }
        }

        
        $Encuesta->completed = 1;
        $Encuesta->fec_capt = now()->modify("-6 hours");
        $Encuesta->aplica = Auth::user()->clave;
        $EgMuestra=DB::table('egresado_muestra')
                ->where('egresado_id',$Egresado->id)
                ->where('muestra_id',897) //ID de muestra de educación continua
                ->update(['status' => 1,'updated_at'=>now()]);
        $Encuesta->save();
        Session::put('status', 'completa');
        return true;
       
    } 
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(respuestas_continua $respuestas_continua)
    {
        //
    }

}


