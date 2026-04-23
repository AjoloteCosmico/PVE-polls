<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bloqueo;
use App\Models\Carrera;
use App\Models\Correo;
use App\Models\EgresadoEspecialidad;
use App\Models\Telefono;
use App\Models\respuestasEspecialidad;
use App\Models\Reactivo;
use App\Models\Option;
use App\Models\multiple_option_answer;
use DB;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use App\Models\Comentario;
use Illuminate\Support\Facades\Auth;
use File;
use Session;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class EspecialidadController extends Controller
{
    
     public function comenzar($correo, $cuenta, $plan)
    {
        $Correo = Correo::find($correo);
        $Egresado = EgresadoEspecialidad::where("cuenta", $cuenta)
            ->where("especialidad", $plan)
            ->first();

        // if ($Correo->enviado == 0) {
        //     $caminoalpoder = public_path();
        //     $process = new Process([
        //         env("PY_COMAND"),
        //         $caminoalpoder . "/aviso.py",
        //         $Egresado->nombre,
        //         $Correo->correo,
        //     ]);
        //      $process->run();

        //     if (!$process->isSuccessful()) {
        //         //TODO-future: return swal alert,
        //         $Correo->enviado = 2;
        //         $Correo->save();
        //         throw new ProcessFailedException($process);
                
        //     } else {
        //         $Correo->enviado = 1;
        //         $Correo->save();
        //     }
        //     $data = $process->getOutput();
        // }
       
        $Encuesta = respuestasEspecialidad::where("cuenta", "=", $cuenta)
            ->first();

        if ($Encuesta) {
            return redirect()->route('especialidad.show', [
                'section' => 'SEARCH',
                'id' => $Encuesta->registro
                
            ]);
        } else {
            $Encuesta = new respuestasEspecialidad();
            $Encuesta->cuenta = $cuenta;
            $Encuesta->nombre = $Egresado->nombre;
            $Encuesta->paterno = $Egresado->paterno;
            $Encuesta->materno = $Egresado->materno;
            $Encuesta->especialidad = $Egresado->especialidad;
            $Encuesta->anio_egreso =  $Egresado->anio_egreso;
            $Encuesta->completed = 0;
            $Encuesta->save();
            return redirect()->route('especialidad.show', [
                'section' => 'espA',
                'id' => $Encuesta->registro,                
            ]);
        }
    }

     public function obtener_siguiente_seccion($current_section)
    {
        $secciones = ["espA","espF", "espE" ,"espC", "espG"];
        $current_index = array_search($current_section, $secciones);
        if ($current_index !== false && isset($secciones[$current_index + 1])) {
            return $secciones[$current_index + 1];
        }
        return $current_section;
    }
public function show($section, $id)
{
    // ── Carga base ──────────────────────────────────────────────────────────
    $Encuesta = respuestasEspecialidad::findOrFail($id);
    $Egresado = EgresadoEspecialidad::where('cuenta', $Encuesta->cuenta)->firstOrFail();

    Session::put('especialidad', $Egresado->especialidad);

    // ── Sección activa ───────────────────────────────────────────────────────
    if ($section === "SEARCH") {
        $section = "espA"; // default
        foreach (["espA", "espB", "espC", "espD"] as $sec) {
            if ($Encuesta->{"sec_" . strtolower($sec)} != 1) {
                $section = $sec;
                break;
            }
        }
    }

    // ── Reactivos de la sección ──────────────────────────────────────────────
    $Reactivos = Reactivo::where('section', $section)->get();
    foreach ($Reactivos as $reactivo) {
        if ($reactivo->act_description) {
            $reactivo->description = $reactivo->act_description;
        }
    }
    $ReactivoClaves = $Reactivos->pluck('clave');

    // ── Opciones y teléfonos/correos ─────────────────────────────────────────
    $cuenta       = $Egresado->cuenta;
    $Telefonos    = Telefono::where('cuenta', $cuenta)->get();
    $Correos      = Correo::where('cuenta', $cuenta)->get();
    $Opciones     = Option::where('clave', 'like', '%p%r')->get();

    // ── Múltiple opción ──────────────────────────────────────────────────────
    $multiple_option_reactivos = $Reactivos->where('type', 'multiple_option')->pluck('clave');
    $multiple_options          = Option::whereIn('reactivo', $multiple_option_reactivos)->get();
    $multiple_option_answers   = multiple_option_answer::where('encuesta_id', $Encuesta->registro)
                                    ->whereIn('reactivo', $ReactivoClaves)
                                    ->get();

    // ── Bloqueos — UNA sola query, sin N+1 ──────────────────────────────────
    // Traemos todos los bloqueos de una vez y los indexamos en memoria
    $AllBloqueos     = Bloqueo::all();
    $BloqueosSeccion = $AllBloqueos->whereIn('clave_reactivo', $ReactivoClaves->toArray());
    $Bloqueos        = $AllBloqueos->where('clave_reactivo', 'LIKE', 'p%'); // filtro en colección

    // Pre-cargamos reactivos bloqueantes en un mapa clave→reactivo (evita N+1)
    $clavesReactivosBloqueantes = $AllBloqueos->pluck('clave_reactivo')->unique();
    $reactivosBloqueantesMap    = Reactivo::whereIn('clave', $clavesReactivosBloqueantes)
                                    ->get()
                                    ->keyBy('clave'); // ['p1' => Reactivo, ...]

    // Pre-cargamos respuestas múltiples que interesan para bloqueos externos
    $clavesMultiple = $clavesReactivosBloqueantes->filter(function ($clave) use ($reactivosBloqueantesMap) {
        return isset($reactivosBloqueantesMap[$clave]) &&
               $reactivosBloqueantesMap[$clave]->type === 'multiple_option';
    });

    $answersMultipleMap = multiple_option_answer::where('encuesta_id', $Encuesta->registro)
                            ->whereIn('reactivo', $clavesMultiple)
                            ->get()
                            ->groupBy('reactivo'); // ['nar3a' => Collection, ...]

    $AllAnswers     = $Encuesta->toArray();
    $BloqueosActivos = collect();

    foreach ($AllBloqueos as $bloqueo) {
        $reactivoBloqueante = $reactivosBloqueantesMap[$bloqueo->clave_reactivo] ?? null;
        if (!$reactivoBloqueante) continue;
        if ($reactivoBloqueante->section === $section) continue;

        if ($reactivoBloqueante->type === 'multiple_option') {
            $respuestasDelReactivo = $answersMultipleMap->get($bloqueo->clave_reactivo, collect());
            if ($respuestasDelReactivo->where('clave_opcion', $bloqueo->valor)->isNotEmpty()) {
                $BloqueosActivos->push($bloqueo);
            }
        } else {
            if (($AllAnswers[$bloqueo->clave_reactivo] ?? null) == $bloqueo->valor) {
                $BloqueosActivos->push($bloqueo);
            }
        }
    }

    // ── Comentario (solo espD) ───────────────────────────────────────────────
    $Comentario = null;
    if ($section === 'espD') {
        $Comentario = Comentario::where('cuenta', $Egresado->cuenta)
                        ->where('type', 'especialidad')
                        ->value('comentario') ?? '';
    }

    // ── Spoiler siguiente sección ────────────────────────────────────────────
    $next_section = $this->obtener_siguiente_seccion($section);
    $Spoiler      = Reactivo::where('section', $next_section)->orderBy('orden')->paginate(5);

    return view('especialidad.section', compact(
        'Egresado', 'Encuesta', 'Telefonos', 'Correos',
        'Reactivos', 'Opciones', 'Bloqueos', 'BloqueosActivos', 'Comentario',
        'BloqueosSeccion', 'ReactivoClaves', 'Spoiler', 'section', 'next_section',
        'multiple_option_answers', 'multiple_options'
    ));
}


    public function update(Request $request,  $section,$id)
    {
        // dd($request->all());
        // 1. Obtener los datos de la encuesta y el egresado
        $Encuesta = respuestasEspecialidad::where("registro", $id)->first();
        $Egresado = EgresadoEspecialidad::where("cuenta", $Encuesta->cuenta)
            ->first();

        // 2. Asignar datos básicos
        $Encuesta->aplica = Auth::user()->clave;
        
            
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
        if ($section === 'espD') {
            //TODO-future : AGREGAR LLAVE FORANEA A COMENTARIOS, MODEL AND ID 
            $Comentario = Comentario::firstOrNew(['cuenta' => $Egresado->cuenta,'type'=>'especialidad']);
            $Comentario->comentario = $request->input('comentario', '');
            $Comentario->save();
        }

        // 8. Validar la sección y actualizar el flag
        $section_field = "sec_" . strtolower($section);
        if ($this->validar_seccion($Encuesta, $Egresado,$section,$request)) {
            $Encuesta->$section_field = 1;
            $Encuesta->save();
        } else {
            $Encuesta->$section_field = 0;
            $Encuesta->save();
            return back()->with('error', 'true');
        }
        

        $this->validar($Encuesta, $Egresado);
        
        // 9. Redirigir a la siguiente sección
        $next_section = $this->obtener_siguiente_seccion($section);
    
        return redirect()->route('especialidad.show', [
            'section' => $next_section,
            'id' => $Encuesta->registro
        ])->with('status', 'guardado');
    }

    
    
    public function validar_seccion($Encuesta, $Egresado,$section, $request)
    {
        //Cargamos los datos de Reactivos y Bloqueos
        $AllReactivos = Reactivo::all();
        $AllBloqueos = Bloqueo::all();

        //Cargamos todas las respuestas multiples d ela encuensta 
        $AllMultipleAnswers = multiple_option_answer::where('encuesta_id', $Encuesta->registro)->get();

        //PreProcessmiento de respuestas multiples
        $reativos_multiples_seccion_actual = $AllReactivos->where('section', $section)->where('type', 'multiple_option');

        //FILTRAR REACTIVOS

        //Si No esta graduado
        if($Egresado->grado=='NO'){
            $ReactivosAValidar=Reactivo::where('section',$section)->whereNotIn('clave',['pbr1','pbr1otro','pbr2','pbr3','pbr4'])
                                        ->whereNotIn('type', ['label', 'multiple_option'])->orderBy('orden')->get();
        }else{
            //GRADUADO DE DOCTORADO
            if(str_contains($Egresado->plan, 'DOCTORADO')){
                $ReactivosAValidar=Reactivo::where('section',$section)
                                    ->whereNotIn('clave',['pbr5','pbr5otro','pbr6','pbr7'])
                                    ->whereNotIn('type', ['label', 'multiple_option'])->orderBy('orden')->get();
            //GRADUADO DE MAESTRIA
            }else{
                $ReactivosAValidar=Reactivo::where('section',$section)
                                    ->whereNotIn('clave',['pbr3','pbr4','pbr5','pbr5otro','pbr6','pbr7'])
                                    ->whereNotIn('type', ['label', 'multiple_option'])->orderBy('orden')->get();
            }
        
        }
        
        
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

   

    public function validar($Encuesta, $Egresado)
    {

        if ($Encuesta->sec_espa == 1 &&
            $Encuesta->sec_espb == 1 &&
            $Encuesta->sec_espc == 1 &&
            $Encuesta->sec_espd == 1
            ) {
                //es decir, solo se actualiza la fecha de captura cuando se completa por primera vez
                if ($Encuesta->completed != 1){
            $Encuesta->fec_capt = now()->modify("-6 hours");

                    }
            $Encuesta->completed = 1;
            
            $Egresado->status = 1;
            // Generar el archivo JSON
            $fileName = 'pos'.$Encuesta->cuenta . ".json";
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
    public function terminar($id)
    {
        $Encuesta = respuestasEspecialidad::where("registro", $id)->first();
        $Egresado = EgresadoEspecialidad::where("cuenta", $Encuesta->cuenta)
            ->first();
        // $this->respaldar($Encuesta->registro);
        if ($Encuesta->completed == 1) {
            $fileName = $Encuesta->cuenta . ".json";
            $fileStorePath = public_path("storage/json/" . $fileName);

            File::put($fileStorePath, json_encode($Encuesta));

            return view("encuesta.saved_especialidad", compact("Encuesta",'Egresado'));
        } else {
            return redirect()->route("muestrasespecialidad.show", [$Egresado->especialidad,$Encuesta->plan]);
        }
    }
}
