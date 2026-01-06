<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use App\Models\Egresado;
use App\Models\EgresadoPosgrado;
use App\Models\Carrera;
use App\Models\Telefono;
class TelefonosController extends Controller

{
    public function create($cuenta,$carrera,$encuesta = null, $telefono_id = null){

        $TelefonoEnLlamada=Telefono::find($telefono_id);
        $Egresado=Egresado::where('cuenta',$cuenta)->where('carrera',$carrera)->first();
        
        return view('encuesta.seg20.create_telefono',compact('Egresado','encuesta','TelefonoEnLlamada'));
    }

    public function createPos($cuenta,$programa,$encuesta = null, $telefono_id = null){

        $TelefonoEnLlamada=Telefono::find($telefono_id);
        $EgresadoPos=EgresadoPosgrado::where('cuenta',$cuenta)->where('programa',$programa)->first();

        return view('encuesta.seg20.create_telefono', compact('EgresadoPos','encuesta','TelefonoEnLlamada'));

    }



    public function storePos(Request $request ,$cuenta,$programa,$encuesta=0,$telefono_id){

        $request->validate([
            'telefono' => 'required|string|max:20|unique:telefonos,telefono',
            'descripcion' => 'nullable|string|max:255',
        ], [
            'telefono.required' => 'El campo teléfono es obligatorio.',
            'telefono.unique' => 'Este número ya está registrado.',
        ]);

        $TelefonoEnLlamada=Telefono::find($telefono_id);
        $EgresadoPos=EgresadoPosgrado::where('cuenta',$cuenta)->where('programa',$programa)->first();

        $Telefono = new Telefono();
        $Telefono->cuenta = $cuenta;
        $Telefono->telefono = $request->telefono;
        $Telefono->descripcion = $request->description;
        $Telefono->status = 0;
        $Telefono->save();

        $redirectUrl = $this->getRedirectUrl($Egresado, $encuesta, $telefono_id);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true, 
                'message' => 'Teléfono agregado correctamente',
                'telefono' => $Telefono,
                'redirect_url' => $redirectUrl
            ]);
        }
        
        return redirect($redirectUrl);

    }

    


    public function store(Request $request ,$cuenta,$carrera,$encuesta=0,$telefono_id){

        //Validacion de que el telefono no esté repetido
        $request->validate([
            'telefono' => 'required|string|max:20|unique:telefonos,telefono',
            'descripcion' => 'nullable|string|max:255',
        ], [
            'telefono.required' => 'El campo teléfono es obligatorio.',
            'telefono.unique' => 'Este número ya está registrado.',
        ]);


        $TelefonoEnLlamada=Telefono::find($telefono_id);
        $Egresado=Egresado::where('cuenta',$cuenta)->where('carrera',$carrera)->first();

        $Telefono=new Telefono();
        $Telefono->cuenta=$cuenta;
        $Telefono->telefono=$request->telefono;
        $Telefono->descripcion=$request->description;
        $Telefono->status=0;

        $Telefono->save();

        $redirectUrl = $this->getRedirectUrl($Egresado, $encuesta, $telefono_id);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true, 
                'message' => 'Teléfono agregado correctamente',
                'telefono' => $Telefono,
                'redirect_url' => $redirectUrl
            ]);
        }
        
        return redirect($redirectUrl);
    }

    protected function getRedirectUrl($Egresado, $encuesta, $telefono_id)
    {
        if ($Egresado->act_suvery == 1) {
            if ($encuesta == '2016') {
                return route('act_data', [$Egresado->cuenta, $Egresado->carrera, $encuesta, $telefono_id]);
            } else {
                return route('edit_16', [$encuesta]);
            }
        }
    
        if ($Egresado->muestra == 3) {
            if ($encuesta == '2020') {
                return route('act_data', [$Egresado->cuenta, $Egresado->carrera, $encuesta, $telefono_id]);
            } else {
                return route('edit_20', [$encuesta, 'SEARCH']);
            }
        }
    
        if ($Egresado->muestra == 5) {
            if ($encuesta == '2022') {
                return route('act_data', [$Egresado->cuenta, $Egresado->carrera, $encuesta, $telefono_id]);
            } else {
                return route('edit_22', [$encuesta, 'SEARCH']);
            }
        }
        if ($Egresado->plan != null) {
            dd('Posgrado');
            if ($encuesta == '2022') {
                return route('act_data', [$Egresado->cuenta, $Egresado->carrera, $encuesta, $telefono_id]);
            } else {
                return route('edit_22', [$encuesta, 'SEARCH']);
            }
        }
    }



    public function edit($id,$carrera,$encuesta=0,$telefono_id){
        $TelefonoEnLlamada=Telefono::find($telefono_id);
        $Telefono=Telefono::find($id);
        $Egresado=Egresado::where('cuenta',$Telefono->cuenta)->where('carrera',$carrera)->first();
        return view('encuesta.seg20.editar_telefono',compact('Egresado','Telefono','encuesta','TelefonoEnLlamada'));
    }



    public function update(Request $request ,$id,$carrera,$encuesta,$telefono_id){

        //Validacion de que el telefono no esté repetido
        $request->validate([
            'telefono' => 'required|string|max:20|unique:telefonos,telefono,'.$id,
            'descripcion' => 'nullable|string|max:255',
        ], [
            'telefono.required' => 'El campo teléfono es obligatorio.',
            'telefono.unique' => 'Este número ya está registrado.',
        ]);

        $TelefonoEnLlamada=Telefono::find($telefono_id);
        $Telefono=Telefono::find($id);
        $Egresado=Egresado::where('cuenta',$Telefono->cuenta)->where('carrera',$carrera)->first();
        
        $Telefono->telefono=$request->telefono;
        $Telefono->descripcion=$request->description;
        // $Telefono->status=0;
        $Telefono->save();
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
}
