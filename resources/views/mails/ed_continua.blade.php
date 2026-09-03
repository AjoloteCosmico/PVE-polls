@extends('mails.base_mail', [
    'encabezado' => 'Educación Continua UNAM encuesta',
    'remitente' => 'Seguimiento a Egresados UNAM',
    'header_image' => 'header_lofi.png',
    'footer_image' => 'footer_lofi.png',
    'intereses' => $payload['extra_items'] // Array dinámico de 0 a 10
])

@section('content')
    <p style="margin: 0 0 12px; line-height: 1.8; color: #333;">
        Estimado egresado
        <span style="color: #B7812C; font-weight: 700;">{{ $payload['nombre'] }}</span>,
        con No. Cuenta:
        <span style="color: #B7812C; font-weight: 700;">{{ $payload['cuenta'] }}</span>.
    </p>

    <p>Para nosotros es vital conocer tus necesidades de formación más allá de los programas académicos formales (licenciatura o posgrado).</p>
    <p>Esto nos permite diseñar nuevas ofertas educativas y volverlas más accesibles para ti.</p>
    <p>Recuerda que la UNAM sigue siendo tu casa; nunca dejemos de aprender.</p>
 
    <div style="text-align: center; margin: 18px auto 26px auto;">
        <img src="https://www.pveaju.unam.mx/encuesta/01/seguimiento_egresados_UNAM/img/mail_sources/ed_continua.jpg"
             alt="Logo institucional de especialidad"
             style="display: block; width: 90%; max-width: 400px; height: auto; margin: 0 auto; border-radius: 10px; background: rgba(255,255,255,0)">
    </div>

    <div style="text-align: center; margin: 30px 0;">
        <a href="https://encuestas.pveaju.unam.mx/pveaju/resource/encuesta_continua" style="background-color: #015190; color: #ffffff; padding: 15px 25px; text-decoration: none; border-radius: 5px; font-weight: bold;">
            INICIAR ENCUESTA
        </a>
    </div>

    <br>

    <a href="https://www.pveaju.unam.mx/encuesta/01/seguimiento_egresados_UNAM/resultados.php">👉🏾 Revisa los resultados de generaciones anteriores</a>
    <br>
    <a href="https://www.pveaju.unam.mx/encuesta/01/seguimiento_egresados_UNAM/#creditos">👉🏾 Identifica al equipo del seguimiento</a>

@endsection