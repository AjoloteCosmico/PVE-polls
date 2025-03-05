<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Egresado;
use App\Models\Carrera;
use App\Models\Correo;
use App\Models\Telefono;
use App\Models\respuestas16;
use App\Models\Reactivo;
use App\Models\Bloqueo;
use App\Models\Option;
use Session;
use DB;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
class Enc16ActController extends Controller
{

    public function comenzar($correo, $cuenta, $carrera)
    {
        $Correo = Correo::find($correo);
        $Egresado = Egresado::where("cuenta", $cuenta)
            ->where("carrera", $carrera)
            ->first();
        // if ($Correo->enviado == 0) {
        //     $caminoalpoder = public_path();
        //     $process = new Process([
        //         env("PY_COMAND"),
        //         $caminoalpoder . "/aviso.py",
        //         $Egresado->nombre,
        //         $Correo->correo,
        //     ]);
        //     $process->run();
        //     if (!$process->isSuccessful()) {
        //         throw new ProcessFailedException($process);
        //         $Correo->enviado = 2;
        //         $Correo->save();
        //     } else {
        //         $Correo->enviado = 1;
        //         $Correo->save();
        //     }
        //     $data = $process->getOutput();
        // }
        $Encuesta = respuestas16::where("cuenta", "=", $cuenta)
            ->where("nbr2", "=", $carrera)
            ->first();
        if (!$Encuesta) {
            $Encuesta = new respuestas16();
            $Encuesta->cuenta = $cuenta;
            $Encuesta->nombre = $Egresado->nombre;
            $Encuesta->paterno = $Egresado->paterno;
            $Encuesta->materno = $Egresado->materno;
            $Encuesta->nombre = $Egresado->nombre;
            $Encuesta->nombre = $Egresado->nombre;
            $Encuesta->nbr2 = $carrera;
            $Encuesta->nbr3 = $Egresado->plantel;
            $Encuesta->completed = 0;
            $Encuesta->save();
        }
        
        return redirect()->route('edit_16',$Encuesta->registro);
    }
    public function edit($id){
        $Encuesta=respuestas16::find($id);
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
        $Telefonos = Telefono::where("cuenta", $Egresado->cuenta)->get();
        $Correos = Correo::where("cuenta", $Egresado->cuenta)->get();
        
        $Reactivos=Reactivo::where('rules','act')->get();
        $Opciones=Option::where('clave','like','%p%r')->get();
        $Bloqueos=DB::table('bloqueos')->join('reactivos','reactivos.clave','bloqueos.clave_reactivo')
        ->where('reactivos.rules','act')
        ->select('bloqueos.*')
        ->get();

        $Secciones=array(
            array('letter'=>'A',
                  'desc'=>'Datos socioeconomicos',
                  'number'=>'1'),
            array('letter'=>'E',
                  'desc'=>'Actualización Académica',
                  'number'=>'2'),
            array('letter'=>'F',
                  'desc'=>'Titulación',
                  'number'=>'3'),            
            array('letter'=>'C',
                  'desc'=>'Datos laborales',
                  'number'=>'4'),
            array('letter'=>'D',
                'desc'=>'Incorporacion laboral',
                'number'=>'5'),
            array('letter'=>'G',
                'desc'=>'Habilidades',
                'number'=>'6'),
        );
        return view('encuesta.show_16',compact('Encuesta','Egresado',
                                                'Carrera','Plantel',
                                                'Correos','Telefonos',
                                                'Reactivos','Opciones','Bloqueos',
                                                 'Secciones'));
    }
   
   
    
    public function update(Request $request,$id){
        // if($request->ncr19==null){
        //     dd('ncr19 es null');
        // }
        // dd($request);
        $rules=[
            "nar8"=>"required",
            "nar9"=>"required",
        ] ;
        $Encuesta = respuestas16::find($id);
        $Egresado = Egresado::where("cuenta", $Encuesta->cuenta)
            ->where("carrera", $Encuesta->nbr2)
            ->first();
        $Encuesta->aplica = Auth::user()->clave;
        $Encuesta->fec_capt = now()->modify("-6 hours");
        // $request->validate($rules);
        $Encuesta->update($request->except(["_token", "_method"]));
        // $Encuesta->completed=1;
        $Encuesta->save();
        return redirect()->route('muestras16.show',[$Encuesta->nbr2,$Encuesta->nbr3])->with('encuesta','ok');
        //TODO: swal fire "Encuesta completada :D"
    }

    public function  inicio(){

           return view('encuesta.act16.inicio');
    }
}