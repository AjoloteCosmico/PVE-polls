<?php

namespace App\Http\Controllers;
use App\Models\Egresado;
use App\Models\EgresadoEspecialidad;
use App\Models\EgresadoPosgrado;
use App\Models\Carrera;
use App\Models\Correo;
use App\Models\Telefono;
use Illuminate\Http\Request;
use Symfony\Component\Process\Process; 
use Symfony\Component\Process\Exception\ProcessFailedException; 
use Session;

use App\Traits\LogEvents;
class CorreosController extends Controller
{
    
use  LogEvents;
    public function create($cuenta,$carrera,$encuesta,$telefono_id){
        // dd($encuesta);
        $TelefonoEnLlamada=Telefono::find($telefono_id);
        $Egresado=Egresado::where('cuenta',$cuenta)->where('carrera',$carrera)->first();
        if($carrera==0){
            if($encuesta=='especialidad'){
                $Egresado=EgresadoEspecialidad::where('cuenta',$cuenta)->where('especialidad',Session::get('plan_especialidad'))->first();
                $Carrera=$Egresado->especialidad;
                $Plantel=$Egresado->plantel;

            }else{
            $Egresado=EgresadoPosgrado::where('cuenta',$cuenta)->where('plan',Session::get('plan_posgrado'))->first();
            $Carrera=$Egresado->programa;
            $Plantel=$Egresado->plan;}
        }else{
        $Carrera=Carrera::where('clave_carrera','=',$Egresado->carrera)->first()->carrera;
        $Plantel=Carrera::where('clave_plantel','=',$Egresado->plantel)->first()->plantel;
        }
        
        return view('encuesta.seg20.create_correo',compact('Egresado','Carrera','Plantel','encuesta','TelefonoEnLlamada'));
    }

    public function create_unificado($cuenta,$carrera,$programa,$encuesta,$telefono_id, $muestra_id = null){
        $TelefonoEnLlamada=Telefono::find($telefono_id);
        $Egresado = Egresado::where('cuenta', $cuenta)->where('carrera', $carrera)->first();
        if ($muestra_id == 897){
                return view('encuesta.create_correo_sondeo', compact('Egresado','encuesta','TelefonoEnLlamada'));
        } else {
            return view('encuesta.create_correo_sondeo', compact('Egresado','encuesta','TelefonoEnLlamada'));
        }
    }

    public function store(Request $request ,$cuenta,$carrera,$encuesta,$telefono_id, $muestra_id = null){

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
        if($carrera==0){
            $Egresado=EgresadoPosgrado::where('cuenta',$cuenta)->where('plan',Session::get('plan_posgrado'))->first();
        }
        
        $Correo=new Correo();
        $Correo->cuenta=$cuenta;
        $Correo->correo=$request->correo;
        $Correo->status='13';
        $Correo->enviado=0;   

        $Correo->save();
        $this->recordEvent($Correo->id, 'create_correo', ' ');
        $redirectUrl = $this->getRedirectUrl($Egresado, $encuesta, $telefono_id, $muestra_id);

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

    protected function getRedirectUrl($Egresado, $encuesta, $telefono_id, $muestra_id = null)
    {
        if($muestra_id == 897){
            return route('act_data_continua', [$Egresado->cuenta, $Egresado->carrera, $encuesta, $telefono_id]);
        }
        if($muestra_id == 898){
            return route('act_data_verde', [$Egresado->cuenta, $Egresado->carrera, $encuesta, $telefono_id]);
        }
    
        if ($Egresado->carrera==0) {
            if ($encuesta == 'posgrado') {
                return route('act_data_posgrado', [$Egresado->cuenta, $Egresado->programa,$Egresado->plan, $telefono_id]);
            } else {
                return route('posgrado.show', [ 'SEARCH',$encuesta]);
            }
        }

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
        if($carrera==0){
            $Egresado=EgresadoPosgrado::where('cuenta',$Correo->cuenta)->where('plan',Session::get('plan_posgrado'))->first();
            $Carrera=$Egresado->programa;
            $Plantel=$Egresado->plan;
        }else{
        $Carrera=Carrera::where('clave_carrera','=',$Egresado->carrera)->first()->carrera;
        $Plantel=Carrera::where('clave_plantel','=',$Egresado->plantel)->first()->plantel;
        }
        return view('encuesta.seg20.editar_correo',compact('Egresado','Correo','Carrera','Plantel','encuesta','TelefonoEnLlamada'));
    }

    public function edit_unificado($id,$carrera,$encuesta,$telefono_id, $muestra_id = null){
        $TelefonoEnLlamada=Telefono::find($telefono_id);
        $Correo=Correo::find($id);
        $Egresado = Egresado::where('cuenta', $Correo->cuenta)->where('carrera', $carrera)->first();
        if ($muestra_id == 897){
            return view('encuesta.edit_correo_sondeo', compact('Egresado','Correo','encuesta','TelefonoEnLlamada' ));
        } else {
            return view('encuesta.edit_correo_sondeo', compact('Egresado','Correo','encuesta','TelefonoEnLlamada' ));
        }
    }


    public function update(Request $request ,$id,$carrera,$encuesta,$telefono_id, $muestra_id = null){

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
        if($carrera==0){
            $Egresado=EgresadoPosgrado::where('cuenta',$Correo->cuenta)->where('plan',Session::get('plan_posgrado'))->first();
        }
        $Correo->correo=$request->correo;
        $Correo->status=$request->status;
        $Correo->enviado=0;
        $Correo->save();
        

        $redirectUrl = $this->getRedirectUrl($Egresado, $encuesta, $telefono_id, $muestra_id);
        
        $this->recordEvent($Correo->id, 'update_correo', ' ');
        return redirect($redirectUrl);
       
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
        
        $this->recordEvent($Correo->id, 'direct_send', ' ');
        return redirect()->back();
 
 }

 public function posgrado_direct_send($id){
        $Correo=Correo::find($id);
        $Egresado=EgresadoPosgrado::where('cuenta',$Correo->cuenta)->first();
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

        $this->recordEvent($Correo->id, 'direct_send_pos', ' ');
        return redirect()->back();
 
 }

  public function store_async(Request $request ){

        //Validacion de que el telefono no esté repetido
        $request->validate([
            'correo' => 'required|string|max:40|unique:correos,correo',
            'descripcion' => 'nullable|string|max:255',
        ], [
            'correo.required' => 'El campo correo es obligatorio.',
            'correo.unique' => 'Este correo ya está registrado.',
        ]);


        $Correo=new Correo();
        $Correo->cuenta=$request->cuenta;
        $Correo->correo=$request->correo;
        $Correo->descripcion=$request->description;
        //ABAJO EL ESTATUS NO DEBE´RIA SER 0 PORK NO ES SIN DATOS, SABEMOS Q SI LO USA EL EGRESADO
        $Correo->status=0;

        $Correo->save();
        $this->recordEvent($Correo->id, 'create_correo', $request->type.' encuestaKey: '. $request->encuesta_id);
        
       
            return response()->json([
                'success' => true, 
                'status' => 'sin datos',
                'message' => 'Correo agregado correctamente',
                'correo' => $Correo,
            ]);
        
        
    }
 
}

