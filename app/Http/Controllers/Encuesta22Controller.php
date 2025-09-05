<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Egresado;
use App\Models\Carrera;
use App\Models\Correo;
use App\Models\Telefono;
use App\Models\respuestas20;
use App\Models\Reactivo;
use App\Models\Bloqueo;
use App\Models\Option;
use App\Models\multiple_option_answer;
use DB;
use App\Models\historico_encuestas;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use App\Models\Comentario;
use Illuminate\Support\Facades\Auth;
use File;
use Session;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class Encuesta22Controller extends Controller
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
                $Correo->enviado = 2;
                $Correo->save();
            } else {
                $Correo->enviado = 1;
                $Correo->save();
            }
            $data = $process->getOutput();
        }
        
        $Encuesta = respuestas20::where("cuenta", "=", $cuenta)
            ->where("nbr2", "=", $carrera)
            ->first();

        if ($Encuesta) {
            return redirect()->route('edit_22', [
                'id' => $Encuesta->registro,
                'section' => 'SEARCH'
            ]);
        } else {
            $Encuesta = new respuestas20();
            $Encuesta->cuenta = $cuenta;
            $Encuesta->nombre = $Egresado->nombre;
            $Encuesta->paterno = $Egresado->paterno;
            $Encuesta->materno = $Egresado->materno;
            $Encuesta->nombre = $Egresado->nombre;
            $Encuesta->nombre = $Egresado->nombre;
            $Encuesta->nbr2 = $carrera;
            $Encuesta->nbr3 = $Egresado->plantel;
            $Encuesta->gen_dgae = 2022;
            $Encuesta->completed = 0;
            $Encuesta->save();
            return redirect()->route('edit_22', [
                'id' => $Encuesta->registro,
                'section' => 'A'
            ]);
        }
    }

    public function edit_22($id, $section)
    {
        $Encuesta = respuestas20::where("registro", $id)->first();
        
        $Egresado = Egresado::where("cuenta", $Encuesta->cuenta)->first();
        $Carrera = Carrera::where("clave_carrera", $Egresado->carrera)->first()->carrera;
        $Plantel = Carrera::where("clave_plantel", $Egresado->plantel)->first()->plantel;

        //navegacion en secciones
        if ($section == "SEARCH"){
            foreach (["A", "E", "F", "C", "D", "G"] as $sec){
                $format_field = "sec_" . strtolower($sec);
                if ($Encuesta->$format_field != 1){
                    $section = $sec;
                    break;
                }
            }
            if ($section == "SEARCH"){
                $section = "A"; //default section
            }
        }

        $Reactivos = Reactivo::where('section', $section)->orderBy('orden')->get();
        $Telefonos = Telefono::where("cuenta", $Egresado->cuenta)->get();
        $Correos = Correo::where("cuenta", $Egresado->cuenta)->get();

        $Bloqueos = DB::table('bloqueos')
            ->join('reactivos', 'bloqueos.clave_reactivo', 'reactivos.clave')
            ->where('reactivos.section', $section)
            ->whereIn('bloqueos.bloqueado', $Reactivos->pluck('clave')->toArray())
            ->select('bloqueos.*')
            ->get();

       
        // Se obtienen todas las respuestas de opción múltiple para la encuesta y sección actual.
        // Esto reemplaza las búsquedas específicas para 'nar3a' y 'nfr23'.
        $multiple_option_answers = multiple_option_answer::where('encuesta_id', $Encuesta->registro)
            ->whereIn('reactivo', $Reactivos->pluck('clave'))
            ->get();
        
        $multiple_option_reactivos = $Reactivos->where('type', 'multiple_option')->pluck('clave');
        
        $multiple_options = Option::whereIn('reactivo', $multiple_option_reactivos)->get();
 
        
        
        
        $Comentario = null;
        if ($section == 'G') {
            $Comentario = Comentario::where("cuenta", $Egresado->cuenta)->first();
            $Comentario = $Comentario ? $Comentario->comentario : '';
        }

        return view('encuesta.seccion_generica', compact(
            'Encuesta',
            'Egresado',
            'Carrera',
            'Plantel',
            'Reactivos',
            'Telefonos',
            'Correos',
            'Bloqueos',
            'section',
            'Comentario',
            'multiple_option_answers', 
            'multiple_options' 
        ));
    }


    public function update(Request $request, $id, $section)
    {
        // 1. Obtener los datos de la encuesta y el egresado
        $Encuesta = respuestas20::where("registro", $id)->first();
        $Egresado = Egresado::where("cuenta", $Encuesta->cuenta)
            ->where("carrera", $Encuesta->nbr2)
            ->first();

        // 2. Asignar datos básicos
        $Encuesta->aplica = Auth::user()->clave;
        $Encuesta->fec_capt = now()->modify("-6 hours");

        // 3. Lógica para manejar el botón "Terminar Encuesta"
        if ($request->btn_pressed === 'terminar') {
            $this->validar($Encuesta, $Egresado);
            return back();
        }

        // 4. Actualizar la tabla de respuestas 20
        $Encuesta->update($request->except(['_token', 'btn_pressed', 'comentario', 'btnradio', 'section']));


        // 5. Manejar respuestas de opción múltiple

        $reativos_multiples = Reactivo::where('type', 'multiple_option')
        ->where('section', $section)
        ->get();

    foreach ($reativos_multiples as $r) {
        $clave = $r->clave;

        // Buscar todas las opciones seleccionadas de este reactivo
        $selected_options = Arr::where(
            $request->except(['_token', '_method', 'btn_pressed', 'btnradio', 'section', 'comentario']),
            function ($value, $key) use ($clave) {
                return str_contains($key, $clave . 'opcion');
            }
        );

        // Borrar respuestas anteriores
        $affectedRows = multiple_option_answer::where('encuesta_id',$Encuesta->registro)
            ->where('reactivo', $clave)->delete();

        // Guardar nuevas respuestas seleccionadas
        foreach($selected_options as $key => $value){
            if (str_starts_with($key, $clave . 'opcion')) {
            // Extraer solo el número de la opción
            $clave_opcion = str_replace($clave . 'opcion', '', $key); 

            // Validar que sea un entero válido
                if (!empty($clave_opcion) && ctype_digit($clave_opcion)) {
                    $answer = new multiple_option_answer();
                    $answer->encuesta_id = $Encuesta->registro;
                    $answer->reactivo = $clave;
                    $answer->clave_opcion = (int) $clave_opcion;
                    $answer->save();
                }
            }
        }
    }


   
    
        // 7. Lógica específica para guardar el comentario de la sección G
        if ($section === 'G') {
            $Comentario = Comentario::firstOrNew(['cuenta' => $Egresado->cuenta]);
            $Comentario->comentario = $request->input('comentario', '');
            $Comentario->save();
        }

        // 8. Validar la sección y actualizar el flag
        $section_field = "sec_" . strtolower($section);
        if ($this->validar_seccion($Encuesta, $section)) {
            $Encuesta->$section_field = 1;
        } else {
            $Encuesta->$section_field = 0;
        }
        $Encuesta->save();

        $this->validar($Encuesta, $Egresado);

        // 9. Redirigir a la siguiente sección
        $next_section = $this->obtener_siguiente_seccion($section);
    
        return redirect()->route('edit_22', [
            'id' => $Encuesta->registro,
            'section' => $next_section
        ])->with('status', 'guardado');
    }

    


    
    public function validar($Encuesta, $Egresado)
    {

        if ($Encuesta->sec_a == 1 &&
            $Encuesta->sec_c == 1 &&
            $Encuesta->sec_d == 1 &&
            $Encuesta->sec_e == 1 &&
            $Encuesta->sec_f == 1 &&
            $Encuesta->sec_g == 1
            ) {
            $Encuesta->completed = 1;
            $Egresado->status = 1;
            // Generar el archivo JSON
            $fileName = $Encuesta->cuenta . ".json";
            $fileStorePath = public_path("storage/json/" . $fileName);
            File::put($fileStorePath, json_encode($Encuesta));

            $Encuesta->save();
            $Egresado->save();

            Session::put('status', 'completa');
            return true;
        } else {
            $Encuesta->completed = 0;
            $Egresado->status = 10;
            $Encuesta->save();
            $Egresado->save();
            
            Session::put('status', 'incompleta');
            return false;
        }
    }

     // Método para validar que la sección actual esté completa
    public function validar_seccion($Encuesta, $section)
    {
        $Reactivos = Reactivo::where('section', $section)->get();
        $Bloqueos = DB::table('bloqueos')
            ->join('reactivos', 'reactivos.clave', 'bloqueos.clave_reactivo')
            ->where('reactivos.section', $section)
            ->select('bloqueos.*')
            ->get();
        
        foreach ($Reactivos->sortBy('orden')->where('type', '!=', 'label')->where('type', '!=', 'multiple_option') as $reactivo) {
            $bloqueado = false;
            $field_presenter = $reactivo->clave;

            if (empty($Encuesta->$field_presenter)) {
                $ThisBloqueos = $Bloqueos->where('bloqueado', $field_presenter);
                if ($ThisBloqueos->count() > 0) {
                    foreach ($ThisBloqueos->unique('clave_reactivo')->pluck('clave_reactivo') as $r_block) {
                        $OpcionesBloquen = $ThisBloqueos->where('clave_reactivo', $r_block)->pluck('valor');
                        if (in_array($Encuesta->$r_block, $OpcionesBloquen->toArray())) {
                            $bloqueado = true;
                            break;
                        }
                    }
                }
                if (!$bloqueado) {
                    Session::put('falta', $field_presenter);
                    return false;
                }
            }
        }
        return true;
    }
    
    // Método para obtener la siguiente sección en el orden
    public function obtener_siguiente_seccion($current_section)
    {
        $secciones = ["A", "E", "F", "C", "D", "G"];
        $current_index = array_search($current_section, $secciones);
        if ($current_index !== false && isset($secciones[$current_index + 1])) {
            return $secciones[$current_index + 1];
        }
        return $current_section;
    }

    public function respaldar($registro)
    {
        $Encuesta = respuestas20::where("registro", $registro)->first();
        $Encuesta_respaldo = $Encuesta->replicate();
        $Encuesta_respaldo->setTable("respuestas20_resp");
        $Encuesta_respaldo->save();
    }

    public function terminar($id)
    {
        $Encuesta = respuestas20::where("registro", $id)->first();
        $this->respaldar($Encuesta->registro);
        if ($Encuesta->completed == 1) {
            $fileName = $Encuesta->cuenta . ".json";
            $fileStorePath = public_path("storage/json/" . $fileName);

            File::put($fileStorePath, json_encode($Encuesta));

            return view("encuesta.saved", compact("Encuesta"));
        } else {
            return redirect()->route("muestras22.index", $Encuesta->nbr3);
        }
    }



    
}