@extends('mails.base_mail', [
    'encabezado' => 'Satsifacción credencial PVEAJU UNAM encuesta',
    'remitente' => 'Seguimiento a Egresados UNAM',
    'header_image' => 'header_lofi.png',
    'footer_image' => 'footer_lofi.png',
    'intereses' => $payload['extra_items'] // Array dinámico de 0 a 10
])

@section('content')
    <p style="margin: 0 0 12px; line-height: 1.8; color: #333;">
        &nbsp;&nbsp;Estimado egresado
        <span style="color: #B7812C; font-weight: 700;">{{ $payload['nombre'] }}</span>,
        con No. Cuenta:
        <span style="color: #B7812C; font-weight: 700;">{{ $payload['cuenta'] }}</span>.
    </p>

    <p>Para nosotros es vital conocer tu satisfacción con la credencial de egresado UNAM; desde la solicitud de esta, hasta el uso cotidiano que puedes darle,.</p>
    <p>Esto nos permite mejorar el proceso del trámite y ampliar los beneficios que te otorga la credencial.</p>
    <p>Recuerda que la UNAM sigue siendo tu casa; !Comunidad UNAM! .</p>
 
    <div style="text-align: center; margin: 18px auto 26px auto;">
        <img src="https://www.pveaju.unam.mx/encuesta/01/seguimiento_egresados_UNAM/img/mail_sources/banner_credencial.jpg"
             alt="Banner encuesta credencial"
             style="display: block; width: 100%; max-width: 600px; height: auto; margin: 0 auto; border-radius: 10px; background: rgba(255,255,255,0)">
    </div>

    <div style="text-align: center; margin: 30px 0;">
        <a href="https://encuestas.pveaju.unam.mx/pveaju/resource/encuesta_credencial" style="background-color: #015190; color: #ffffff; padding: 15px 25px; text-decoration: none; border-radius: 5px; font-weight: bold;">
            INICIAR ENCUESTA
        </a>
    </div>

    <br>

    <a href="https://www.pveaju.unam.mx/encuesta/01/seguimiento_egresados_UNAM/resultados.php">👉🏾 Revisa los resultados de generaciones anteriores</a>
    <br>
    <a href="https://www.pveaju.unam.mx/encuesta/01/seguimiento_egresados_UNAM/#creditos">👉🏾 Identifica al equipo del seguimiento</a>

@endsection