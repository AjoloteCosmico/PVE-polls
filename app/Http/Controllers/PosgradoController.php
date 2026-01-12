<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bloqueo;
use App\Models\Carrera;
use App\Models\Correo;
use App\Models\EgresadoPosgrado;
use App\Models\Telefono;
use App\Models\respuestasPosgrado;
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


class PosgradoController extends Controller
{
    
     public function comenzar($correo, $cuenta, $plan)
    {
        $Correo = Correo::find($correo);
        $Egresado = EgresadoPosgrado::where("cuenta", $cuenta)
            ->where("plan", $plan)
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
                //TODO-future: return swal alert,
                $Correo->enviado = 2;
                $Correo->save();
                throw new ProcessFailedException($process);
                
            } else {
                $Correo->enviado = 1;
                $Correo->save();
            }
            $data = $process->getOutput();
        }
       
        $Encuesta = respuestasPosgrado::where("cuenta", "=", $cuenta)
            ->first();

        if ($Encuesta) {
            return redirect()->route('posgrado.show', [
                'section' => 'SEARCH',
                'id' => $Encuesta->registro
                
            ]);
        } else {
            $Encuesta = new respuestasPosgrado();
            $Encuesta->cuenta = $cuenta;
            $Encuesta->nombre = $Egresado->nombre;
            $Encuesta->paterno = $Egresado->paterno;
            $Encuesta->materno = $Egresado->materno;
            $Encuesta->plan = $Egresado->plan;
            $Encuesta->anio_egreso =  $Egresado->anio_egreso;
            $Encuesta->completed = 0;
            $Encuesta->save();
            return redirect()->route('posgrado.show', [
                'section' => 'pA',
                'id' => $Encuesta->registro,                
            ]);
        }
    }

     public function obtener_siguiente_seccion($current_section)
    {
        $secciones = ["pA","pB" ,"pC", "pD","pE"];
        $current_index = array_search($current_section, $secciones);
        if ($current_index !== false && isset($secciones[$current_index + 1])) {
            return $secciones[$current_index + 1];
        }
        return $current_section;
    }

    public function show($section,$id){
        $Encuesta=respuestasPosgrado::find($id);
        $Egresado=EgresadoPosgrado::where('cuenta',$Encuesta->cuenta)->first();
        $cuenta = ltrim($Egresado->cuenta, "0"); 
        $Telefonos = Telefono::where("cuenta", $cuenta)->get();
        $Correos = Correo::where("cuenta", $cuenta)->get();
        if ($section == "SEARCH"){
            foreach (["pA", "pB", "pC", "pD", "pE"] as $sec){
                $format_field = "sec_" . strtolower($sec);
                if ($Encuesta->$format_field != 1){
                    $section = $sec;
                    break;
                }
            }
            if ($section == "SEARCH"){
                $section = "pA"; //default section
            }
        }

        $Reactivos=Reactivo::where('section',$section)->get();
          //Si No esta graduado
            if($Egresado->grado=='NO'){
                $Reactivos=Reactivo::where('section',$section)->whereNotIn('clave',['pbr1','pbr1otro','pbr2','pbr3','pbr4'])->orderBy('orden')->get();
            }else{
                //GRADUADO DE DOCTORADO
                if(str_contains($Egresado->plan, 'DOCTORADO')){
                    $Reactivos=Reactivo::where('section',$section)->whereNotIn('clave',['pbr5','pbr5otro','pbr6','pbr7'])->orderBy('orden')->get();
               //GRADUADO DE MAESTRIA
                }else{
                    $Reactivos=Reactivo::where('section',$section)->whereNotIn('clave',['pbr3','pbr4','pbr5','pbr5otro','pbr6','pbr7'])->orderBy('orden')->get();
           
                }
            
            }
        $Opciones=Option::where('clave','like','%p%r')->get();
        $Bloqueos=Bloqueo::where('clave_reactivo','like','p%')->get();
        $ReactivoClaves = $Reactivos->pluck('clave');

        // Obtenemos TODOS los bloqueos que son disparados por *cualquier* reactivo de la sección actual.
        // Esto es lo que necesita el JavaScript para la lógica dinámica de bloqueo/desbloqueo.
        $BloqueosSeccion = Bloqueo::whereIn('clave_reactivo', $ReactivoClaves)->get();

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
        $Comentario = null;
        if ($section == 'pE') {
            $Comentario = Comentario::where("cuenta", $Egresado->cuenta)->first();
            $Comentario = $Comentario ? $Comentario->comentario : '';
        }
        $next_section = $this->obtener_siguiente_seccion($section);
        $Spoiler=Reactivo::where('section',$next_section)->orderBy('orden', 'asc')->paginate(5);
       
        // dd($Bloqueos->unique('valor')->pluck('valor'));
        return view('posgrado.section', 
                    compact('Egresado', 'Encuesta',
                            'Telefonos','Correos',
                            'Reactivos','Opciones','Bloqueos','BloqueosActivos','Comentario',
                            'BloqueosSeccion','ReactivoClaves','Spoiler','section','next_section'));
    }
    
    

    public function update(Request $request,  $section,$id)
    {
        // dd($request->all());
        // 1. Obtener los datos de la encuesta y el egresado
        $Encuesta = respuestasPosgrado::where("registro", $id)->first();
        $Egresado = EgresadoPosgrado::where("cuenta", $Encuesta->cuenta)
            ->first();

        // 2. Asignar datos básicos
        $Encuesta->aplica = Auth::user()->clave;
        if ($Encuesta->completed =! 1)
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
        if ($section === 'pE') {
            //TODO-future : AGREGAR LLAVE FORANEA A COMENTARIOS, MODEL AND ID 
            $Comentario = Comentario::firstOrNew(['cuenta' => $Egresado->cuenta]);
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
    
        return redirect()->route('posgrado.show', [
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

        if ($Encuesta->sec_pa == 1 &&
            $Encuesta->sec_pb == 1 &&
            $Encuesta->sec_pc == 1 &&
            $Encuesta->sec_pd == 1 &&
            $Encuesta->sec_pe == 1 
            ) {
            $Encuesta->completed = 1;
            $Encuesta->fec_capt = now()->modify("-6 hours");
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
        $Encuesta = respuestasPosgrado::where("registro", $id)->first();
        $Egresado = EgresadoPosgrado::where("cuenta", $Encuesta->cuenta)
            ->first();
        // $this->respaldar($Encuesta->registro);
        if ($Encuesta->completed == 1) {
            $fileName = $Encuesta->cuenta . ".json";
            $fileStorePath = public_path("storage/json/" . $fileName);

            File::put($fileStorePath, json_encode($Encuesta));

            return view("encuesta.saved_posgrado", compact("Encuesta",'Egresado'));
        } else {
            return redirect()->route("muestrasposgrado.show", [$Egresado->programa,$Encuesta->plan]);
        }
    }
}
