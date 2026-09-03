@extends('mails.base_mail', [
    'encabezado' => 'Aviso de Privacidad PVEAJU UNAM',
    'remitente' => 'Seguimiento a Egresados UNAM',
    'header_image' => 'header_aviso.png',
    'footer_image' => 'footer_lofi.png',
    'texto_destacado' => ' ',
    'intereses' => $payload['extra_items'] // Array dinámico de 0 a 10
])

@section('content')

<p style="margin: 0 0 12px; line-height: 1.8; color: #333;">
    Estimado egresado:
    <span style="color: #B7812C; font-weight: 700;">{{ $payload['nombre'] }}</span>,
    con No. Cuenta &nbsp;
    <span style="color: #B7812C; font-weight: 700;">{{ $payload['cuenta'] }}</span>.
</p>

<h1 style="margin: 20px 0 12px; color: #333; font-size: 26px; text-align: center;">AVISO DE PRIVACIDAD</h1>

<p style="margin: 0 0 16px; text-align: justify; line-height: 1.8; color: #333;">
    El <strong>Programa de Vinculación con los Egresados y Académicos Jubilados de la Universidad Nacional Autónoma de México (UNAM)</strong>, con domicilio en <strong>Zona Cultural de Ciudad Universitaria, Edificio “D”, planta baja, Alcaldía Coyoacán, C.P. 04510, en la Ciudad de México</strong>, recaba datos personales y es responsable del tratamiento que se les dé.
</p>

<p style="margin: 0 0 18px; text-align: justify; line-height: 1.8; color: #333;">
    Si requiere más información relativa al tratamiento que le daremos a sus datos personales, así como de los proyectos que desarrolla este Programa, puede solicitarla al siguiente correo electrónico: <strong>datospersonales@exalumno.unam.mx</strong>, así como los teléfonos <strong>55 5622-6186</strong> y <strong>55 5622-6181</strong>.
</p>

<p style="margin: 0 0 12px; font-weight: 700; color: #333; line-height: 1.8;">
    Los datos personales que son recabados serán utilizados para las siguientes finalidades: 
</p>

<ul style="margin: 0 0 18px 20px; line-height: 1.8; padding-left: 20px; color: #333;">
    <li style="font-weight: 600; color: #333;">Envío de las publicaciones (electrónicas e impresas).</li>
    <li style="font-weight: 600; color: #333;">Envío de información de eventos culturales desarrollados y/o promovidos por la Universidad.</li>
    <li style="font-weight: 600; color: #333;">Seguimiento profesional y laboral de egresados.</li>
    <li style="font-weight: 600; color: #333;">Generación de estadísticas para identificar, detectar e impulsar el desarrollo de oportunidades para los egresados.</li>
    <li style="font-weight: 600; color: #333;">Actualización de su información en nuestras bases de datos.</li>
</ul>

<p style="margin: 0 0 12px; text-align: justify; line-height: 1.8; color: #333;">
    Recabamos sus datos personales al registrarse como egresado en el apartado denominado <strong>“Registrar como egresado UNAM”</strong> de nuestro sitio web, al actualizar sus datos personales y al solicitar el trámite de su credencial de egresado, para lo cual requerimos obtener los siguientes datos personales:
</p>

<ul style="margin: 0 0 18px 20px; line-height: 1.8; padding-left: 20px; color: #333;">
    <li style="font-weight: 600; color: #333;">Nombre completo.</li>
    <li style="font-weight: 600; color: #333;">Fecha de nacimiento.</li>
    <li style="font-weight: 600; color: #333;">Nivel o grado de estudios.</li>
    <li style="font-weight: 600; color: #333;">Correo electrónico.</li>
    <li style="font-weight: 600; color: #333;">Números telefónicos y/o celular.</li>
    <li style="font-weight: 600; color: #333;">Institución en la que labora o empleo actual.</li>
    <li style="font-weight: 600; color: #333;">Domicilio completo.</li>
</ul>

<p style="margin: 0 0 12px; text-align: justify; line-height: 1.8; color: #333;">
    Igualmente, el Programa de Vinculación con los Egresados y Académicos Jubilados de la UNAM incorpora los datos personales de los titulares que otorgaron su consentimiento a la Dirección General de Administración Escolar (DGAE) para vincularlos con la Universidad en materia de difusión y promoción de actividades académicas, instrumentación de programas de apoyo a egresados y actualización profesional para exalumnos. Tales datos son:
