<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Egresado;
use App\Models\Carrera;
use App\Models\Correo;
use App\Models\Telefono;
use App\Models\respuestas20;
use DB;
use App\Models\historico_encuestas;
use App\Models\Comentario;
use Illuminate\Support\Facades\Auth;
use File;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class Encuesta20Controller extends Controller
{
    public function act_data($cuenta, $carrera, $muestra,$telefono_id)
    {
        $TelefonoEnLlamada=Telefono::find($telefono_id);
        $Egresado = Egresado::where("cuenta", $cuenta)
            ->where("carrera", $carrera)
            ->first();
        $Telefonos = DB::table("telefonos")
            ->where("cuenta", "=", $cuenta)
            ->leftJoin("codigos", "codigos.code", "=", "telefonos.status")
            ->get();
        $Correos = Correo::where("cuenta", "=", $cuenta)
            ->Join("codigos", "codigos.code", "=", "correos.status")
            ->get();
        $Carrera = Carrera::where(
            "clave_carrera",
            "=",
            $Egresado->carrera
        )->first()->carrera;
        $Plantel = Carrera::where(
            "clave_plantel",
            "=",
            $Egresado->plantel
        )->first()->plantel;
        //dd($Egresado);
        return view(
            "encuesta.seg20.actualizar_datos",
            compact(
                "TelefonoEnLlamada",
                "Egresado",
                "Telefonos",
                "Correos",
                "Carrera",
                "Plantel",
                "muestra"
            )
        );
    }

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
            return redirect(
                "/encuestas_2020/edit/" . $Encuesta->registro . "/A"
            );
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
            $Encuesta->gen_dgae = 2020;
            $Encuesta->completed = 0;
            $Encuesta->save();
            return redirect(
                "/encuestas_2020/edit/" . $Encuesta->registro . "/A"
            );
        }
    }

    public function edit($id, $section)
    {
        $Encuesta = respuestas20::where("registro", "=", $id)->first();
        $Empresa = DB::table("empresas")
            ->where("registro","=",$Encuesta->registro)
            ->first();
        $Egresado = Egresado::where("cuenta", $Encuesta->cuenta)
            ->where("carrera", $Encuesta->nbr2)
            ->first();
        $Carrera = Carrera::where(
            "clave_carrera",
            "=",
            $Egresado->carrera
        )->first()->carrera;
        $Plantel = Carrera::where(
            "clave_plantel",
            "=",
            $Egresado->plantel
        )->first()->plantel;
        $Comentario =
            "" . Comentario::where("cuenta", "=", $Encuesta->cuenta)->first();
        $Telefonos = Telefono::where("cuenta", $Egresado->cuenta)->get();
        $Correos = Correo::where("cuenta", $Egresado->cuenta)->get();

        $Coment = Comentario::where("cuenta", "=", $Encuesta->cuenta)->first();

        if ($Coment) {
            $Comentario = $Coment->comentario;
        } else {
            $Comentario = "";
        }
        $Discriminacion = DB::table("multiple_option_answers")
            ->where("encuesta_id", "=", $Encuesta->registro)
            ->where("reactivo", "nfr23")
            ->get();
        $nfr23_options = DB::table("options")
            ->where("reactivo", "=", "nfr23")
            ->get();
        $Becas = DB::table("multiple_option_answers")
            ->where("encuesta_id", "=", $Encuesta->registro)
            ->where("reactivo", "nar3a")
            ->get();
        $Becas_options = DB::table("options")
            ->where("reactivo", "=", "nar3a")
            ->get();

        // dd($Comentario);
        if ($section == "SEARCH") {
            foreach (["A", "E", "F", "C", "D", "G"] as $sec) {
                $format_field = "sec_" . strtolower($sec);

                if ($Encuesta->$format_field != 1) {
                    $section = $sec;
                    break;
                }
            }
        }
        if ($section == "SEARCH") {
            $section = "A";
        }
        //dd(compact('Empresa'));
        return view(
            "encuesta.seccion" . $section,
            compact(
                "Encuesta",
                "Egresado",
                "Carrera",
                "Plantel",
                "Comentario",
                "Telefonos",
                "Correos",
                "nfr23_options",
                "Discriminacion",
                "Becas",
                "Becas_options",
                "Empresa"
            )
        );
    }

    function validar_completa($registro)
    {
        $encuesta = respuestas20::where("registro", "=", $registro)->first();
        $Egresado = Egresado::where("cuenta", $encuesta->cuenta)
            ->where("carrera", $encuesta->nbr2)
            ->first();

        if (
            $encuesta->sec_a == 1 &&
            $encuesta->sec_a == 1 &&
            $encuesta->sec_c == 1 &&
            $encuesta->sec_d == 1 &&
            $encuesta->sec_e == 1 &&
            $encuesta->sec_f == 1 &&
            $encuesta->sec_g == 1
        ) {
            $encuesta->completed = 1;
            $Egresado->status = 1; //i.e encuestado via telefonica
        } else {
            $encuesta->completed = 0;
            $Egresado->status = 10; //encuesta inconclusa
        }
        $encuesta->save();
        $Egresado->save();
    }
    public function updateA(Request $request, $id)
    {
        $Encuesta = respuestas20::where("registro", $id)->first();
        $Egresado = Egresado::where("cuenta", $Encuesta->cuenta)
            ->where("carrera", $Encuesta->nbr2)
            ->first();
        $Encuesta->aplica = Auth::user()->clave;
        $Encuesta->update($request->except(["_token", "_method"]));
        $Encuesta->sec_a = 0;
        $this->validar_completa($Encuesta->registro);
        $Encuesta->save();
        $Becas = DB::table("multiple_option_answers")
            ->where("encuesta_id", "=", $Encuesta->registro)
            ->get();
        $Becas_options = DB::table("options")
            ->where("reactivo", "=", "nar3a")
            ->get();
        DB::table("multiple_option_answers")
            ->where("encuesta_id", $Encuesta->registro)
            ->where("reactivo", "nar3a")
            ->delete();
        foreach ($Becas_options as $o) {
            $field_presenter = "opcion" . $o->clave;
            if ($request->$field_presenter) {
                $arr = [
                    "encuesta_id" => $Encuesta->registro,
                    "clave_opcion" => $o->clave,
                    "reactivo" => "nar3a",
                ];
                DB::table("multiple_option_answers")->insert($arr);
            }
        }

        $rules = [
            "fec_capt" => "required",
            "nar8" => "required",
            "nar9" => "required",
            "nar10" => "required",
            "nar11" => "required",
            "nar11a" => "required",
            "nar14" => "required",
            "nar14otra" => "required",
            "nar12" => "required",
            "nar12otra" => "required",
            "nrx" => "required",
            "nar15" => "required",
            "nar15otra" => "required",
            "nar13" => "required",
            "nar13otra" => "required",
            "nrxx" => "required",
            "nar16" => "required",
            "nar16otra" => "required",
            "nbr1" => "required",
            "ner20" => "required",
            "ner20txt" => "required",
            "ner20a" => "required",
            "nar1" => "required",
            "nar2a" => "required",
            "nar4a" => "required",
            "nar5a" => "required",
        ];

        if ($Egresado->sexo == "M") {
            $nar7 = 2;
        } else {
            $nar7 = 1;
        }
        $Encuesta_respaldo = $Encuesta->replicate();
        $Encuesta_respaldo->setTable("respuestas20_resp");
        $Encuesta_respaldo->save();
        $Encuesta->nar7 = $nar7;
        $Encuesta->aplica = Auth::user()->clave;
        $Encuesta->update($request->except(["_token", "_method", "btnradio"]));
        $Encuesta->save();
        $Encuesta->sec_a = 0;
        $this->validar_completa($Encuesta->registro);
        $validated = $request->validate($rules);
        $Encuesta->sec_a = 1;
        $Encuesta->save();
        $this->validar_completa($Encuesta->registro);

        return redirect()->route("edit_20", [$Encuesta->registro, "E"]);
    }

    public function updateE(Request $request, $id)
    {
        $Encuesta = respuestas20::where("registro", $id)->first();
        $Encuesta->aplica = Auth::user()->clave;
        $Encuesta->update($request->except(["_token", "_method"]));
        $Encuesta->sec_e = 0;
        $this->validar_completa($Encuesta->registro);
        $Encuesta->save();
        $rules = [
            "ner1" => "required",
            "ner2" => "required",
            "ner1a" => "required",
            "ner3" => "required",
            "ner4" => "required",
            "ner5" => "required",
            "ner6" => "required",
            "ner7" => "required",
            "ner7int" => "required",
            "ner8" => "required",
            "ner9" => "required",
            "ner10" => "required",
            "ner10a" => "required",
            "ner11" => "required",
            "ner12" => "required",
            "ner13" => "required",
            "ner14" => "required",
            "ner15" => "required",
            "ner12a" => "required",
            "ner12b" => "required",
            "ner16" => "required",
            "ner17" => "required",
            "ner18" => "required",
            "ner19" => "required",
        ];
        $validated = $request->validate($rules);
        $Encuesta->sec_e = 1;
        $Encuesta->save();
        $this->validar_completa($Encuesta->registro);
        return redirect()->route("edit_20", [$Encuesta->registro, "F"]);
    }

    //guardar seccion F
    public function updateF(Request $request, $id)
    {
        $Encuesta = respuestas20::where("registro", $id)->first();
        $Encuesta->aplica = Auth::user()->clave;
        $Encuesta->update($request->except(["_token", "_method"]));
        $Encuesta->sec_f = 0;
        $this->validar_completa($Encuesta->registro);
        $Encuesta->save();
        $Discriminacion = DB::table("multiple_option_answers")
            ->where("encuesta_id", "=", $Encuesta->registro)
            ->get();
        $nfr23_options = DB::table("options")
            ->where("reactivo", "=", "nfr23")
            ->get();
        DB::table("multiple_option_answers")
            ->where("encuesta_id", $Encuesta->registro)
            ->where("reactivo", "nfr23")
            ->delete();
        foreach ($nfr23_options as $o) {
            $field_presenter = "opcion" . $o->clave;
            if ($request->$field_presenter) {
                $arr = [
                    "encuesta_id" => $Encuesta->registro,
                    "clave_opcion" => $o->clave,
                    "reactivo" => "nfr23",
                ];
                DB::table("multiple_option_answers")->insert($arr);
            }
        }
        $rules = [
            "nfr0" => "required",
            "nfr1" => "required",
            "nfr2" => "required",
            "nfr3" => "required",
            "nfr5" => "required",
            "nfr5_a" => "required",
            "nfr6" => "required",
            "nfr6_a" => "required",
            "nfr7" => "required",
            "nfr8" => "required",
            "nfr9" => "required",
            "nfr10" => "required",
            "nfr11" => "required",
            "nfr11a" => "required",
            "nfr12" => "required",
            "nfr13" => "required",
            "nfr22" => "required",
            "nfr23a" => "required",
            "nfr25" => "required",
            "nfr26" => "required",
            "nfr27" => "required",
            "nfr28" => "required",
            "nfr29" => "required",
            "nfr29a" => "required",
            "nfr30" => "required",
            "nfr31" => "required",
            "nfr32" => "required",
            "nfr33" => "required",
        ];
        $validated = $request->validate($rules);
        $Encuesta->sec_f = 1;
        $Encuesta->save();
        $this->validar_completa($Encuesta->registro);
        return redirect()->route("edit_20", [$Encuesta->registro, "C"]);
    }
    //guardar seccion C
    public function updateC(Request $request, $id)
    {
        $Encuesta = respuestas20::where("registro", $id)->first();
        $Encuesta->aplica = Auth::user()->clave;
        $Encuesta->update($request->except(["_token", "_method","giro","giro_especifico"]));
        $existe_empresa = DB::table("empresas")->where("registro","=",$Encuesta->registro)->first();
        $empresaData['nombre']= $request->ncr2;
        $empresaData['clave_giro']=$request->ncr4;
        $empresaData['giro_especifico'] = $request->giro_especifico;
        $empresaData['sector'] = $request->ncr3;
        if( $existe_empresa  == null){
            $empresaData['usuario'] = Auth::user()->clave;
            $empresaData['registro'] = $Encuesta->registro;
            DB::table("empresas")
                ->insert($empresaData);
        }else{
            DB::table("empresas")
                ->where('registro', $Encuesta->registro)
                ->update($empresaData);
        }
        if ($request->ncr6 == 1) {
            $Encuesta->ncr6 = $request->ncr6t;
        }
        $Encuesta->sec_c = 0;
        
        $this->validar_completa($Encuesta->registro);
        $Encuesta->save();
        $rules = [
            "ncr1" => "required",
            "ncr2" => "required",
            "ncr2a" => "required",
            "ncr3" => "required",
            "ncr4" => "required",
            "ncr4a" => "required",
            "ncr5" => "required",
            "ncr6" => "required",
            "ncr6t" => "required",
            "ncr6_a" => "required",
            "ncr7_a" => "required",
            "ncr7b" => "required",
            "ncr8" => "required",
            "ncr9" => "required",
            "ncr10" => "required",
            "ncr11" => "required",
            "ncr12_a" => "required",
            "ncr15" => "required",
            "ncr16" => "required",
            "ncr17" => "required",
            "ncr18" => "required",
            "ncr19" => "required",
            "ncr20" => "required",
            "ncr21" => "required",
            "ncr22" => "required",
            "ncr24" => "required",
            "ncr24a" => "required",
            "ncr24porque" => "required",
            "ncr23" => "required",
        ];
        
        $validated = $request->validate($rules);
        $Encuesta->sec_c = 1;
        $Encuesta->save();
        $this->validar_completa($Encuesta->registro);
        return redirect()->route("edit_20", [$Encuesta->registro, "D"]);
    }
    //guardar seccion D
    public function updateD(Request $request, $id)
    {
        $Encuesta = respuestas20::where("registro", $id)->first();
        $Encuesta->aplica = Auth::user()->clave;
        $Encuesta->update($request->except(["_token", "_method"]));
        $Encuesta->sec_d = 0;
        $this->validar_completa($Encuesta->registro);
        $Encuesta->save();
        $rules = [
            "ndr1" => "required",
            "ndr2" => "required",

            "ndr2_a" => "required",
            "ndr3" => "required",
            "ndr8" => "required",
            "ndr4" => "required",
            "ndr9" => "required",
            "ndr5" => "required",
            "ndr10" => "required",
            "ndr6" => "required",
            "ndr11" => "required",
            "ndr7" => "required",
            "ndr12" => "required",
            "ndr12a" => "required",
            "ndr12b" => "required",
            "ndr12c" => "required",
            "ndr15" => "required",
            "ndr16" => "required",
            "ndr17" => "required",
            "ndr18" => "required",
            "ndr19" => "required",
        ];
        $validated = $request->validate($rules);
        $Encuesta->sec_d = 1;
        $Encuesta->save();
        $this->validar_completa($Encuesta->registro);
        return redirect()->route("edit_20", [$Encuesta->registro, "G"]);
    }
    //guardar ultima seccion (G)
    public function updateG(Request $request, $id)
    {
        $Encuesta = respuestas20::where("registro", $id)->first();
        $Encuesta->aplica = Auth::user()->clave;
        $Encuesta->update($request->except(["_token", "_method"]));
        $Encuesta->sec_g = 0;
        $this->validar_completa($Encuesta->registro);
        $Encuesta->save();
        $rules = [
            "ngr4" => "required",
            "ngr5" => "required",
            "ngr6" => "required",
            "ngr6a" => "required",
            "ngr7a" => "required",
            "ngr6b" => "required",
            "ngr7b" => "required",
            "ngr6c" => "required",
            "ngr7c" => "required",
            "ngr6d" => "required",
            "ngr7d" => "required",
            "ngr6e" => "required",
            "ngr7e" => "required",
            "ngr6f" => "required",
            "ngr7f" => "required",
            "ngr6g" => "required",
            "ngr7g" => "required",
            "ngr8" => "required",
            "ngr9a" => "required",
            "ngr9b" => "required",
            "ngr9c" => "required",
            "ngr9d" => "required",
            "ngr13" => "required",
            "ngr13b" => "required",
            "ngr13c" => "required",
            "ngr13d" => "required",
            "ngr11a" => "required",
            "ngr11f" => "required",
            "ngr11" => "required",
            "ngr11b" => "required",
            "ngr11c" => "required",
            "ngr11d" => "required",
            "ngr14" => "required",
            "ngr15" => "required",
            "ngr16" => "required",
            "ngr17" => "required",
            "ngr18" => "required",
            "ngr19" => "required",
            "ngr20" => "required",
            "ngr21" => "required",
            "ngr22" => "required",
            "ngr23" => "required",
            "ngr24" => "required",
            "ngr25" => "required",
            "ngr26" => "required",
            "ngr27" => "required",
            "ngr28" => "required",
            "ngr29" => "required",
            "ngr30" => "required",
            "ngr31" => "required",
            "ngr32" => "required",
            "ngr33" => "required",
            "ngr34" => "required",
            "ngr35" => "required",
            "ngr36" => "required",
            "ngr37" => "required",
            "ngr37_a" => "required",
            "ngr37m" => "required",
            "ngr40" => "required",
            "ngr40_a" => "required",
            "ngr40a" => "required",
            "ngr40_b" => "required",
            "ngr45" => "required",
            "ngr45_a" => "required",
            "ngr45otra" => "required",
            "conoce" => "required",
            "cue_cre" => "required",
            "utiliza" => "required",
        ];
        $validated = $request->validate($rules);
        $Encuesta->sec_g = 1;
        $Encuesta->save();

        $comentario = comentario::where("cuenta", $Encuesta->cuenta)->first();
        if ($comentario) {
            $comentario->comentario = $request->comentario;
            $comentario->save();
        } else {
            $comentario = new comentario();
            $comentario->cuenta = $Encuesta->cuenta;
            $comentario->comentario = $request->comentario;
            $comentario->save();
        }

        $this->validar_completa($Encuesta->registro);
        return redirect()->route("edit_20", [$Encuesta->registro, "G"]);
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
            return redirect()->route("muestras20.index", $Encuesta->nbr3);
        }
    }

    public function update2(Request $request, $id)
    {
        $Encuesta = respuestas20::where("registro", $id)->first();
        $Encuesta_respaldo = $Encuesta->replicate();
        $Encuesta_respaldo->setTable("respuestas20_resp");
        $Encuesta_respaldo->save();
        $fileName = time() . $Encuesta->cuenta . ".json";
        $fileStorePath = public_path("storage/" . $fileName);
        File::put($fileStorePath, json_encode($request->all()));

        $Encuesta->aplica = Auth::user()->clave;
        if ($request->fec_capt == "2023-01-01") {
            $Encuesta->fec_capt = now()->modify("-6 hours");
        } else {
            $Encuesta->fec_capt = $request->fec_capt;
        }

        $Encuesta->telcasa = $request->telcasa;
        $Encuesta->TELCEL = $request->TELCEL;
        $Encuesta->teltra = $request->teltra;
        $Encuesta->exttra = $request->exttra;

        if (strlen(strval($request->telcasa)) > 0) {
            $Encuesta->telcasa = $request->telcasa;
        }
        if (strlen(strval($request->TELCEL)) > 0) {
            $Encuesta->TELCEL = $request->TELCEL;
        }
        if (strlen(strval($request->teltra)) > 0) {
            $Encuesta->teltra = $request->teltra;
        }
        if (strlen(strval($request->exttra)) > 0) {
            $Encuesta->exttra = $request->exttra;
        }
        if (strlen(strval($request->dianac)) > 0) {
            $Encuesta->dianac = $request->dianac;
        }
        if (strlen(strval($request->mesnac)) > 0) {
            $Encuesta->mesnac = $request->mesnac;
        }
        if (strlen(strval($request->yernac)) > 0) {
            $Encuesta->yernac = $request->yernac;
        }
        if (strlen(strval($request->nar1)) > 0) {
            $Encuesta->nar1 = $request->nar1;
        }
        if (strlen(strval($request->nar1_a)) > 0) {
            $Encuesta->nar1_a = $request->nar1_a;
        }
        if (strlen(strval($request->nar2a)) > 0) {
            $Encuesta->nar2a = $request->nar2a;
        }
        if (strlen(strval($request->nar3a)) > 0) {
            $Encuesta->nar3a = $request->nar3a;
        }
        if (strlen(strval($request->nar4a)) > 0) {
            $Encuesta->nar4a = $request->nar4a;
        }
        if (strlen(strval($request->nar5a)) > 0) {
            $Encuesta->nar5a = $request->nar5a;
        }
        if (strlen(strval($request->nar7)) > 0) {
            $Encuesta->nar7 = $request->nar7;
        }
        if (strlen(strval($request->nar8)) > 0) {
            $Encuesta->nar8 = $request->nar8;
        }
        if (strlen(strval($request->nar9)) > 0) {
            $Encuesta->nar9 = $request->nar9;
        }
        if (strlen(strval($request->nar10)) > 0) {
            $Encuesta->nar10 = $request->nar10;
        }
        if (strlen(strval($request->nar11)) > 0) {
            $Encuesta->nar11 = $request->nar11;
        }
        if (strlen(strval($request->nar11a)) > 0) {
            $Encuesta->nar11a = $request->nar11a;
        }
        if (strlen(strval($request->nar12)) > 0) {
            $Encuesta->nar12 = $request->nar12;
        }
        if (strlen(strval($request->nar12a)) > 0) {
            $Encuesta->nar12a = $request->nar12a;
        }
        if (strlen(strval($request->nar13)) > 0) {
            $Encuesta->nar13 = $request->nar13;
        }
        if (strlen(strval($request->nar13a)) > 0) {
            $Encuesta->nar13a = $request->nar13a;
        }
        if (strlen(strval($request->nar14)) > 0) {
            $Encuesta->nar14 = $request->nar14;
        }
        if (strlen(strval($request->nar14otra)) > 0) {
            $Encuesta->nar14otra = $request->nar14otra;
        }
        if (strlen(strval($request->nar15)) > 0) {
            $Encuesta->nar15 = $request->nar15;
        }
        if (strlen(strval($request->nar15otra)) > 0) {
            $Encuesta->nar15otra = $request->nar15otra;
        }
        if (strlen(strval($request->nar16)) > 0) {
            $Encuesta->nar16 = $request->nar16;
        }
        if (strlen(strval($request->nar16otra)) > 0) {
            $Encuesta->nar16otra = $request->nar16otra;
        }
        if (strlen(strval($request->nbr1)) > 0) {
            $Encuesta->nbr1 = $request->nbr1;
        }
        if (strlen(strval($request->nbr2)) > 0) {
            $Encuesta->nbr2 = $request->nbr2;
        }
        if (strlen(strval($request->nbr3)) > 0) {
            $Encuesta->nbr3 = $request->nbr3;
        }
        if (strlen(strval($request->nbr3_a)) > 0) {
            $Encuesta->nbr3_a = $request->nbr3_a;
        }
        if (strlen(strval($request->nbr6)) > 0) {
            $Encuesta->nbr6 = $request->nbr6;
        }
        if (strlen(strval($request->nbr7)) > 0) {
            $Encuesta->nbr7 = $request->nbr7;
        }
        if (strlen(strval($request->nbr8)) > 0) {
            $Encuesta->nbr8 = $request->nbr8;
        }
        if (strlen(strval($request->ncr1)) > 0) {
            $Encuesta->ncr1 = $request->ncr1;
        }
        if (strlen(strval($request->ncr2)) > 0) {
            $Encuesta->ncr2 = $request->ncr2;
        }
        if (strlen(strval($request->ncr2a)) > 0) {
            $Encuesta->ncr2a = $request->ncr2a;
        }
        if (strlen(strval($request->ncr3)) > 0) {
            $Encuesta->ncr3 = $request->ncr3;
        }
        if (strlen(strval($request->ncr4)) > 0) {
            $Encuesta->ncr4 = $request->ncr4;
        }
        if (strlen(strval($request->ncr4otra)) > 0) {
            $Encuesta->ncr4otra = $request->ncr4otra;
        }
        if (strlen(strval($request->ncr5)) > 0) {
            $Encuesta->ncr5 = $request->ncr5;
        }
        if (strlen(strval($request->ncr6)) > 0) {
            $Encuesta->ncr6 = $request->ncr6;
        } else {
            if (strval($request->ncr6t) > 0) {
                $Encuesta->ncr6 = $request->ncr6t;
            }
        }
        if (strlen(strval($request->ncr6_a)) > 0) {
            $Encuesta->ncr6_a = $request->ncr6_a;
        }
        if (strlen(strval($request->ncr7_a)) > 0) {
            $Encuesta->ncr7_a = $request->ncr7_a;
        }
        if (strlen(strval($request->ncr7b)) > 0) {
            $Encuesta->ncr7b = $request->ncr7b;
        }
        if (strlen(strval($request->ncr8)) > 0) {
            $Encuesta->ncr8 = $request->ncr8;
        }
        if (strlen(strval($request->ncr9)) > 0) {
            $Encuesta->ncr9 = $request->ncr9;
        }
        if (strlen(strval($request->ncr10)) > 0) {
            $Encuesta->ncr10 = $request->ncr10;
        }
        if (strlen(strval($request->ncr11)) > 0) {
            $Encuesta->ncr11 = $request->ncr11;
        }
        if (strlen(strval($request->ncr12_a)) > 0) {
            $Encuesta->ncr12_a = $request->ncr12_a;
        }
        if (strlen(strval($request->ncr15)) > 0) {
            $Encuesta->ncr15 = $request->ncr15;
        }
        if (strlen(strval($request->ncr16)) > 0) {
            $Encuesta->ncr16 = $request->ncr16;
        }
        if (strlen(strval($request->ncr17)) > 0) {
            $Encuesta->ncr17 = $request->ncr17;
        }
        if (strlen(strval($request->ncr18)) > 0) {
            $Encuesta->ncr18 = $request->ncr18;
        }
        if (strlen(strval($request->ncr19)) > 0) {
            $Encuesta->ncr19 = $request->ncr19;
        }
        if (strlen(strval($request->ncr20)) > 0) {
            $Encuesta->ncr20 = $request->ncr20;
        }
        if (strlen(strval($request->ncr21)) > 0) {
            $Encuesta->ncr21 = $request->ncr21;
        }
        if (strlen(strval($request->ncr21_a)) > 0) {
            $Encuesta->ncr21_a = $request->ncr21_a;
        }
        if (strlen(strval($request->ncr21b)) > 0) {
            $Encuesta->ncr21b = $request->ncr21b;
        }
        if (strlen(strval($request->ncr22)) > 0) {
            $Encuesta->ncr22 = $request->ncr22;
        }
        if (strlen(strval($request->ncr23)) > 0) {
            $Encuesta->ncr23 = $request->ncr23;
        }
        if (strlen(strval($request->ncr24)) > 0) {
            $Encuesta->ncr24 = $request->ncr24;
        }
        if (strlen(strval($request->ncr24porque)) > 0) {
            $Encuesta->ncr24porque = $request->ncr24porque;
        }
        if (strlen(strval($request->ncr24_a)) > 0) {
            $Encuesta->ncr24_a = $request->ncr24_a;
        }
        if (strlen(strval($request->ndr1)) > 0) {
            $Encuesta->ndr1 = $request->ndr1;
        }
        if (strlen(strval($request->ndr2)) > 0) {
            $Encuesta->ndr2 = $request->ndr2;
        }
        if (strlen(strval($request->ndr2_a)) > 0) {
            $Encuesta->ndr2_a = $request->ndr2_a;
        }
        if (strlen(strval($request->ndr3)) > 0) {
            $Encuesta->ndr3 = $request->ndr3;
        }
        if (strlen(strval($request->ndr4)) > 0) {
            $Encuesta->ndr4 = $request->ndr4;
        }
        if (strlen(strval($request->ndr5)) > 0) {
            $Encuesta->ndr5 = $request->ndr5;
        }
        if (strlen(strval($request->ndr6)) > 0) {
            $Encuesta->ndr6 = $request->ndr6;
        }
        if (strlen(strval($request->ndr9)) > 0) {
            $Encuesta->ndr9 = $request->ndr9;
        }
        if (strlen(strval($request->ndr7)) > 0) {
            $Encuesta->ndr7 = $request->ndr7;
        }
        if (strlen(strval($request->ndr8)) > 0) {
            $Encuesta->ndr8 = $request->ndr8;
        }
        if (strlen(strval($request->ndr10)) > 0) {
            $Encuesta->ndr10 = $request->ndr10;
        }
        if (strlen(strval($request->ndr11)) > 0) {
            $Encuesta->ndr11 = $request->ndr11;
        }
        if (strlen(strval($request->ndr12)) > 0) {
            $Encuesta->ndr12 = $request->ndr12;
        }
        if (strlen(strval($request->ndr12a)) > 0) {
            $Encuesta->ndr12a = $request->ndr12a;
        }
        if (strlen(strval($request->ndr12b)) > 0) {
            $Encuesta->ndr12b = $request->ndr12b;
        }
        if (strlen(strval($request->ndr12c)) > 0) {
            $Encuesta->ndr12c = $request->ndr12c;
        }
        if (strlen(strval($request->ndr13a)) > 0) {
            $Encuesta->ndr13a = $request->ndr13a;
        }
        if (strlen(strval($request->ndr14)) > 0) {
            $Encuesta->ndr14 = $request->ndr14;
        }
        if (strlen(strval($request->ndr15)) > 0) {
            $Encuesta->ndr15 = $request->ndr15;
        }
        if (strlen(strval($request->ndr16)) > 0) {
            $Encuesta->ndr16 = $request->ndr16;
        }
        if (strlen(strval($request->ndr17)) > 0) {
            $Encuesta->ndr17 = $request->ndr17;
        }
        if (strlen(strval($request->ndr18)) > 0) {
            $Encuesta->ndr18 = $request->ndr18;
        }
        if (strlen(strval($request->ndr19)) > 0) {
            $Encuesta->ndr19 = $request->ndr19;
        }
        if (strlen(strval($request->ner1)) > 0) {
            $Encuesta->ner1 = $request->ner1;
        }
        if (strlen(strval($request->NER1A)) > 0) {
            $Encuesta->NER1A = $request->NER1A;
        }
        if (strlen(strval($request->ner2)) > 0) {
            $Encuesta->ner2 = $request->ner2;
        }
        if (strlen(strval($request->ner3)) > 0) {
            $Encuesta->ner3 = $request->ner3;
        }
        if (strlen(strval($request->ner4)) > 0) {
            $Encuesta->ner4 = $request->ner4;
        }
        if (strlen(strval($request->ner5)) > 0) {
            $Encuesta->ner5 = $request->ner5;
        }
        if (strlen(strval($request->ner6)) > 0) {
            $Encuesta->ner6 = $request->ner6;
        }
        if (strlen(strval($request->ner7)) > 0) {
            $Encuesta->ner7 = $request->ner7;
        }
        if (strlen(strval($request->ner7_a)) > 0) {
            $Encuesta->ner7_a = $request->ner7_a;
        }
        if (strlen(strval($request->ner7int)) > 0) {
            $Encuesta->ner7int = $request->ner7int;
        }
        if (strlen(strval($request->ner8)) > 0) {
            $Encuesta->ner8 = $request->ner8;
        }
        if (strlen(strval($request->ner9)) > 0) {
            $Encuesta->ner9 = $request->ner9;
        }
        if (strlen(strval($request->ner10)) > 0) {
            $Encuesta->ner10 = $request->ner10;
        }
        if (strlen(strval($request->ner10a)) > 0) {
            $Encuesta->ner10a = $request->ner10a;
        }
        if (strlen(strval($request->ner11)) > 0) {
            $Encuesta->ner11 = $request->ner11;
        }
        if (strlen(strval($request->ner12)) > 0) {
            $Encuesta->ner12 = $request->ner12;
        }
        if (strlen(strval($request->ner12a)) > 0) {
            $Encuesta->ner12a = $request->ner12a;
        }
        if (strlen(strval($request->ner12b)) > 0) {
            $Encuesta->ner12b = $request->ner12b;
        }
        if (strlen(strval($request->ner13)) > 0) {
            $Encuesta->ner13 = $request->ner13;
        }
        if (strlen(strval($request->ner14)) > 0) {
            $Encuesta->ner14 = $request->ner14;
        }
        if (strlen(strval($request->ner15)) > 0) {
            $Encuesta->ner15 = $request->ner15;
        }
        if (strlen(strval($request->ner16)) > 0) {
            $Encuesta->ner16 = $request->ner16;
        }
        if (strlen(strval($request->ner17)) > 0) {
            $Encuesta->ner17 = $request->ner17;
        }
        if (strlen(strval($request->ner18)) > 0) {
            $Encuesta->ner18 = $request->ner18;
        }
        if (strlen(strval($request->ner19)) > 0) {
            $Encuesta->ner19 = $request->ner19;
        }
        if (strlen(strval($request->ner19a)) > 0) {
            $Encuesta->ner19a = $request->ner19a;
        }
        if (strlen(strval($request->ner20)) > 0) {
            $Encuesta->ner20 = $request->ner20;
        }
        if (strlen(strval($request->ner20txt)) > 0) {
            $Encuesta->ner20txt = $request->ner20txt;
        }
        if (strlen(strval($request->ner20a)) > 0) {
            $Encuesta->ner20a = $request->ner20a;
        }
        if (strlen(strval($request->nfr0)) > 0) {
            $Encuesta->nfr0 = $request->nfr0;
        }
        if (strlen(strval($request->nfr1)) > 0) {
            $Encuesta->nfr1 = $request->nfr1;
        }
        if (strlen(strval($request->nfr1a)) > 0) {
            $Encuesta->nfr1a = $request->nfr1a;
        }
        if (strlen(strval($request->nfr2)) > 0) {
            $Encuesta->nfr2 = $request->nfr2;
        }
        if (strlen(strval($request->nfr3)) > 0) {
            $Encuesta->nfr3 = $request->nfr3;
        }
        if (strlen(strval($request->nfr7)) > 0) {
            $Encuesta->nfr7 = $request->nfr7;
        }
        if (strlen(strval($request->nfr4)) > 0) {
            $Encuesta->nfr4 = $request->nfr4;
        }
        if (strlen(strval($request->nfr4_a)) > 0) {
            $Encuesta->nfr4_a = $request->nfr4_a;
        }
        if (strlen(strval($request->nfr5)) > 0) {
            $Encuesta->nfr5 = $request->nfr5;
        }
        if (strlen(strval($request->nfr5_a)) > 0) {
            $Encuesta->nfr5_a = $request->nfr5_a;
        }
        if (strlen(strval($request->nfr6)) > 0) {
            $Encuesta->nfr6 = $request->nfr6;
        }
        if (strlen(strval($request->nfr6_a)) > 0) {
            $Encuesta->nfr6_a = $request->nfr6_a;
        }
        if (strlen(strval($request->nfr8)) > 0) {
            $Encuesta->nfr8 = $request->nfr8;
        }
        if (strlen(strval($request->nfr9)) > 0) {
            $Encuesta->nfr9 = $request->nfr9;
        }
        if (strlen(strval($request->nfr10)) > 0) {
            $Encuesta->nfr10 = $request->nfr10;
        }
        if (strlen(strval($request->nfr11)) > 0) {
            $Encuesta->nfr11 = $request->nfr11;
        }
        if (strlen(strval($request->nfr11a)) > 0) {
            $Encuesta->nfr11a = $request->nfr11a;
        }
        if (strlen(strval($request->nfr12)) > 0) {
            $Encuesta->nfr12 = $request->nfr12;
        }
        if (strlen(strval($request->nfr13)) > 0) {
            $Encuesta->nfr13 = $request->nfr13;
        }
        if (strlen(strval($request->nfr22)) > 0) {
            $Encuesta->nfr22 = $request->nfr22;
        }
        if (strlen(strval($request->nfr23)) > 0) {
            $Encuesta->nfr23 = $request->nfr23;
        }
        if (strlen(strval($request->nfr24)) > 0) {
            $Encuesta->nfr24 = $request->nfr24;
        }
        if (strlen(strval($request->nfr25)) > 0) {
            $Encuesta->nfr25 = $request->nfr25;
        }
        if (strlen(strval($request->nfr26)) > 0) {
            $Encuesta->nfr26 = $request->nfr26;
        }
        if (strlen(strval($request->nfr27)) > 0) {
            $Encuesta->nfr27 = $request->nfr27;
        }
        if (strlen(strval($request->nfr28)) > 0) {
            $Encuesta->nfr28 = $request->nfr28;
        }
        if (strlen(strval($request->nfr29)) > 0) {
            $Encuesta->nfr29 = $request->nfr29;
        }
        if (strlen(strval($request->nfr29a)) > 0) {
            $Encuesta->nfr29a = $request->nfr29a;
        }
        if (strlen(strval($request->nfr30)) > 0) {
            $Encuesta->nfr30 = $request->nfr30;
        }
        if (strlen(strval($request->nfr31)) > 0) {
            $Encuesta->nfr31 = $request->nfr31;
        }
        if (strlen(strval($request->nfr32)) > 0) {
            $Encuesta->nfr32 = $request->nfr32;
        }
        if (strlen(strval($request->nfr33)) > 0) {
            $Encuesta->nfr33 = $request->nfr33;
        }
        if (strlen(strval($request->ngr1)) > 0) {
            $Encuesta->ngr1 = $request->ngr1;
        }
        if (strlen(strval($request->ngr2)) > 0) {
            $Encuesta->ngr2 = $request->ngr2;
        }
        if (strlen(strval($request->ngr3)) > 0) {
            $Encuesta->ngr3 = $request->ngr3;
        }
        if (strlen(strval($request->ngr3b)) > 0) {
            $Encuesta->ngr3b = $request->ngr3b;
        }
        if (strlen(strval($request->ngr3c)) > 0) {
            $Encuesta->ngr3c = $request->ngr3c;
        }
        if (strlen(strval($request->ngr3d)) > 0) {
            $Encuesta->ngr3d = $request->ngr3d;
        }
        if (strlen(strval($request->ngr3e)) > 0) {
            $Encuesta->ngr3e = $request->ngr3e;
        }
        if (strlen(strval($request->ngr4)) > 0) {
            $Encuesta->ngr4 = $request->ngr4;
        }
        if (strlen(strval($request->ngr5)) > 0) {
            $Encuesta->ngr5 = $request->ngr5;
        }
        if (strlen(strval($request->ngr6)) > 0) {
            $Encuesta->ngr6 = $request->ngr6;
        }
        if (strlen(strval($request->ngr6a)) > 0) {
            $Encuesta->ngr6a = $request->ngr6a;
        }
        if (strlen(strval($request->ngr6b)) > 0) {
            $Encuesta->ngr6b = $request->ngr6b;
        }
        if (strlen(strval($request->ngr6c)) > 0) {
            $Encuesta->ngr6c = $request->ngr6c;
        }
        if (strlen(strval($request->ngr6d)) > 0) {
            $Encuesta->ngr6d = $request->ngr6d;
        }
        if (strlen(strval($request->ngr6e)) > 0) {
            $Encuesta->ngr6e = $request->ngr6e;
        }
        if (strlen(strval($request->ngr6f)) > 0) {
            $Encuesta->ngr6f = $request->ngr6f;
        }
        if (strlen(strval($request->ngr6g)) > 0) {
            $Encuesta->ngr6g = $request->ngr6g;
        }
        if (strlen(strval($request->ngr6_t)) > 0) {
            $Encuesta->ngr6_t = $request->ngr6_t;
        }
        if (strlen(strval($request->ngr7a)) > 0) {
            $Encuesta->ngr7a = $request->ngr7a;
        }
        if (strlen(strval($request->ngr7b)) > 0) {
            $Encuesta->ngr7b = $request->ngr7b;
        }
        if (strlen(strval($request->ngr7c)) > 0) {
            $Encuesta->ngr7c = $request->ngr7c;
        }
        if (strlen(strval($request->ngr7d)) > 0) {
            $Encuesta->ngr7d = $request->ngr7d;
        }
        if (strlen(strval($request->ngr7e)) > 0) {
            $Encuesta->ngr7e = $request->ngr7e;
        }
        if (strlen(strval($request->ngr7f)) > 0) {
            $Encuesta->ngr7f = $request->ngr7f;
        }
        if (strlen(strval($request->ngr7g)) > 0) {
            $Encuesta->ngr7g = $request->ngr7g;
        }
        if (strlen(strval($request->ngr8)) > 0) {
            $Encuesta->ngr8 = $request->ngr8;
        }
        if (strlen(strval($request->ngr9a)) > 0) {
            $Encuesta->ngr9a = $request->ngr9a;
        }
        if (strlen(strval($request->ngr9b)) > 0) {
            $Encuesta->ngr9b = $request->ngr9b;
        }
        if (strlen(strval($request->ngr9c)) > 0) {
            $Encuesta->ngr9c = $request->ngr9c;
        }
        if (strlen(strval($request->ngr9d)) > 0) {
            $Encuesta->ngr9d = $request->ngr9d;
        }
        if (strlen(strval($request->ngr9e)) > 0) {
            $Encuesta->ngr9e = $request->ngr9e;
        }
        if (strlen(strval($request->ngr11a)) > 0) {
            $Encuesta->ngr11a = $request->ngr11a;
        }
        if (strlen(strval($request->ngr11)) > 0) {
            $Encuesta->ngr11 = $request->ngr11;
        }
        if (strlen(strval($request->ngr11_a)) > 0) {
            $Encuesta->ngr11_a = $request->ngr11_a;
        }
        if (strlen(strval($request->ngr13)) > 0) {
            $Encuesta->ngr13 = $request->ngr13;
        }
        if (strlen(strval($request->ngr13b)) > 0) {
            $Encuesta->ngr13b = $request->ngr13b;
        }
        if (strlen(strval($request->ngr13c)) > 0) {
            $Encuesta->ngr13c = $request->ngr13c;
        }
        if (strlen(strval($request->ngr13d)) > 0) {
            $Encuesta->ngr13d = $request->ngr13d;
        }
        if (strlen(strval($request->ngr13e)) > 0) {
            $Encuesta->ngr13e = $request->ngr13e;
        }
        if (strlen(strval($request->ngr14)) > 0) {
            $Encuesta->ngr14 = $request->ngr14;
        }
        if (strlen(strval($request->ngr15)) > 0) {
            $Encuesta->ngr15 = $request->ngr15;
        }
        if (strlen(strval($request->ngr16)) > 0) {
            $Encuesta->ngr16 = $request->ngr16;
        }
        if (strlen(strval($request->ngr17)) > 0) {
            $Encuesta->ngr17 = $request->ngr17;
        }
        if (strlen(strval($request->ngr18)) > 0) {
            $Encuesta->ngr18 = $request->ngr18;
        }
        if (strlen(strval($request->ngr19)) > 0) {
            $Encuesta->ngr19 = $request->ngr19;
        }
        if (strlen(strval($request->ngr20)) > 0) {
            $Encuesta->ngr20 = $request->ngr20;
        }
        if (strlen(strval($request->ngr21)) > 0) {
            $Encuesta->ngr21 = $request->ngr21;
        }
        if (strlen(strval($request->ngr22)) > 0) {
            $Encuesta->ngr22 = $request->ngr22;
        }
        if (strlen(strval($request->ngr23)) > 0) {
            $Encuesta->ngr23 = $request->ngr23;
        }
        if (strlen(strval($request->ngr24)) > 0) {
            $Encuesta->ngr24 = $request->ngr24;
        }
        if (strlen(strval($request->ngr25)) > 0) {
            $Encuesta->ngr25 = $request->ngr25;
        }
        if (strlen(strval($request->ngr26)) > 0) {
            $Encuesta->ngr26 = $request->ngr26;
        }
        if (strlen(strval($request->ngr27)) > 0) {
            $Encuesta->ngr27 = $request->ngr27;
        }
        if (strlen(strval($request->ngr28)) > 0) {
            $Encuesta->ngr28 = $request->ngr28;
        }
        if (strlen(strval($request->ngr29)) > 0) {
            $Encuesta->ngr29 = $request->ngr29;
        }
        if (strlen(strval($request->ngr30)) > 0) {
            $Encuesta->ngr30 = $request->ngr30;
        }
        if (strlen(strval($request->ngr31)) > 0) {
            $Encuesta->ngr31 = $request->ngr31;
        }
        if (strlen(strval($request->ngr32)) > 0) {
            $Encuesta->ngr32 = $request->ngr32;
        }
        if (strlen(strval($request->ngr33)) > 0) {
            $Encuesta->ngr33 = $request->ngr33;
        }
        if (strlen(strval($request->ngr34)) > 0) {
            $Encuesta->ngr34 = $request->ngr34;
        }
        if (strlen(strval($request->ngr35)) > 0) {
            $Encuesta->ngr35 = $request->ngr35;
        }
        if (strlen(strval($request->ngr36)) > 0) {
            $Encuesta->ngr36 = $request->ngr36;
        }
        if (strlen(strval($request->ngr37)) > 0) {
            $Encuesta->ngr37 = $request->ngr37;
        }
        if (strlen(strval($request->ngr37m)) > 0) {
            $Encuesta->ngr37m = $request->ngr37m;
        }
        if (strlen(strval($request->ngr37_a)) > 0) {
            $Encuesta->ngr37_a = $request->ngr37_a;
        }
        if (strlen(strval($request->ngr38)) > 0) {
            $Encuesta->ngr38 = $request->ngr38;
        }
        if (strlen(strval($request->ngr39)) > 0) {
            $Encuesta->ngr39 = $request->ngr39;
        }
        if (strlen(strval($request->ngr40)) > 0) {
            $Encuesta->ngr40 = $request->ngr40;
        }
        if (strlen(strval($request->ngr40a)) > 0) {
            $Encuesta->ngr40a = $request->ngr40a;
        }
        if (strlen(strval($request->ngr40_a)) > 0) {
            $Encuesta->ngr40_a = $request->ngr40_a;
        }
        if (strlen(strval($request->ngr40_b)) > 0) {
            $Encuesta->ngr40_b = $request->ngr40_b;
        }

        if (strlen(strval($request->ngr45)) > 0) {
            $Encuesta->ngr45 = $request->ngr45;
        }
        if (strlen(strval($request->ngr45_a)) > 0) {
            $Encuesta->ngr45_a = $request->ngr45_a;
        }
        if (strlen(strval($request->ngr45otra)) > 0) {
            $Encuesta->ngr45otra = $request->ngr45otra;
        }
        if (strlen(strval($request->conoce)) > 0) {
            $Encuesta->conoce = $request->conoce;
        }
        if (strlen(strval($request->cue_cre)) > 0) {
            $Encuesta->cue_cre = $request->cue_cre;
        }
        if (strlen(strval($request->utiliza)) > 0) {
            $Encuesta->utiliza = $request->utiliza;
        }
        if (strlen(strval($request->nrx)) > 0) {
            $Encuesta->nrx = $request->nrx;
        }
        if (strlen(strval($request->nrxx)) > 0) {
            $Encuesta->nrxx = $request->nrxx;
        }
        if (strlen(strval($request->ngr11b)) > 0) {
            $Encuesta->ngr11b = $request->ngr11b;
        }
        if (strlen(strval($request->ngr11c)) > 0) {
            $Encuesta->ngr11c = $request->ngr11c;
        }
        if (strlen(strval($request->ngr11d)) > 0) {
            $Encuesta->ngr11d = $request->ngr11d;
        }
        if (strlen(strval($request->ngr11e)) > 0) {
            $Encuesta->ngr11e = $request->ngr11e;
        }
        if (strlen(strval($request->ngr11f)) > 0) {
            $Encuesta->ngr11f = $request->ngr11f;
        }

        $Encuesta->save();
        //marcar egresado como ya encuestado
        $Egresado = Egresado::where("cuenta", $Encuesta->cuenta)
            ->where("carrera", $Encuesta->nbr2)
            ->first();
        $Egresado->status = 1; //i.e encuestado via telefonica
        $Egresado->save();

        $fileName = $Encuesta->cuenta . ".json";
        $fileStorePath = public_path("storage/json/" . $fileName);

        File::put($fileStorePath, json_encode($request->all()));
        $comentario = comentario::where("cuenta", $Encuesta->cuenta)->first();
        if ($comentario) {
            $comentario->comentario = $request->comentario;
            $comentario->save();
        } else {
            $comentario = new comentario();
            $comentario->cuenta = $Encuesta->cuenta;
            $comentario->comentario = $request->comentario;
            $comentario->save();
        }

        // $r3=respuestas3::where('cuenta',$Encuesta->cuenta)->first;
        // $r3->APLICA='TELEFONICA';
        // $r3->save();
        return view("encuesta.saved", compact("Encuesta"));
    }

    public function json($id)
    {
        $fileName = $id . ".json";
        $fileStorePath = public_path("storage/json/" . $fileName);
        return response()->download($fileStorePath);
    }
}
