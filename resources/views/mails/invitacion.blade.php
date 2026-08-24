@extends('mails.base_mail', [
    'encabezado' => 'Encuesta de Seguimiento Licenciatura',
    'remitente' => 'Seguimiento a Egresados UNAM',
    'header_image' => 'header_lofi.png',
    'texto_destacado' => 'Tu opinión construye el futuro de nuestra comunidad.',
    'intereses' => $payload['extra_items'] // Array dinámico de 0 a 10
])

@section('content')
    <p>Estimado egresado {{$payload['nombre']}}, con no.cnta {{$payload['cuenta']}}</p>
    <p>Para nosotros es vital conocer tu trayectoria profesional, Actualización académica y satisfacción con la institución.</p>
    <p>Contestar esta breve encuesta nos permite perfilar a los egresados de las diferentes carreras de la UNAM; saber en que áreas estan presentes y como mejorar los planes de estudio y la atención a la comunidad.</p>
    <p>Tambien ayuda a los aspirantes a elegir correctamente la licenciatura que estudiarán, hazlo por todos, hazlo por tu universidad!</p>
    
    <div style="text-align: center; margin: 30px 0;">
        <a href="{{ $payload['url_encuesta']}}" style="background-color: #015190; color: #ffffff; padding: 15px 25px; text-decoration: none; border-radius: 5px; font-weight: bold;">
            INICIAR ENCUESTA
        </a>
    </div>
<br>

<a href="https://www.pveaju.unam.mx/encuesta/01/seguimiento_egresados_UNAM/resultados.php">👉🏾 Revisa los resultados de generaciones anteriores</a>
<br>
<a href="https://www.pveaju.unam.mx/encuesta/01/seguimiento_egresados_UNAM/#creditos"> 👉🏾 Identidica al equipo del seguimiento </a>

@endsection