</p>

<ul style="margin: 0 0 18px 20px; line-height: 1.8; padding-left: 20px; color: #333;">
    <li style="font-weight: 600; color: #333;">Fecha de nacimiento.</li>
    <li style="font-weight: 600; color: #333;">Plantel donde estudió.</li>
    <li style="font-weight: 600; color: #333;">Generación a la que pertenece.</li>
    <li style="font-weight: 600; color: #333;">Número de cuenta.</li>
    <li style="font-weight: 600; color: #333;">Si está afiliado a alguna fundación, asociación u organización civil o académica, así como su razón o denominación social.</li>
    <li style="font-weight: 600; color: #333;">Nombre y datos de contacto de un familiar o amigo para localización en caso de emergencia.</li>
</ul>

<p style="margin: 0 0 12px; text-align: justify; line-height: 1.8; color: #333;">
    Asimismo, el Programa de Vinculación con los Egresados y Académicos Jubilados de la UNAM realiza la <strong>“Encuesta de Egresados”</strong> en la que solicita los siguientes datos:
</p>

<ul style="margin: 0 0 18px 20px; line-height: 1.8; padding-left: 20px; color: #333;">
    <li style="font-weight: 600; color: #333;">Identificativos: </li> fecha de nacimiento, género, estado civil, número de hijos, teléfonos (casa, celular y trabajo), correo electrónico.
    <li style="font-weight: 600; color: #333;">Familiares: </li>nivel de estudios y ocupación de su esposo(a), de su madre y padre y Universidad donde cursaron los estudios profesionales sus progenitores.
    <li style="font-weight: 600; color: #333;">Laborales: </li>Empleado: número de empleos, nombre y sector de la empresa o institución donde trabaja, Estado de la República donde se ubica aquella, puesto y condición laboral en esa empresa o institución, relación laboral con su actual profesión, grado de satisfacción laboral y salarial, monto de ingresos mensuales, factores que se consideraron para su contratación, razones y valoraciones de su inserción al campo laboral, actualizaciones profesionales (cursos, diplomados, seminarios, idiomas) y organización en la(s) que lo(s) ha tomado. Si es autoempleado o si está desempleado: motivos por lo que no trabaja, tiempo que ha permanecido sin laborar.
    <li style="font-weight: 600; color: #333;">Académicos: </li>cada uno de sus grados de estudios, institución donde los realizó, motivos por los cuales los realizó, valoración de la experiencia adquirida relativa a su formación, al plan de estudios y a la calidad de enseñanza y a la carga académica. Tiempo que tardó en titularse, si realizó servicio social y dónde. Si se tituló. Dominio del idioma inglés u otro. Tipo de habilidades desarrolladas durante su formación profesional y necesarias para su trabajo.
    <li style="font-weight: 600; color: #333;">Sociales: </li>es miembro de una organización o asociación. Interés por participar en programas de beneficio social.
    <li style="font-weight: 600; color: #333;">Arte, deporte y salud: </li>apreciación al arte, deporte y cuidado de la salud, frecuencia con que practica o asiste a eventos de arte y/o deporte.
</ul>

<p style="margin: 0 0 18px; text-align: justify; line-height: 1.8; color: #333;">
    <strong>Esta área universitaria no realiza transferencias de sus datos personales a terceros.</strong>
</p>

<p style="margin: 0 0 12px; font-weight: 700; color: #333; line-height: 1.8;">
    Fundamento para el tratamiento de datos personales
</p>

<p style="margin: 0 0 18px; text-align: justify; line-height: 1.8; color: #333;">
    Los artículos <strong>6º, Base A</strong> y <strong>16, segundo párrafo</strong>, de la <strong>Constitución Política de los Estados Unidos Mexicanos</strong>; el <strong>3º, fracción XXXIII</strong>, <strong>4º, 16, 17, 18, 20, 21, 22, 23, 26, 27 y 28</strong> de la <strong>Ley General de Protección de Datos Personales en Posesión de Sujetos Obligados</strong>, así como los numerales del <strong>5 al 19</strong> de los <strong>Lineamientos para la Protección de Datos Personales en Posesión de la Universidad Nacional Autónoma de México</strong>, publicados en la Gaceta UNAM el 25 de febrero de 2019.
