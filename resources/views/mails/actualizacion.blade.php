@extends('mails.base_mail', [
    'encabezado' => 'Encuesta de Actualización Seguimiento Licenciatura',
    'remitente' => 'Seguimiento a Egresados UNAM',
    'header_image' => 'header_lofi.png',
    'footer_image' => 'footer_lofi.png',
    'intereses' => $payload['extra_items'] // Array dinámico de 0 a 10
])

@section('content')
    <p style="margin: 0 0 12px; line-height: 1.8; color: #333;">
      &nbsp;&nbsp;  Estimado egresado
        <span style="color: #B7812C; font-weight: 700;">{{ $payload['nombre'] }}</span>,
        con No. Cuenta:
        <span style="color: #B7812C; font-weight: 700;">{{ $payload['cuenta'] }}</span>.
    </p>
<p>Hace algunos años compartiste con nosotros información sobre tu trayectoria como egresado de la UNAM. Hoy queremos volver a saber de ti y conocer cómo ha evolucionado tu experiencia profesional y académica.</p>
<p>Por ello, te invitamos a contestar esta breve encuesta de actualización, en la que podrás compartir información sobre tu trayectoria profesional, actualización académica y percepción sobre tu formación en la licenciatura de <span style="color: #015190; font-weight: 800;">{{ $payload['prog_acad'] }}</span>.</p>
<p>Tu participación nos permite conocer cómo se desarrollan profesionalmente nuestros egresados, identificar las áreas en las que están presentes y contar con información que contribuya a mejorar los planes de estudio y la atención a nuestra comunidad universitaria.</p>
<p>Además, tu experiencia puede ser de gran utilidad para quienes están por elegir una licenciatura y desean conocer las oportunidades y caminos profesionales que pueden encontrar después de estudiar en la UNAM.</p>
<p><span style="color: #B7812C; font-weight: 700;">Tu trayectoria cuenta. Ayúdanos a seguir conociendo a nuestros egresados.</span></p>


    <div style="text-align: center; margin: 30px 0;">
        <a href="https://encuestas.pveaju.unam.mx/pveaju/resource/encuesta_act_correo" style="background-color: #015190; color: #ffffff; padding: 15px 25px; text-decoration: none; border-radius: 5px; font-weight: bold;">
            INICIAR ENCUESTA
        </a>
    </div>

    <br>

    <a href="https://www.pveaju.unam.mx/encuesta/01/seguimiento_egresados_UNAM/resultados.php">👉🏾 Revisa los resultados de generaciones anteriores</a>
    <br>
    <a href="https://www.pveaju.unam.mx/encuesta/01/seguimiento_egresados_UNAM/#creditos">👉🏾 Identifica al equipo del seguimiento</a>

@endsection