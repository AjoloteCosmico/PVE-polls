<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Egresado;
use App\Models\Correo;
use App\Mail\testingMail;
use App\Mail\InvMail;
use App\Mail\EspMail;
use App\Mail\PosMail;
use App\Mail\ActMail;
use App\Mail\EdContinuaMail;
use App\Mail\AvisoPrivacidadMail;
use Illuminate\Support\Facades\Mail;
use DB;

class SendMailController extends Controller
{
    public function test($id){
        $Egresado=Egresado::find($id);
        $Correos=Correo::where('cuenta',$Egresado->cuenta)->get();
        $intereses = [
            ['text' => 'Trámita tu credencial de egresado', 'link' => 'https://www.pveaju.unam.mx/credencial/', 'image' => 'https://www.pveaju.unam.mx/encuesta/01/seguimiento_egresados_UNAM/img/mail_sources/credencial.png'],
            ['text' => 'Bolsa de trabajo UNAM', 'link' => 'https://but.unam.mx/siiabut/public/', 'image' => 'https://www.pveaju.unam.mx/encuesta/01/seguimiento_egresados_UNAM/img/mail_sources/entrevista.png'],
            ['text' => '¿Problemas para titularte? Primer Feria de titulación 2026', 'link' => 'https://titulacion.unam.mx/', 'image' => 'https://www.pveaju.unam.mx/encuesta/01/seguimiento_egresados_UNAM/img/mail_sources/feria_tit.png'],
            ['text' => 'Apoyanos en el ranking internacional! encuesta de empleabilidad verde', 'link' => 'https://encuestas.pveaju.unam.mx/encuesta_verde/inicio/', 'image' => 'https://www.pveaju.unam.mx/encuesta/01/seguimiento_egresados_UNAM/img/mail_sources/emp_verde.png'],
        ];
        $data = [
                'nombre' => $Egresado->nombre.' '.$Egresado->paterno,
                'cuenta' => $Egresado->cuenta,
                'url_encuesta' => 'https://encuestas.pveaju.unam.mx/encuesta_generacion/general',
                'extra_items' => $intereses // Aquí ahorita es una constante, pero habra q hacer un algoritomo ->getIntereses()
            ];
        foreach($Correos as $correo){
            //agregar parametros especificos a data
            $specific_data=$data + ['correo' => $correo->correo, 'correo_id'=>$correo->id];
            Mail::to($correo->correo)->queue(new AvisoPrivacidadMail($specific_data));
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
        'nombre' => 'Fel gonzalez',
        'cuenta' => '311000000',
        'extra_items' => $intereses 
    ];

    Mail::to('marthaunamivyanalitycs@gmail.com')->queue(new AvisoPrivacidadMail($data));
}

public function send_prioritary_mail(Request $request) {
    $type=$request->input('mail_type');
    $correo=$request->input('correo');
    $correo_id=$request->input('correo_id');
    $cuenta=$request->input('cuenta');
    $nombre=$request->input('nombre');
    $prog_acad=$request->input('prog_acad');
    $intereses = [
        ['text' => 'Trámita tu credencial de egresado', 'link' => 'https://www.pveaju.unam.mx/credencial/', 'image' => 'https://www.pveaju.unam.mx/encuesta/01/seguimiento_egresados_UNAM/img/mail_sources/credencial.png'],
        ['text' => 'Bolsa de trabajo UNAM', 'link' => 'https://but.unam.mx/siiabut/public/', 'image' => 'https://www.pveaju.unam.mx/encuesta/01/seguimiento_egresados_UNAM/img/mail_sources/entrevista.png'],
        ['text' => '¿Problemas para titularte? Primer Feria de titulación 2026', 'link' => 'https://titulacion.unam.mx/', 'image' => 'https://www.pveaju.unam.mx/encuesta/01/seguimiento_egresados_UNAM/img/mail_sources/feria_tit.png'],
        ['text' => 'Apoyanos en el ranking internacional! encuesta de empleabilidad verde', 'link' => 'https://encuestas.pveaju.unam.mx/encuesta_verde/inicio/', 'image' => 'https://www.pveaju.unam.mx/encuesta/01/seguimiento_egresados_UNAM/img/mail_sources/emp_verde.png'],
    ];

    // proprcion de imagenes 3:4 

    $data = [
        'nombre' => $nombre,
        'cuenta' => $cuenta,
        'prog_acad'=>$prog_acad,
        'extra_items' => $intereses ,
        'correo' => $correo, 
        'correo_id'=>$correo_id,
        'extra_items' => $intereses
    ];

    switch($type){
        case 'aviso': 
            Mail::to($correo)->queue(new AvisoPrivacidadMail($data));
        break;
        case 'posgrado':
            Mail::to($correo)->queue(new PosMail($data));
        break;
        case 'especialidad': 
            Mail::to($correo)->queue(new EspMail($data));
        break;
        case 'correo_seg_22': 
            Mail::to($correo)->queue(new InvMail($data));
        break;
        case 'act_encuesta': 
            Mail::to($correo)->queue(new ActMail($data));
        break;
        case 'continua': 
            Mail::to($correo)->queue(new EdContinuaMail($data));
        break;
    }

    return response()->json([
                'success' => true, 
                'type' => $data['cuenta'].$data['nombre'].$data['correo'].$type,
                'message' => 'Correo encuado correctamente',
            ]);
    
}

}