</p>

<p style="margin: 0 0 12px; font-weight: 700; color: #333; line-height: 1.8;">
    Cookies y Web Beacons
</p>

<p style="margin: 0 0 16px; text-align: justify; line-height: 1.8; color: #333;">
    La página web utiliza cookies y web beacons a través de los cuales es posible generar información estadística. Las cookies son archivos de texto que son descargados automáticamente y almacenados en el disco duro del equipo de cómputo del usuario al navegar en una página de Internet específica, que permiten recordar al servidor de Internet algunos datos sobre este usuario, entre ellos, sus preferencias para la visualización de las páginas en ese servidor, nombre y contraseña. Asimismo, el sitio web contiene anuncios publicitarios que pueden enviar cookies de nuestros usuarios. Las web beacons son imágenes insertadas en una página de Internet o correo electrónico, que puede ser utilizado para monitorear el comportamiento de un visitante, como almacenar información sobre la dirección IP del usuario, duración del tiempo de interacción en dicha página y el tipo de navegador utilizado, entre otros. Dicha información se almacena en las bitácoras de nuestro servidor y es la siguiente:
</p>

<ul style="margin: 0 0 18px 20px; line-height: 1.8; padding-left: 20px; color: #333;">
    <li style="font-weight: 600; color: #333;">Tipo de navegador y sistema operativo.</li>
    <li style="font-weight: 600; color: #333;">Si cuenta o no con software como JavaScript o Flash.</li>
    <li style="font-weight: 600; color: #333;">Sitio que visitó antes de entrar al nuestro.</li>
    <li style="font-weight: 600; color: #333;">Vínculos web que sigue en Internet.</li>
    <li style="font-weight: 600; color: #333;">Su dirección IP (Internet Protocol).</li>
</ul>

<p style="margin: 0 0 12px; text-align: justify; line-height: 1.8; color: #333;">
    Estas cookies y otras tecnologías pueden ser deshabilitadas. Para conocer cómo hacerlo, consulte los siguientes vínculos:
</p>

<ul style="margin: 0 0 18px 20px; line-height: 1.8; padding-left: 20px; color: #333;">
    <li style="font-weight: 600; color: #333;"><strong>Microsoft Edge:</strong> https://support.microsoft.com/es-mx/help/4468242/microsoft-edge-browsing-data-and-privacy-microsoft-privacy</li>
    <li style="font-weight: 600; color: #333;"><strong>Mozilla Firefox:</strong> https://support.mozilla.org/es/kb/habilitar-y-deshabilitar-cookies-sitios-web-rastrear-preferencias</li>
    <li style="font-weight: 600; color: #333;"><strong>Google Chrome:</strong> https://support.google.com/accounts/answer/61416?co=GENIE.Platform%3DDesktop&hl=es</li>
    <li style="font-weight: 600; color: #333;"><strong>Apple Safari:</strong> https://support.apple.com/es-es/guide/safari/sfri11471/mac</li>
</ul>

<p style="margin: 0 0 18px; text-align: justify; line-height: 1.8; color: #333;">
    En el caso de empleo de cookies, el botón de <strong>“ayuda”</strong> que se encuentra en la barra de herramientas de la mayoría de los navegadores, le dirá cómo evitar aceptar nuevas cookies, cómo hacer que el navegador le notifique cuando recibe una nueva cookie o cómo deshabilitar todas las cookies.
</p>

<p style="margin: 0 0 12px; font-weight: 700; color: #333; line-height: 1.8;">
    Ejercicio de derechos ARCO (Acceso, rectificación, cancelación u oposición al uso de sus datos personales)
</p>

<p style="margin: 0 0 12px; text-align: justify; line-height: 1.8; color: #333;">
    Tiene derecho a conocer qué datos personales tenemos de usted, para qué los utilizamos y las condiciones del uso que les damos (<strong>Acceso</strong>). Asimismo, es su derecho a solicitar la corrección de su información personal en caso de que esté desactualizada, sea inexacta o incompleta (<strong>Rectificación</strong>); que la eliminemos de nuestros registros o bases de datos cuando considere que la misma no está siendo utilizada adecuadamente (<strong>Cancelación</strong>); así como oponerse al uso de sus datos personales para fines específicos (<strong>Oposición</strong>). Estos derechos se conocen como derechos ARCO.
