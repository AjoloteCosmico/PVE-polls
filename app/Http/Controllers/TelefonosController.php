<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use App\Models\Egresado;
use App\Models\Carrera;
use App\Models\Telefono;
class TelefonosController extends Controller
{
    public function create($cuenta,$carrera,$encuesta){
        $Egresado=Egresado::where('cuenta',$cuenta)->where('carrera',$carrera)->first();
        
        return view('encuesta.seg20.create_telefono',compact('Egresado','encuesta'));
    }
    public function store(Request $request ,$cuenta,$carrera,$encuesta=0){
        $Egresado=Egresado::where('cuenta',$cuenta)->where('carrera',$carrera)->first();
        $Correo=new Telefono();
        $Correo->cuenta=$cuenta;
        $Correo->telefono=$request->telefono;
        $Correo->descripcion=$request->description;
        $Correo->status=0;
        $Correo->save();
        if($encuesta == '2020'){
        return redirect()->route('encuesta20.act_data',[$Egresado->cuenta,$Egresado->carrera,$encuesta]);}
        else{
            return redirect()->route('edit_20',[$encuesta,'SEARCH']);
        }
     }
    public function edit($id,$carrera,$encuesta=0){
        $Telefono=Telefono::find($id);
        $Egresado=Egresado::where('cuenta',$Telefono->cuenta)->where('carrera',$carrera)->first();
        return view('encuesta.seg20.editar_telefono',compact('Egresado','Telefono','encuesta'));
    }
    public function update(Request $request ,$id,$carrera,$encuesta){
        $Telefono=Telefono::find($id);
        $Egresado=Egresado::where('cuenta',$Telefono->cuenta)->where('carrera',$carrera)->first();
        
        $Telefono->telefono=$request->telefono;
        $Telefono->descripcion=$request->description;
        // $Telefono->status=0;
        $Telefono->save();
        if($encuesta == '2020'){
            return redirect()->route('encuesta20.act_data',[$Egresado->cuenta,$Egresado->carrera,$encuesta]);}
            else{
                return redirect()->route('edit_20',[$encuesta,'SEARCH']);
            }
        }
}
