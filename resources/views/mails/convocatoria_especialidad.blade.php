@extends('mails.base_mail', [
    'encabezado' => 'Convocatoria Titulación Especialidad UNAM',
    'remitente' => 'Seguimiento a Egresados UNAM',
    'header_image' => 'header_vacio.png',
    'footer_image' => 'footer_pos.png',
    'intereses' => $payload['extra_items'] // Array dinámico de 0 a 10
])

@section('content')
    <p> &nbsp;&nbsp; Estimado egresado <span style="color: #B7812C; font-weight: 700;">{{ $payload['nombre'] }}</span>, con No. cuenta <span style="color: #B7812C; font-weight: 700;">{{ $payload['cuenta'] }}</span> egresado de especialidad en derecho UNAM.</p>
    

    <div style="text-align: center; margin: 18px auto 26px auto;">
        <img src="https://www.pveaju.unam.mx/encuesta/01/seguimiento_egresados_UNAM/img/mail_sources/header_derecho.png"
             alt="Logo institucional de especialidad"
             style="display: block; width: 60%; max-width: 400px; height: auto; margin: 0 auto; border-radius: 10px; background: rgba(255,255,255,0)">
    </div>
    <p>Con fundamento en lo dispuesto en los artículos 1, 2, 21, 25, 32, 35 y 36, del Reglamento General de Estudios de Posgrado; 1, 14, 18, 23, 28, de los Lineamientos Generales para el funcionamiento del Posgrado; y 1, 2, 27, 28 y 29 de las Normas Operativas del Programa Único de las Especializaciones en Derecho, todas de las Universidad Nacional Autónoma de México, se emite la siguiente</p>
    <br>
    <p> 
    <center>
        <a href="https://posgrado.derecho.unam.mx/convocatorias/ConvocatoriaEGCEspecialidad2027-1.pdf?v=stable" > 
            <span style="color: #B7812C; font-weight: 800; size:15px">  CONVOCATORIA   2027–1 </span>
        </a>
    </center>
    </p>
    <br>
    <p>Dirigida a la comunidad egresada de alguna de las especializaciones en Derecho impartidas y cursadas en esta Facultad de Derecho1, campus Ciudad Universitaria, a participar en el proceso de obtención del grado de Especialista en Derecho mediante la presentación del Examen General de Conocimientos.</p>
    <p>Consulta las bases y el proceso de registro en la convocatoriría completa: </p>
    <br>
     
    <div style="text-align: center; margin: 30px 0 24px 0;">
        <a href="https://posgrado.derecho.unam.mx/convocatorias/ConvocatoriaEGCEspecialidad2027-1.pdf?v=stable" style="display: inline-block; background-color: #2c53717e; color: #ffffff; padding: 15px 28px; text-decoration: none; border-radius: 8px; font-weight: bold; text-align: center; min-width: 180px; box-shadow: 0 4px 10px rgba(21, 46, 65, 0.22);">
            <img src="https://www.pveaju.unam.mx/encuesta/01/seguimiento_egresados_UNAM/img/mail_sources/Conv-Esp-examen.png"
             alt="Convocatoria Examen especialidad 2026-1"
             style="display: block; width: 80%; max-width: 400px; height: auto; margin: 0 auto; border-radius: 10px; background: rgba(255,255,255,0)">
        </a>
    </div>

    <br>

@endsection