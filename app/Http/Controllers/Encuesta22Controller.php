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
       
        //  dd('hasta aki');
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
            $Encuesta->gen_dgae =  $Egresado->anio_egreso;
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

        /*
        $Bloqueos = DB::table('bloqueos')
            ->join('reactivos', 'bloqueos.clave_reactivo', 'reactivos.clave')
            // ->where('reactivos.section', $section)
            ->whereIn('bloqueos.bloqueado', $Reactivos->pluck('clave')->toArray())
            ->select('bloqueos.*')
            ->get();
        */

        $ReactivoClaves = $Reactivos->pluck('clave');

        // Obtenemos TODOS los bloqueos que son disparados por *cualquier* reactivo de la sección actual.
        // Esto es lo que necesita el JavaScript para la lógica dinámica de bloqueo/desbloqueo.
        $BloqueosSeccion = Bloqueo::whereIn('clave_reactivo', $ReactivoClaves)->get();







        //Cambios s controlador


        //Modificacion 1

        $AllBloqueos = Bloqueo::all();
        $AllAnswers = $Encuesta->toArray();

        $BloqueosActivos = collect();
        foreach ($AllBloqueos as $bloqueo) {
            $reactivoBloqueante = Reactivo::where('clave', $bloqueo->clave_reactivo)->first();
            if($reactivoBloqueante==null){dd($reactivoBloqueante,$bloqueo);}
            if($reactivoBloqueante->section != $section){
                if ($reactivoBloqueante && $reactivoBloqueante->type == 'multiple_option'){
                    $answer = multiple_option_answer::where('encuesta_id', $Encuesta->registro)
                                                    ->where('reactivo', $bloqueo->clave_reactivo)
                                                    ->where('clave_opcion', $bloqueo->valor)
                                                    ->first();
                    if ($answer) {
                        $BloqueosActivos->push($bloqueo);
                    }
                } else {
                    if (isset($AllAnswers[$bloqueo->clave_reactivo]) && $AllAnswers[$bloqueo->clave_reactivo] == $bloqueo->valor) {
                        $BloqueosActivos->push($bloqueo);
                    }
                }
            }
            
        }


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
        $next_section = $this->obtener_siguiente_seccion($section);
        $Spoiler=Reactivo::where('section',$next_section)->orderBy('orden', 'asc')->paginate(5);
       
        return view('encuesta.seccion_generica', compact(
            'Encuesta',
            'Egresado',
            'Carrera',
            'Plantel',
            'Reactivos',
            'Telefonos',
            'Correos',
            'BloqueosActivos',
            'BloqueosSeccion',
            'section',
            'Comentario',
            'multiple_option_answers', 
            'multiple_options','Spoiler'
        ));
        
    }


    public function update(Request $request, $id, $section)
    {
        // dd($request->all());
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
            //TODO-future : AGREGAR LLAVE FORANEA A COMENTARIOS, MODEL AND ID 
            $Comentario = Comentario::firstOrNew(['cuenta' => $Egresado->cuenta]);
            $Comentario->comentario = $request->input('comentario', '');
            $Comentario->save();
        }

        // 8. Validar la sección y actualizar el flag
        $section_field = "sec_" . strtolower($section);
        if ($this->validar_seccion($Encuesta, $section,$request)) {
            $Encuesta->$section_field = 1;
        } else {
            $Encuesta->$section_field = 0;
            return back()->with('error', 'true');
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
     /*
    public function validar_seccion($Encuesta, $section,$request)
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
             //para cada reactivo verifica, si esta vacio que 
             // exista entonces un bloqueo que avale la falta de ese valor
            if (empty($Encuesta->$field_presenter)) {
                //esta vacio, entonces busca los bloqueos
                $ThisBloqueos = $Bloqueos->where('bloqueado', $field_presenter);
                if ($ThisBloqueos->count() > 0) {
                    foreach ($ThisBloqueos->unique('clave_reactivo')->pluck('clave_reactivo') as $r_block) {
                        
                        $reacivo_bloqueo=$Reactivos->where('clave',$r_block)->first(); 
                        $OpcionesBloquen = $ThisBloqueos->where('clave_reactivo', $r_block)->pluck('valor');
                        // para cada reactivo que podria bloquearlo,verifica si esta alguna de las opciones que bloquean el reactivo
                        if (in_array($Encuesta->$r_block, $OpcionesBloquen->toArray())) {
                            $bloqueado = true;
                        }
                        //hay que verificar tambien las respuestas de opcion multiple que bloquean
                        if($reacivo_bloqueo->type=='multiple_option'){
                            $clave = $reacivo_bloqueo->clave;
                            // buscar las opciones seleccionadas
                             $selected_options = Arr::where(
                                    $request->except(['_token', '_method', 'btn_pressed', 'btnradio', 'section', 'comentario']),
                                    function ($value, $key) use ($clave) {
                                        return str_contains($key, $clave . 'opcion');
                                    }
                                );
                            $interseccion = array_intersect($selected_options, $OpcionesBloquen->toArray());
                                // dd($request->all(),$reactivo,$selected_options,$interseccion);
                             if (!empty($interseccion)) {
                                $bloqueado = true;
                                }
                            
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
        */



    public function validar_seccion($Encuesta, $section, $request)
    {
        //Cargamos los datos de Reactivos y Bloqueos
        $AllReactivos = Reactivo::all();
        $AllBloqueos = Bloqueo::all();

        //Cargamos todas las respuestas multiples d ela encuensta 
        $AllMultipleAnswers = multiple_option_answer::where('encuesta_id', $Encuesta->registro)->get();

        //PreProcessmiento de respuestas multiples
        $reativos_multiples_seccion_actual = $AllReactivos->where('section', $section)->where('type', 'multiple_option');

        //primer bucle
        $ReactivosAValidar = $AllReactivos->where('section', $section)
                                      ->whereNotIn('type', ['label', 'multiple_option'])
                                      ->sortBy('orden');
        
        foreach ($ReactivosAValidar as $reactivo) {
            $bloqueado = false;
            $field_presenter = $reactivo->clave;
        
            if (empty($Encuesta->$field_presenter)) {
                $ThisBloqueos = $AllBloqueos->where('bloqueado', $field_presenter);

                if ($ThisBloqueos->count() > 0) {
                    foreach ($ThisBloqueos as $bloqueo) {
                        $clave_reactivo_bloqueante = $bloqueo->clave_reactivo;
                        $valor_bloqueante = $bloqueo->valor;

                        $reactivoBloqueante = $AllReactivos->where('clave', $clave_reactivo_bloqueante)->first();
                    
                        if ($reactivoBloqueante) {
                            if ($reactivoBloqueante->type == 'multiple_option') {
                                
                                $answer = $AllMultipleAnswers->where('reactivo', $clave_reactivo_bloqueante)
                                                             ->where('clave_opcion', $valor_bloqueante)
                                                             ->first();

                                if ($answer) {
                                    $bloqueado = true;
                                    break;
                                }
                            } else {
                                if ($Encuesta->$clave_reactivo_bloqueante == $valor_bloqueante) {
                                $bloqueado = true;
                                break;
                                }
                            }
                        }
                    }
                }

                if (!$bloqueado) {
                    Session::put('falta', $field_presenter);
                    return false; // El campo está vacío y no está bloqueado
                }
            }   
        }

        //Segundo bucle para validar los reactivos de opcion multiple
        foreach ($reativos_multiples_seccion_actual as $reactivo) {
            $clave = $reactivo->clave;

            
            $selected_options = $AllMultipleAnswers->where('reactivo', $clave);
                                                
            if ($selected_options->isEmpty()) {
                $bloqueado = false;
                $ThisBloqueos = $AllBloqueos->where('bloqueado', $clave);
            
                if ($ThisBloqueos->count() > 0) {
                    foreach ($ThisBloqueos as $bloqueo) {
                        $clave_reactivo_bloqueante = $bloqueo->clave_reactivo;
                        $valor_bloqueante = $bloqueo->valor;

                        $reactivoBloqueante = $AllReactivos->where('clave', $clave_reactivo_bloqueante)->first();

                        if ($reactivoBloqueante) {
                            if ($reactivoBloqueante->type == 'multiple_option') {
                                
                                $answer = $AllMultipleAnswers->where('reactivo', $clave_reactivo_bloqueante)
                                                            ->where('clave_opcion', $valor_bloqueante)
                                                            ->first();
                                if ($answer) {
                                    $bloqueado = true;
                                    break;
                                }
                            } else {
                                if ($Encuesta->$clave_reactivo_bloqueante == $valor_bloqueante) {
                                    $bloqueado = true;
                                    break;
                                }
                            }
                        }
                    }
                }

                if (!$bloqueado) {
                    Session::put('falta', $clave);
                    return false; // La pregunta múltiple está vacía y no está bloqueada
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

    public function terminar22($id)
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