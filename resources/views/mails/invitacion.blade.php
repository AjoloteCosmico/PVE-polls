@extends('mails.base_mail', [
    'encabezado' => 'Encuesta de Seguimiento Licenciatura',
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

    <p>Para nosotros es vital conocer tu trayectoria profesional, actualización académica y satisfacción con la institución respecto a la licenciatura <span style="color: #015190; font-weight: 800;">{{ $payload['prog_acad'] }}</span>.</p>
    <p>Contestar esta breve encuesta nos permite perfilar a los egresados de las diferentes carreras de la UNAM; saber en qué áreas están presentes y cómo mejorar los planes de estudio y la atención a la comunidad.</p>
    <p>También ayuda a los aspirantes a elegir correctamente la licenciatura que estudiarán; hazlo por todos, hazlo por tu universidad.</p>

    <div style="text-align: center; margin: 30px 0;">
        <a href="https://encuestas.pveaju.unam.mx/pveaju/resource/encuesta_seg_correo" style="background-color: #015190; color: #ffffff; padding: 15px 25px; text-decoration: none; border-radius: 5px; font-weight: bold;">
            INICIAR ENCUESTA
        </a>
    </div>

    <br>

    <a href="https://www.pveaju.unam.mx/encuesta/01/seguimiento_egresados_UNAM/resultados.php">👉🏾 Revisa los resultados de generaciones anteriores</a>
    <br>
    <a href="https://www.pveaju.unam.mx/encuesta/01/seguimiento_egresados_UNAM/#creditos">👉🏾 Identifica al equipo del seguimiento</a>

@endsection