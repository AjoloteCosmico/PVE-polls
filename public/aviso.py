import smtplib

from email.mime.multipart import MIMEMultipart
from email.mime.text import MIMEText
import sys
import base64
from google_auth_oauthlib.flow import InstalledAppFlow
from googleapiclient.discovery import build
from requests import HTTPError
import os
def AvisoPrivacidad(nombre,you):
    me = "vinculacionexalumnos@exalumno.unam.mx"
# Create message container - the correct MIME type is multipart/alternative.
    msg = MIMEMultipart('alternative')
    msg['Subject'] = "Aviso de privacidad UNAM"
    msg['From'] = me
    msg['To'] = you

   # Create the body of the message (a plain-text and an HTML version).
    text = ""
    html = """\
<html><head><title>Registro al Programa de Vinculacion con los Egresados y Academicos Jubilados</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, minimum-scale=0.5, maximum-scale=1" />
<style>
body {    background:#FFF;    width:99%;    margin:0 auto;    padding:0;}
div {    margin:0 auto;    }
@media (min-width: 451px) and (max-width: 600px), (max-device-width : 451px) and (max-device-width : 600px){
a img {    width:47%;    height:auto;        margin:2px ;    padding:0px;    }
a.grande img {    width:98%;    height:auto;        margin:0px ;    }
}
@media (max-width: 450px), (max-device-width : 450px) {
div {    margin:0px;    }
a img {    width:95%;    height:auto;    margin:0;    }
}
</style></head>
<body>
<div style="min-width:450px;max-width:1200px;"><div align="center" style="background:#F9F9F9">
<img src="http://www.pve.unam.mx/imagenes/futuroUNAM.jpg" width="100" height="39" vspace="10" align="left">
<img src="http://www.pve.unam.mx/imagenes/pve.jpg" height="60" align="right"> &nbsp;<img src="http://www.pve.unam.mx/imagenes/unam.jpg" width="79" height="80" align="texttop">
</div>
<p>&nbsp;</p>
<h2 align="center" style="font-size:1.5em;font-weight:bold;color:#006 !important;">PROGRAMA DE VINCULACI&Oacute;N CON LOS EGRESADOS Y ACADEMICOS JUBILADOS</h2><p>&nbsp;</p>
<p><b>Estimad@ """+nombre+"""</b></p>
<p ALIGN="justify">
<H2><STRONG>AVISO DE  PRIVACIDAD </STRONG></H2>
<P>&nbsp;</P>
<P align="justify">El Programa  de Vinculaci&oacute;n con los Egresados y Academicos Jubilados de la Universidad Nacional 
Aut&oacute;noma de M&eacute;xico  (UNAM), con domicilio en Zona Cultural de  Ciudad 
Universitaria, Edificio "D", planta baja, Alcald&iacute;a Coyoac&aacute;n, C.P.  04510, en la 
Ciudad de M&eacute;xico, recaba datos personales y es responsable del  tratamiento que 
se les de.</P>
<P ALIGN="justify">Si requiere m&aacute;s informaci&oacute;n relativa al tratamiento que le daremos a sus  
datos personales, as&iacute; como de los proyectos que desarrolla este Programa puede  
solicitarla al siguiente correo electr&oacute;nico: <A href="mailto:datospersonales@exalumno.unam.mx">datospersonales@exalumno.unam.mx</A>, 
 as&iacute; como los tel&eacute;fonos 5622-6057, 5622-6186 y 5622-6181.</P>
<P><STRONG>Los datos personales que son  recabados ser&aacute;n utilizados para las 
siguientes finalidades</STRONG><STRONG>:</STRONG></P>
<UL class="listDisco">
  <LI>Env&iacute;o de las publicaciones       (electr&oacute;nicas e impresas);</LI>
  <LI>Env&iacute;o de informaci&oacute;n de eventos       culturales desarrollados y/o 
  promovidos por la Universidad;</LI>
  <LI>Seguimiento profesional y laboral de egresados;</LI>
  <LI>Generaci&oacute;n de estad&iacute;sticas para       identificar, detectar e impulsar el 
  desarrollo de oportunidades para los       egresados; y </LI>
  <LI>Actualizaci&oacute;n de su informaci&oacute;n       en nuestras bases de datos.</LI></UL>
<P ALIGN="justify"><STRONG>Recabamos sus datos personales al registrarse  como egresado en el 
apartado denominado "<EM>Registrar como egresado UNAM</EM>"  de nuestro sitio 
web, al actualizar sus datos personales y al solicitar el  tr&aacute;mite de su 
credencial de egresado, para lo cual requerimos obtener los  siguientes datos 
personales:</STRONG></P>
<UL class="listDisco">
  <LI>Nombre completo;</LI>
  <LI>Fecha de nacimiento;</LI>
  <LI>Nivel o grado de estudios;</LI>
  <LI>Correo electr&oacute;nico;</LI>
  <LI>N&uacute;meros telef&oacute;nicos y/o celular;</LI>
  <LI>Instituci&oacute;n en la que labora o empleo actual; y</LI>
  <LI>Domicilio completo. </LI></UL>
<P ALIGN="justify">Igualmente, el Programa de Vinculaci&oacute;n  con Egresados incorpora los datos 
personales de los titulares que otorgaron su  consentimiento a la Direcci&oacute;n 
General de Administraci&oacute;n Escolar (DGAE) para vincularlos  con la Universidad en 
materia de difusi&oacute;n y promoci&oacute;n de actividades  acad&eacute;micas, instrumentaci&oacute;n de 
programas de apoyo a egresados y actualizaci&oacute;n  profesional para exalumnos. 
Tales datos son: </P>
<UL class="listDisco">
  <LI>Fecha de nacimiento;</LI>
  <LI>Plantel donde estudi&oacute;;</LI>
  <LI>Generaci&oacute;n a la que pertenece;</LI>
  <LI>N&uacute;mero de cuenta;</LI>
  <LI>Si est&aacute; afiliado a alguna fundaci&oacute;n,  asociaci&oacute;n u organizaci&oacute;n civil o 
  acad&eacute;mica, as&iacute; como su raz&oacute;n o denominaci&oacute;n  social; y</LI>
  <LI>Nombre y datos de contacto de un familiar  o amigo para localizaci&oacute;n en 
  caso de emergencia.</LI></UL>
<P ALIGN="justify">Asimismo, el Programa de Vinculaci&oacute;n  con los Egresados y Academicos Jubilados de la UNAM realiza la 
"Encuesta de Egresados" en la que  solicita los siguientes datos: </P>
<UL>
  <LI><STRONG>Identificativos:</STRONG> fecha de  nacimiento, g&eacute;nero, estado 
  civil, n&uacute;mero de hijos, tel&eacute;fonos (casa, celular y  trabajo), correo 
  electr&oacute;nico, </LI>
  <LI><STRONG>Familiares:</STRONG> nivel de estudios y ocupaci&oacute;n  de su 
  esposo(a), de su madre y padre y Universidad donde cursaron los estudios  
  profesionales sus progenitores,</LI>
  <LI><STRONG>Laborales:&nbsp; </STRONG>Empleado: N&uacute;mero de empleos, nombre y 
  sector de la empresa  o instituci&oacute;n donde trabaja, Estado de la Rep&uacute;blica 
  donde se ubica aquella,  puesto y condici&oacute;n laboral en esa empresa o 
  instituci&oacute;n, relaci&oacute;n laboral con  su actual profesi&oacute;n, grado de satisfacci&oacute;n 
  laboral y salarial, monto de  ingresos mensuales, factores que se consideraron 
  para su contrataci&oacute;n, razones  y valoraciones de su inserci&oacute;n al campo 
  laboral, actualizaciones profesionales  (cursos, diplomados, seminarios, 
  idiomas) y organizaci&oacute;n en la(s) que lo(s) ha  tomado. Si es autoempleado o si 
  est&aacute; desempleado: motivos por lo que no  trabaja, tiempo que ha permanecido 
  sin laborar. </LI>
  <LI><STRONG>Acad&eacute;micos: </STRONG>cada uno de sus grados de  estudios, 
  instituci&oacute;n donde los realiz&oacute;, motivos por los cuales los realiz&oacute;,  valoraci&oacute;n 
  de la experiencia adquirida relativa a su formaci&oacute;n, al plan de  estudios y a 
  la calidad de ense&ntilde;anza y a la carga acad&eacute;mica. Tiempo que tardo  en 
  titularse, si realiz&oacute; servicio social y d&oacute;nde. Si se titul&oacute;. Dominio del  
  idioma ingl&eacute;s u otro. Tipo de habilidades desarrolladas durante su formaci&oacute;n  
  profesional y necear&iacute;as para su trabajo. </LI>
  <LI><STRONG>Sociales: </STRONG>&nbsp;Es miembro de una organizaci&oacute;n o 
  asociaci&oacute;n.  Inter&eacute;s por participar en programas de beneficio social. </LI>
  <LI><STRONG>Arte, deporte y salud: </STRONG>apreciaci&oacute;n al arte, deporte y  
  cuidado de la salud, frecuencia con que practica o asiste a eventos de arte 
  y/o  deporte.</LI></UL>
<P>Esta &aacute;rea universitaria no realiza transferencias de sus datos personales a  
terceros. </P>
<P ><STRONG>Fundamento  para el tratamiento de datos personales</STRONG></P>
<P ALIGN="justify">  Los art&iacute;culos 6º, Base A y 16, segundo p&aacute;rrafo, de la Constituci&oacute;n  
Pol&iacute;tica de los Estados Unidos Mexicanos; el 3º, fracci&oacute;n XXXIII, 4º, 16, 17,  
18, 20, 21, 22, 23, 26, 27 y 28 de la Ley  General de Protecci&oacute;n de Datos 
Personales en Posesi&oacute;n de Sujetos Obligados, as&iacute;  como los numerales del 5 al 19 
de los Lineamientos para la Protecci&oacute;n de Datos Personales  en Posesi&oacute;n de la 
Universidad Nacional Aut&oacute;noma de M&eacute;xico, publicados en la  Gaceta UNAM el 25 de 
febrero de 2019. <BR><STRONG><EM>Cookies</EM></STRONG><STRONG> y <EM>Web 
Beacons</EM></STRONG> <BR>  La p&aacute;gina web utiliza <EM>cookies</EM> y <EM>web 
beacons </EM>a trav&eacute;s de los cuales es  posible generar informaci&oacute;n estad&iacute;stica. 
<BR>  Las <EM>cookies</EM> son archivos de texto  que son descargados 
autom&aacute;ticamente y almacenados en el disco duro del equipo  de c&oacute;mputo del 
usuario al navegar en una p&aacute;gina de Internet espec&iacute;fica, que  permiten recordar 
al servidor de Internet algunos datos sobre este usuario, entre  ellos, sus 
preferencias para la visualizaci&oacute;n de las p&aacute;ginas en ese servidor,  nombre y 
contrase&ntilde;a. Asimismo, el sitio web contiene anuncios publicitarios que  pueden 
enviar <EM>cookies </EM>de nuestros  usuarios. <BR>  Las <EM>web beacons</EM> 
son im&aacute;genes  insertadas en una p&aacute;gina de Internet o correo electr&oacute;nico, que 
puede ser  utilizado para monitorear el comportamiento de un visitante, como 
almacenar  informaci&oacute;n sobre la direcci&oacute;n IP del usuario, duraci&oacute;n del tiempo de 
 interacci&oacute;n en dicha p&aacute;gina y el tipo de navegador utilizado, entre otros.  
Dicha informaci&oacute;n se almacena en las bit&aacute;coras de nuestro servidor y es la  
siguiente:</P>
<UL>
  <LI>Tipo de navegador y sistema operativo.   </LI>
  <LI>Si cuenta o no con software como java script o flash.   </LI>
  <LI>Sitio que visit&oacute; antes de entrar al nuestro.   </LI>
  <LI>V&iacute;nculos web que sigue en Internet.   </LI>
  <LI>Su direcci&oacute;n IP (<EM>Internet  Protocol</EM>). </LI></UL>
<P>Estas <EM>cookies</EM> y otras tecnolog&iacute;as  pueden ser deshabilitadas. Para 
conocer c&oacute;mo hacerlo, consulte los siguientes  v&iacute;nculos:</P>
<UL class="listDisco">
  <LI><STRONG>Microsoft Edge:</STRONG> 
  https://support.microsoft.com/es-mx/help/4468242/microsoft-edge-browsing-data-and-privacy-microsoft-privacy<BR></LI>
  <LI><STRONG>Mozilla Firefox</STRONG>: 
  https://support.mozilla.org/es/kb/habilitar-y-deshabilitar-cookies-sitios-web-rastrear-preferencias<BR></LI>
  <LI><STRONG>Google  Chrome:</STRONG> 
  https://support.google.com/accounts/answer/61416?co=GENIE.Platform%3DDesktop&amp;hl=es 
  <BR></LI>
  <LI><STRONG>Apple  Safari:</STRONG> 
  https://support.apple.com/es-es/guide/safari/sfri11471/mac </LI></UL>
<P ALIGN="justify">En el caso de empleo de <EM>cookies</EM>,  el bot&oacute;n de "ayuda" que se 
encuentra en la barra de herramientas de  la mayor&iacute;a de los navegadores, le dir&aacute; 
c&oacute;mo evitar aceptar nuevas <EM>cookies</EM>, c&oacute;mo hacer que el navegador le  
notifique cuando recibe una nueva cookie o c&oacute;mo deshabilitar todas las 
<EM>cookies</EM>.</P>
<P><STRONG>Ejercicio de derechos ARCO (A</STRONG><STRONG>cceso, rectificaci&oacute;n, 
cancelaci&oacute;n u oposici&oacute;n al uso de sus  datos personales) </STRONG></P>
<P ALIGN="justify">  Tiene derecho a conocer  qu&eacute; datos personales tenemos de usted, para qu&eacute; 
los utilizamos y las  condiciones del uso que les damos (Acceso). Asimismo, es 
su derecho a solicitar  la correcci&oacute;n de su informaci&oacute;n personal en caso de que 
est&eacute; desactualizada,  sea inexacta o incompleta (Rectificaci&oacute;n); que la 
eliminemos de nuestros  registros o bases de datos cuando considere que la misma 
no est&aacute; siendo  utilizada adecuadamente (Cancelaci&oacute;n); as&iacute; como oponerse al uso 
de sus datos  personales para fines espec&iacute;ficos (Oposici&oacute;n). Estos derechos se 
conocen como  derechos ARCO.<BR>  Para ejercer sus derechos de acceso,  
rectificaci&oacute;n, cancelaci&oacute;n y oposici&oacute;n puede acudir a la o bien por medio de la 
Plataforma  Nacional de Transparencia (<A href="http://www.plataformadetransparencia.org.mx/" 
target="_blank">http://www.plataformadetransparencia.org.mx/</A>).<BR>  La 
determinaci&oacute;n  adoptada, se le comunicar&aacute; en un plazo m&aacute;ximo de veinte d&iacute;as 
h&aacute;biles contados  desde la fecha en que se recibi&oacute; la solicitud, a efecto de 
que, si resulta  procedente, haga efectiva la misma dentro de los quince d&iacute;as 
h&aacute;biles siguientes  a que se comunique la respuesta.<BR>  Puede revocar el  
consentimiento que, en su caso, nos haya otorgado para el tratamiento de sus  
datos personales. Sin embargo, es importante que tenga en cuenta que no en  
todos los casos podremos atender su solicitud o concluir el uso de forma  
inmediata, ya que es posible que por alguna obligaci&oacute;n legal requiramos seguir  
tratando sus datos personales. Asimismo, usted deber&aacute; considerar que, para  
ciertos fines, la revocaci&oacute;n de su consentimiento implicar&aacute; que no le podamos  
seguir prestando el servicio del sistema en l&iacute;nea que nos solicit&oacute;, o la  
conclusi&oacute;n de su relaci&oacute;n con nosotros.</P>
<P><STRONG>Limitar el env&iacute;o de informaci&oacute;n</STRONG></P>
<P>  Usted puede dejar de recibir los mensajes informativos visitando 
<U>www.pve.unam.mx/tools/unsucribe.php</U> e ingresando su direcci&oacute;n de 
correo.</P>
<P><STRONG>Modificaciones al Aviso de  Privacidad</STRONG></P>
<P>  El presente aviso de privacidad puede sufrir modificaciones o 
actualizaciones.  Dichas actualizaciones o modificaciones estar&aacute;n disponibles al 
p&uacute;blico, por lo  que el Titular podr&aacute; consultarlas en el sitio web, en la 
secci&oacute;n Aviso de  Privacidad. Se recomienda y requiere al Titular consultar el 
Aviso de  Privacidad, por lo menos semestralmente para estar actualizado de las  
condiciones y t&eacute;rminos de este. <U></U></P>
<P><STRONG>Fecha &uacute;ltima actualizaci&oacute;n: </STRONG>22 de abril de 
2019.</P>
</p>
<hr /><div style="text-align:left; font-size: 95%;">
<p align="left">POR MI RAZA HABLAR&Aacute; EL ESP&Iacute;RITU</p>
<p>      Ven y adquiere tu credencial de egresado en: <br />
- Zona Cultural de C.U., edificio D, planta baja,    (a un costado del museo Universum)    de lunes a  viernes de 10:00 a 18:00 hrs.</p>
<p>Informes a los tel&eacute;fonos:  5622-6057, 5622-6186  y 5622-6181 Fax: 5622-6058</p>
</div>
</div></body></html>
"""
#usar las credenciales de OAuth2 de gugul
#     SCOPES = [
#             "https://www.googleapis.com/auth/gmail.send"
#         ]
#     flow = InstalledAppFlow.from_client_secrets_file(
#                 'credentials.json', SCOPES)
#     creds = flow.creds = flow.run_console()
#     service = build('gmail', 'v1', credentials=creds)
# # Record the MIME types of both parts - text/plain and text/html.
#     part1 = MIMEText(text, 'plain')
#     part2 = MIMEText(html, 'html')

# Attach parts into message container.
# According to RFC 2046, the last part of a multipart message, in this case
# the HTML message, is best and preferred.
    # msg.attach(part1)
    # msg.attach(part2)
# Send the message via local SMTP server.
    mail = smtplib.SMTP('smtp.gmail.com', 587)

    mail.ehlo()

    mail.starttls()

    mail.login('vinculacionexalumnos@exalumno.unam.mx', 'programa')
    mail.sendmail(me, you, msg.as_string())
    mail.quit()
    # Send con el nuevbo metodo
    # create_message = {'raw': base64.urlsafe_b64encode(msg.as_bytes()).decode()}
    # message = (service.users().messages().send(userId="me", body=create_message).execute())

nombre=str(sys.argv[1])
email=str(sys.argv[2])

AvisoPrivacidad(nombre,email)