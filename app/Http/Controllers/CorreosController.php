<?php

namespace App\Http\Controllers;
use App\Models\Egresado;
use App\Models\Carrera;
use App\Models\Correo;
use Illuminate\Http\Request;
use Symfony\Component\Process\Process; 
use Symfony\Component\Process\Exception\ProcessFailedException; 

class CorreosController extends Controller
{
    public function create($cuenta,$carrera,$encuesta){
        $Egresado=Egresado::where('cuenta',$cuenta)->where('carrera',$carrera)->first();
        $Carrera=Carrera::where('clave_carrera','=',$Egresado->carrera)->first()->carrera;
        $Plantel=Carrera::where('clave_plantel','=',$Egresado->plantel)->first()->plantel;
     
        return view('encuesta.seg20.create_correo',compact('Egresado','Carrera','Plantel','encuesta'));
    }
    public function store(Request $request ,$cuenta,$carrera,$encuesta){
        $Egresado=Egresado::where('cuenta',$cuenta)->where('carrera',$carrera)->first();
        $Correo=new Correo();
        $Correo->cuenta=$cuenta;
        $Correo->correo=$request->correo;
        $Correo->status='13';
        $Correo->enviado=0;
        $Correo->save();
        if($encuesta == '2020'){
            return redirect()->route('encuesta20.act_data',[$Egresado->cuenta,$Egresado->carrera, $encuesta]);}
            else{
                return redirect()->route('edit_20',[$encuesta,'SEARCH']);
            }
        
    }
    public function edit($id,$carrera,$encuesta){
        $Correo=Correo::find($id);
        $Egresado=Egresado::where('cuenta',$Correo->cuenta)->where('carrera',$carrera)->first();
        $Carrera=Carrera::where('clave_carrera','=',$Egresado->carrera)->first()->carrera;
        $Plantel=Carrera::where('clave_plantel','=',$Egresado->plantel)->first()->plantel;
     
        return view('encuesta.seg20.editar_correo',compact('Egresado','Correo','Carrera','Plantel','encuesta'));
    }
    public function update(Request $request ,$id,$carrera,$encuesta){
        $Correo=Correo::find($id);
        $Egresado=Egresado::where('cuenta',$Correo->cuenta)->where('carrera',$carrera)->first();
        
        $Correo->correo=$request->correo;
        $Correo->status=$request->status;
        $Correo->enviado=0;
        $Correo->save();
        if($encuesta == '2020'){
            return redirect()->route('encuesta20.act_data',[$Egresado->cuenta,$Egresado->carrera, $encuesta]);}
            else{
                return redirect()->route('edit_20',[$encuesta,'SEARCH']);
            }
   }

    public function direct_send($id){
        $Correo=Correo::find($id);
        $Egresado=Egresado::where('cuenta',$Correo->cuenta)->first();
        $caminoalpoder=public_path();
        $process = new Process([env('PY_COMAND'),$caminoalpoder.'/aviso.py',$Egresado->nombre.$Egresado->paterno,$Correo->correo]);
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
