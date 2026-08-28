<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Egresado;
use App\Models\Correo;
use App\Mail\testingMail;
use Illuminate\Support\Facades\Mail;

class SendMailController extends Controller
{
    public function test($id){
        $Egresado=Egresado::find($id);
        $Correos=Correo::where('cuenta',$Egresado->cuenta)->get();
        foreach($Correos as $correo){
          
            Mail::to($correo->correo)->send(new testingMail($Egresado->nombre.' '.$Egresado->paterno, $Egresado->cuenta));

        }
        return 'Correo enviado'.$Correos->pluck('correo');
    }
}
