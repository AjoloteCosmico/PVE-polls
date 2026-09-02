@extends('mails.base_mail', [
    'encabezado' => 'Encuesta de Seguimiento Especialidad',
    'remitente' => 'Seguimiento a Egresados UNAM',
    'header_image' => 'header_lofi.png',
    'texto_destacado' => 'Tu opinión construye el futuro de nuestra comunidad.',
    'intereses' => $payload['extra_items'] // Array dinámico de 0 a 10
])

@section('content')
    <p>Estimado egresado {{$payload['nombre']}}, con no. cuenta {{$payload['cuenta']}} </p>
    <p>{{$payload['prog_acad']}} </p>

    <div style="text-align: center; margin: 18px auto 26px auto;">
        <img src="https://www.pveaju.unam.mx/encuesta/01/seguimiento_egresados_UNAM/img/mail_sources/pos_derecho.png"
             alt="Logo institucional de especialidad"
             style="display: block; width: 60%; max-width: 400px; height: auto; margin: 0 auto; border-radius: 10px; background: rgba(255,255,255,0)">
    </div>

    <p>Para nosotros es vital conocer tu trayectoria profesional, Actualización académica y satisfacción con la institución.</p>
    <p>Contestar esta breve encuesta nos permite perfilar a los egresados de las diferentes carreras de la UNAM; saber en que áreas estan presentes y como mejorar los planes de estudio y la atención a la comunidad.</p>
    <p>Tambien ayuda a los aspirantes a elegir correctamente la licenciatura que estudiarán, hazlo por todos, hazlo por tu universidad!</p>
    
    <div style="text-align: center; margin: 30px 0 24px 0;">
        <a href="https://encuestas.pveaju.unam.mx/pveaju/resource/enc_especialidad" style="display: inline-block; background-color: #015190; color: #ffffff; padding: 15px 28px; text-decoration: none; border-radius: 8px; font-weight: bold; text-align: center; min-width: 250px; box-shadow: 0 4px 10px rgba(1, 81, 144, 0.22);">
            INICIAR ENCUESTA
        </a>
    </div>
<br>

<a href="https://www.pveaju.unam.mx/encuesta/01/seguimiento_egresados_UNAM/resultados.php">👉🏾 Revisa los resultados de generaciones anteriores</a>
<br>
<a href="https://www.pveaju.unam.mx/encuesta/01/seguimiento_egresados_UNAM/#creditos"> 👉🏾 Identidica al equipo del seguimiento </a>

@endsection 