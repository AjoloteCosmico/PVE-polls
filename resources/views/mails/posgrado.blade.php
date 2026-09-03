@extends('mails.base_mail', [
    'encabezado' => 'Posgrado UNAM Encuesta de Seguimiento',
    'remitente' => 'Seguimiento a Egresados UNAM',
    'header_image' => 'header_pos.png',
    'footer_image' => 'footer_pos.png',
    'intereses' => $payload['extra_items'] // Array dinámico de 0 a 10
])

@section('content')
    <p>Estimado egresado <span style="color: #B7812C; font-weight: 700;">{{ $payload['nombre'] }}</span>, con No. cuenta <span style="color: #B7812C; font-weight: 700;">{{ $payload['cuenta'] }}</span>.</p>
    <p>{{ $payload['prog_acad'] }}</p>

    <div style="text-align: center; margin: 18px auto 26px auto;">
        <img src="https://www.pveaju.unam.mx/encuesta/01/seguimiento_egresados_UNAM/img/mail_sources/posgrado_logo.png"
             alt="Logo institucional de posgrado"
             style="display: block; width: 60%; max-width: 400px; height: auto; margin: 0 auto; border-radius: 10px; background: rgba(255,255,255,0)">
    </div>

    <p>Para nosotros es vital conocer tu trayectoria profesional como egresado del posgrado <span style="color: #015190; font-weight: 800;">{{ $payload['prog_acad'] }}</span>, así como tu actualización académica y satisfacción con la institución.</p>
    <p>Contestar esta breve encuesta nos permite perfilar a los egresados de los diferentes posgrados de la UNAM; saber en qué áreas están presentes y cómo mejorar los planes de estudio y la atención a la comunidad.</p>
    <p>También ayuda a los aspirantes a elegir correctamente un programa académico; hazlo por todos, hazlo por tu universidad.</p>

    <h1 style="margin: 0 0 12px; color: #333; font-size: 26px; text-align: center;">Sigues siendo parte de la comunidad UNAM</h1>

    <div style="text-align: center; margin: 30px 0 24px 0;">
        <a href="https://encuestas.pveaju.unam.mx/pveaju/resource/encuesta_posgrado_correo" style="display: inline-block; background-color: #015190; color: #ffffff; padding: 15px 28px; text-decoration: none; border-radius: 8px; font-weight: bold; text-align: center; min-width: 250px; box-shadow: 0 4px 10px rgba(1, 81, 144, 0.22);">
            INICIAR ENCUESTA
        </a>
    </div>

    <br>

    <a href="https://www.pveaju.unam.mx/encuesta/01/seguimiento_egresados_UNAM/resultados.php">👉🏾 Revisa los resultados de generaciones anteriores</a>
    <br>
    <a href="https://www.pveaju.unam.mx/encuesta/01/seguimiento_egresados_UNAM/#creditos">👉🏾 Identifica al equipo del seguimiento</a>

@endsection