</p>

<p style="margin: 0 0 12px; text-align: justify; line-height: 1.8; color: #333;">
    Para ejercer sus derechos de acceso, rectificación, cancelación y oposición puede acudir a la <strong>Plataforma Nacional de Transparencia</strong> o bien por medio de la <strong>Plataforma Nacional de Transparencia</strong> (http://www.plataformadetransparencia.org.mx).
</p>

<p style="margin: 0 0 18px; text-align: justify; line-height: 1.8; color: #333;">
    La determinación adoptada, se le comunicará en un plazo máximo de veinte días hábiles contados desde la fecha en que se recibió la solicitud, a efecto de que, si resulta procedente, haga efectiva la misma dentro de los quince días hábiles siguientes a que se comunique la respuesta.
</p>

<p style="margin: 0 0 18px; text-align: justify; line-height: 1.8; color: #333;">
    Puede revocar el consentimiento que, en su caso, nos haya otorgado para el tratamiento de sus datos personales. Sin embargo, es importante que tenga en cuenta que no en todos los casos podremos atender su solicitud o concluir el uso de forma inmediata, ya que es posible que por alguna obligación legal requiramos seguir tratando sus datos personales. Asimismo, usted deberá considerar que, para ciertos fines, la revocación de su consentimiento implicará que no le podamos seguir prestando el servicio del sistema en línea que nos solicitó, o la conclusión de su relación con nosotros.
</p>

<p style="margin: 0 0 12px; font-weight: 700; color: #333; line-height: 1.8;">
    Limitar el envío de información
</p>

<p style="margin: 0 0 18px; text-align: justify; line-height: 1.8; color: #333;">
    Usted puede dejar de recibir los mensajes informativos visitando <strong>www.pveu.unam.mx/tools/unsucribe.php</strong> e ingresando su dirección de correo.
</p>

<p style="margin: 0 0 12px; font-weight: 700; color: #333; line-height: 1.8;">
    Portabilidad
</p>

<p style="margin: 0 0 18px; text-align: justify; line-height: 1.8; color: #333;">
    <strong>Esta área universitaria actualmente no cuenta con sistemas interoperables, de formatos estructurados y comúnmente utilizados para permitir al titular beneficiarse de la prerrogativa de la portabilidad de datos personales</strong>, en términos del artículo 6 de los Lineamientos que establecen los parámetros, modalidades y procedimientos para la portabilidad de datos personales, publicados en el DOF el 12 de febrero de 2018, por lo que no es posible ejercer la prerrogativa a la portabilidad de sus datos personales.
</p>

<p style="margin: 0 0 12px; font-weight: 700; color: #333; line-height: 1.8;">
    Modificaciones al Aviso de Privacidad
</p>

<p style="margin: 0 0 18px; text-align: justify; line-height: 1.8; color: #333;">
    El presente aviso de privacidad puede sufrir modificaciones o actualizaciones. Dichas actualizaciones o modificaciones estarán disponibles al público, por lo que el Titular podrá consultarlas en el sitio web, en la sección <strong>Aviso de Privacidad</strong>. Se recomienda y requiere al Titular consultar el Aviso de Privacidad, por lo menos semestralmente para estar actualizado de las condiciones y términos de este.
</p>

<p style="margin: 0 0 18px; text-align: justify; line-height: 1.8; color: #333;">
    Esta área universitaria actualmente no cuenta con formatos estructurados y comúnmente utilizados para ejercer el derecho a la portabilidad de datos personales, en términos de lo dispuesto en el artículo 6 de los <strong>“Lineamientos que establecen los parámetros, modalidades y procedimientos para la portabilidad de datos personales”</strong>, publicados en el DOF el 12 de febrero de 2018, por lo que no es posible ejercer el derecho a la portabilidad de sus datos personales.
</p>

<p style="margin: 0 0 18px; text-align: right; font-weight: 600; color: #333; line-height: 1.8;">
    Fecha última actualización: <strong>09 de enero de 2024</strong>.
</p>

@endsection