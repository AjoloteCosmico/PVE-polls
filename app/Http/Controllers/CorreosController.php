<?php

namespace App\Http\Controllers;
use App\Models\Egresado;
use App\Models\Carrera;
use App\Models\Correo;
use App\Models\Telefono;
use Illuminate\Http\Request;
use Symfony\Component\Process\Process; 
use Symfony\Component\Process\Exception\ProcessFailedException; 

class CorreosController extends Controller
{
    public function create($cuenta,$carrera,$encuesta,$telefono_id){
        $TelefonoEnLlamada=Telefono::find($telefono_id);
        $Egresado=Egresado::where('cuenta',$cuenta)->where('carrera',$carrera)->first();
        $Carrera=Carrera::where('clave_carrera','=',$Egresado->carrera)->first()->carrera;
        $Plantel=Carrera::where('clave_plantel','=',$Egresado->plantel)->first()->plantel;
        return view('encuesta.seg20.create_correo',compact('Egresado','Carrera','Plantel','encuesta','TelefonoEnLlamada'));
    }

    public function store(Request $request ,$cuenta,$carrera,$encuesta,$telefono_id){

        //Validacion de que el correo no esté repetido
        $request->validate([
            'correo' => 'required|email|unique:correos,correo',
        ], [
            'correo.required' => 'Debes ingresar un correo.',
            'correo.email' => 'El formato del correo no es válido.',
            'correo.unique' => 'Este correo ya está registrado en el sistema.',
        ]);

        $TelefonoEnLlamada=Telefono::find($telefono_id);
        $Egresado=Egresado::where('cuenta',$cuenta)->where('carrera',$carrera)->first();

        $Correo=new Correo();
        $Correo->cuenta=$cuenta;
        $Correo->correo=$request->correo;
        $Correo->status='13';
        $Correo->enviado=0;   

        $Correo->save();

        $redirectUrl = $this->getRedirectUrl($Egresado, $encuesta, $telefono_id);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true, 
                'message' => 'Correo agregado correctamente',
                'correo' => $Correo,
                'redirect_url' => $redirectUrl
            ]);
        }

        return redirect($redirectUrl);  
    }

    protected function getRedirectUrl($Egresado, $encuesta, $telefono_id)
    {
        if($Egresado->act_suvery==1){
            if($encuesta == '2016'){
                return route('act_data',[$Egresado->cuenta,$Egresado->carrera, $encuesta,$telefono_id]);
            }else{
                return route('edit_16',[$encuesta]);
            }
        }
        
        if($Egresado->muestra==3){
            if($encuesta == '2020'){
                return route('act_data',[$Egresado->cuenta,$Egresado->carrera, $encuesta,$telefono_id]);
            }else{
                return route('edit_20',[$encuesta,'SEARCH']);
            }
        }
        if($Egresado->muestra==5){
            if($encuesta == '2022'){
                return route('act_data',[$Egresado->cuenta,$Egresado->carrera, $encuesta,$telefono_id]);
            }else{
                return route('edit_22',[$encuesta,'SEARCH']);
            }
        }
    }



    public function edit($id,$carrera,$encuesta,$telefono_id){
        $TelefonoEnLlamada=Telefono::find($telefono_id);
        $Correo=Correo::find($id);
        $Egresado=Egresado::where('cuenta',$Correo->cuenta)->where('carrera',$carrera)->first();
        $Carrera=Carrera::where('clave_carrera','=',$Egresado->carrera)->first()->carrera;
        $Plantel=Carrera::where('clave_plantel','=',$Egresado->plantel)->first()->plantel;
        return view('encuesta.seg20.editar_correo',compact('Egresado','Correo','Carrera','Plantel','encuesta','TelefonoEnLlamada'));
    }


    public function update(Request $request ,$id,$carrera,$encuesta,$telefono_id){

        //Validacion de que el correo no esté repetido

        $request->validate([
            'correo' => 'required|email|unique:correos,correo,'. $id,
        ], [
            'correo.required' => 'Debes ingresar un correo.',
            'correo.email' => 'El formato del correo no es válido.',
            'correo.unique' => 'Este correo ya está registrado en el sistema.',
        ]);

        $Correo=Correo::find($id);
        $Egresado=Egresado::where('cuenta',$Correo->cuenta)->where('carrera',$carrera)->first();
        $Correo->correo=$request->correo;
        $Correo->status=$request->status;
        $Correo->enviado=0;
        $Correo->save();
        //TODO: parece que hay que agregar otro parametro para el caso en que viene de una encuesta 
        if($Egresado->act_suvery==1){
            if($encuesta == '2016'){
                return redirect()->route('act_data',[$Egresado->cuenta,$Egresado->carrera, $encuesta,$telefono_id]);
            }else{
                return redirect()->route('edit_16',[$encuesta]);
            }
        }

        if($Egresado->muestra==3){
            if($encuesta == '2020'){
                return redirect()->route('act_data',[$Egresado->cuenta,$Egresado->carrera, $encuesta,$telefono_id]);
            }else{
                return redirect()->route('edit_20',[$encuesta,'SEARCH']);
            }
        }
        if($Egresado->muestra==5){
            if($encuesta == '2022'){
                return redirect()->route('act_data',[$Egresado->cuenta,$Egresado->carrera, $encuesta,$telefono_id]);
            }else{
                return redirect()->route('edit_22',[$encuesta,'SEARCH']);
            }
        }
   }

    public function direct_send($id){
        $Correo=Correo::find($id);
        $Egresado=Egresado::where('cuenta',$Correo->cuenta)->first();
        $caminoalpoder=public_path();
        $process = new Process([env('PY_COMAND'),$caminoalpoder.'/aviso.py',$Egresado->nombre.' '.$Egresado->paterno,$Correo->correo]);
        $process->run();
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }else{
            $Correo->enviado=1;
            $Correo->save();
        }
        $data = $process->getOutput();

        return redirect()->back();
 
 }
}

