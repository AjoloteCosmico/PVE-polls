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
        ['text' => 'Trámita tu credencial de egresado', 'link' => 'https://www.pveaju.unam.mx/credencial/', 'image' => 'https://www.pveaju.unam.mx/wp-content/uploads/2025/12/page_title_credencialNC.jpg'],
        ['text' => 'Bolsa de trabajo UNAM', 'link' => 'https://but.unam.mx/siiabut/public/', 'image' => 'https://repositorio-uapa.cuaed.unam.mx/repositorio/moodle/pluginfile.php/2517/mod_resource/content/4/UAPA-Entrevista-Trabajo/recursos/fichero_horizontal_S2/img/01.png'],
        ['text' => '¿Problemas para titularte? Primer Feria de titulación 2026', 'link' => 'https://titulacion.unam.mx/', 'image' => 'https://titulacion.unam.mx/static/media/logo-evento.45dc09699b46050ac6db.png'],
        ['text' => 'Apoyanos en el ranking internacional! encuesta de empleabilidad verde', 'link' => 'https://encuestas.pveaju.unam.mx/encuesta_verde/inicio/', 'image' => 'https://encuestas.pveaju.unam.mx/img/verde/empleabilidad-label-blue.png'],
    ];

    $data = [
        'encabezado' => 'ENCABEZADO DE PRUEBA',
        'nombre' => 'JOSE LOPEZ',
        'cuenta' => '311000000',
        'url_encuesta' => 'https://encuestas.pveaju.unam.mx/encuesta_generacion/general',
        'extra_items' => $intereses // Aquí pueden ser 0 o hasta 10
    ];

    Mail::to('felmiquiztli@gmail.com')->queue(new InvMail($data));
}
}
