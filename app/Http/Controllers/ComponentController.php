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
    
    public static function RenderReactive($Reactivo,$Opciones,$value, $disabled = false){
        // $Reactivo=reactivos_posgrado::find($id);
        // $Opciones=opciones_posgrado::where('reactivo',$Reactivo->clave)->get();
        if($Reactivo->archtype){
            // dd($Reactivo->archtype);  
            $Opciones=Option::where('reactivo',$Reactivo->archtype)->get();
        }else{
            $Opciones=Option::where('reactivo',$Reactivo->clave)->orderBy('clave', 'ASC')->get();
        }
        return view('components.'.$Reactivo->type,compact('Reactivo','Opciones','value', 'disabled'));
    }

    public static function RenderMultiple($reactivo_id, $all_options, $user_answers)
    {
        $Reactivo = Reactivo::find($reactivo_id);

        // Filtramos las opciones y respuestas relevantes para este reactivo.
        $Opciones = $all_options->where('reactivo', $Reactivo->clave);
        $answers = $user_answers->where('reactivo', $Reactivo->clave)->pluck('clave_opcion')->toArray();
        
        // La lógica de bloqueos no debería estar aquí para ser más eficiente.
        // Se maneja mejor en el controlador principal y se pasa a la vista.
        
        return view('components.multiple_option', compact('Reactivo', 'Opciones', 'answers'));
    }
}


