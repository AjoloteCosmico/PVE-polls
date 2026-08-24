<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Egresado;
use App\Models\Correo;
use App\Mail\testingMail;
use App\Mail\InvMail;
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

    public function send_test() {
    $intereses = [
        ['text' => 'Trámita tu credencial de egresado', 'link' => 'https://www.pveaju.unam.mx/credencial/', 'image' => 'https://www.pveaju.unam.mx/encuesta/01/seguimiento_egresados_UNAM/img/mail_sources/credencial.png'],
        ['text' => 'Bolsa de trabajo UNAM', 'link' => 'https://but.unam.mx/siiabut/public/', 'image' => 'https://www.pveaju.unam.mx/encuesta/01/seguimiento_egresados_UNAM/img/mail_sources/entrevista.png'],
        ['text' => '¿Problemas para titularte? Primer Feria de titulación 2026', 'link' => 'https://titulacion.unam.mx/', 'image' => 'https://www.pveaju.unam.mx/encuesta/01/seguimiento_egresados_UNAM/img/mail_sources/feria_tit.png'],
        ['text' => 'Apoyanos en el ranking internacional! encuesta de empleabilidad verde', 'link' => 'https://encuestas.pveaju.unam.mx/encuesta_verde/inicio/', 'image' => 'https://www.pveaju.unam.mx/encuesta/01/seguimiento_egresados_UNAM/img/mail_sources/emp_verde.png'],
    ];
    // proprcion de imagenes 3:4 

    $data = [
        'nombre' => 'MARTHA NAVA',
        'cuenta' => '311000000',
        'url_encuesta' => 'https://encuestas.pveaju.unam.mx/encuesta_generacion/general',
        'extra_items' => $intereses // Aquí pueden ser 0 o hasta 10
    ];

    Mail::to('marthaunam@hotmail.com')->queue(new InvMail($data));
}
}
