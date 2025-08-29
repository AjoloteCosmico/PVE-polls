<?php

namespace App\Http\Controllers;

use App\Models\Reactivo;
use App\Models\Option;
use Illuminate\Http\Request;
use DB;
class ComponentController extends Controller
{
    public function RenderText($clave,$width){

        return view('components.text',compact('width'));
    }
    
    public function RenderOption($clave,$width){

        return view('components.text',compact('width'));
    }
    
    public static function RenderReactive($Reactivo,$Opciones,$value){
        // $Reactivo=reactivos_posgrado::find($id);
        // $Opciones=opciones_posgrado::where('reactivo',$Reactivo->clave)->get();
        if($Reactivo->archtype){
            // dd($Reactivo->archtype);  
            $Opciones=Option::where('reactivo',$Reactivo->archtype)->get();
        }else{
            $Opciones=Option::where('reactivo',$Reactivo->clave)->orderBy('clave', 'ASC')->get();
        }
        return view('components.'.$Reactivo->type,compact('Reactivo','Opciones','value'));
    }
}
