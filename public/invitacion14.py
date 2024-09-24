import smtplib

from email.mime.multipart import MIMEMultipart
from email.mime.text import MIMEText
from email.mime.image import MIMEImage
import sys

import os
def AvisoPrivacidad(nombre,you,cuenta,carrera,plantel,link):
    me = "vinculacionexalumnos@exalumno.unam.mx"
# Create message container - the correct MIME type is multipart/alternative.
    msg = MIMEMultipart('related')
    msg['Subject'] = "Invitación PVEAJU UNAM"
    msg['From'] = me
    msg['To'] = you

   # Create the body of the message (a plain-text and an HTML version).
    html = """\
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
  <head>
    <!-- Compiled with Bootstrap Email version: 1.4.0 --><meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="x-apple-disable-message-reformatting">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no, date=no, address=no, email=no">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <style type="text/css">
      body,table,td{font-family:Helvetica,Arial,sans-serif !important}.ExternalClass{width:100%}.ExternalClass,.ExternalClass p,.ExternalClass span,.ExternalClass font,.ExternalClass td,.ExternalClass div{line-height:150%}a{text-decoration:none}*{color:inherit}a[x-apple-data-detectors],u+#body a,#MessageViewBody a{color:inherit;text-decoration:none;font-size:inherit;font-family:inherit;font-weight:inherit;line-height:inherit}img{-ms-interpolation-mode:bicubic}table:not([class^=s-]){font-family:Helvetica,Arial,sans-serif;mso-table-lspace:0pt;mso-table-rspace:0pt;border-spacing:0px;border-collapse:collapse}table:not([class^=s-]) td{border-spacing:0px;border-collapse:collapse}@media screen and (max-width: 600px){.w-full,.w-full>tbody>tr>td{width:100% !important}*[class*=s-lg-]>tbody>tr>td{font-size:0 !important;line-height:0 !important;height:0 !important}.s-2>tbody>tr>td{font-size:8px !important;line-height:8px !important;height:8px !important}.s-3>tbody>tr>td{font-size:12px !important;line-height:12px !important;height:12px !important}.s-5>tbody>tr>td{font-size:20px !important;line-height:20px !important;height:20px !important}.s-10>tbody>tr>td{font-size:40px !important;line-height:40px !important;height:40px !important}}
    </style>
  </head>
  <body>
    <div>
      <table cellspacing="0" cellpadding="0" style="width:100%; border-collapse:collapse;">
          <tbody>
              <tr>
                  <td style="vertical-align:top; background-color:#f6f6f6;">
                      <div style="text-align:center;">
                          <table cellspacing="0" cellpadding="0" style="width:100%; margin-right:auto; margin-left:auto; border-collapse:collapse;">
                              <tbody>
                                  <tr>
                                      <td style="vertical-align:middle;">
                                          <div style="text-align:center;">
                                              <table cellspacing="0" cellpadding="0" style="width:450pt; margin-right:auto; margin-left:auto; border-collapse:collapse;">
                                                  <tbody>
                                                      <tr>
                                                          <td style="padding-top:15pt; padding-right:15pt; padding-left:15pt; vertical-align:middle; background-color:#ffffff;">
                                                              <table cellspacing="0" cellpadding="0" style="width:100%; border-collapse:collapse;">
                                                                  <tbody>
                                                                      <tr>
                                                                          <td style="width:420pt; vertical-align:top;">
                                                                              <div style="text-align:center;">
                                                                                  <table cellspacing="0" cellpadding="0" style="width:100%; margin-right:auto; margin-left:auto; border-collapse:collapse;">
                                                                                      <tbody>
                                                                                          <tr>
                                                                                              <td style="vertical-align:middle;">
                                                                                                  <img src="cid:PVEAJU-header" alt="PVEAJU-header">
                                                                                              </td>
                                                                                          </tr>
                                                                                      </tbody>
                                                                                  </table>
                                                                              </div>
                                                                          </td>
                                                                      </tr>
                                                                  </tbody>
                                                              </table>
                                                          </td>
                                                      </tr>
                                                      <tr>
                                                          <td style="padding-top:15pt; padding-right:15pt; padding-left:15pt; vertical-align:middle; background-color:#ffffff;">
                                                              <table cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                                                                  <tbody>
                                                                      <tr>
                                                                          <td style="width:420pt; vertical-align:middle;">
                                                                              <table cellspacing="0" cellpadding="0" style="width:100%; border-collapse:collapse;">
                                                                                  <tbody>
                                                                                      <tr>
                                                                                          <td style="vertical-align:middle;">
                                                                                              <p style="margin-top:0pt; margin-bottom:0pt; line-height:15.75pt;"><br>"""+nombre+"""</p>
                                                                                              <p style="margin-top:0pt; margin-bottom:0pt; line-height:15.75pt;"><br>Número de Cta: """+cuenta+"""</p>
                                                                                              <p style="margin-top:0pt; margin-bottom:0pt; line-height:15.75pt;"><br>"""+plantel+"""</p>
                                                                                              <p style="margin-top:0pt; margin-bottom:0pt; line-height:15.75pt;"><br>"""+carrera+"""</p>
                                                                                          </td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                          <td style="padding-bottom:15pt; vertical-align:middle;">
                                                                                              <h1 style="margin-top:0pt; margin-bottom:0pt; text-align:center; line-height:18pt;"><span style="font-family:'Segoe UI'; font-size:12pt; color:#002b7a;">ESTIMADO EGRESADO(A):</span></h1>
                                                                                          </td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                          <td style="padding-right:30pt; padding-left:30pt; padding-bottom:15pt; vertical-align:middle;">
                                                                                              <h2 style="margin-top:0pt; margin-bottom:0pt; text-align:justify; line-height:15.75pt;"><span style="font-family:'Segoe UI'; font-size:10.5pt; font-weight:normal; color:#333333;">La Universidad Nacional Aut&oacute;noma de M&eacute;xico est&aacute; realizando un estudio sobre el perfil de sus egresados y egresadas, para lo cual solicitamos su ayuda. Le pedimos que&nbsp;</span><span style="font-family:'Segoe UI'; font-size:10.5pt; color:#333333;">conteste una encuesta v&iacute;a Internet</span><span style="font-family:'Segoe UI'; font-size:10.5pt; font-weight:normal; color:#333333;">&nbsp;dando click en el siguiente bot&oacute;n:</span></h2>
                                                                                          </td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                          <td style="vertical-align:middle;">
                                                                                              <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:12pt;"><a style="background-color:#b39648;color:white;font-size:16px;font-family:Helvetica,Arial,sans-serif;text-decoration:none;border-radius:6px;line-height:20px;font-weight:normal;white-space:nowrap;padding:8px 12px;border:1px solid transparent" href="https://encuestas.pveaju.unam.mx/encuesta_generacion/2020" target="_blank">LLena la encuesta</a>
                                                                                          </td>
                                                                                      </tr>
                                                                                  </tbody>
                                                                              </table>
                                                                          </td>
                                                                      </tr>
                                                                  </tbody>
                                                              </table>
                                                              <p style="margin-top:0pt; margin-bottom:0pt; font-size:10pt;"><span style="height:0pt; display:block; position:absolute; z-index:0;"></span>&nbsp;</p>
                                                          </td>
                                                      </tr>
                                                      <tr>
                                                          <td style="padding-top:3.75pt; padding-right:15pt; padding-left:15pt; vertical-align:middle; background-color:#ffffff;">
                                                              <table cellspacing="0" cellpadding="0" style="width:420pt;">
                                                                  <tbody>
                                                                      <tr>
                                                                          <td style="width:145.5pt; vertical-align:top;">
                                                                              <table cellspacing="0" cellpadding="0" style="border-collapse:collapse; float:left;">
                                                                                  <tbody>
                                                                                      <tr>
                                                                                          <td style="width:130.5pt; vertical-align:middle;">
                                                                                              <table cellspacing="0" cellpadding="0" style="width:100%; border-collapse:collapse;">
                                                                                                  <tbody>
                                                                                                      <tr>
                                                                                                          <td style="vertical-align:middle;">
                                                                                                              <p style="margin-top:0pt; margin-bottom:0pt; line-height:15.75pt;"><br></p>
                                                                                                          </td>
                                                                                                      </tr>
                                                                                                  </tbody>
                                                                                              </table>
                                                                                          </td>
                                                                                          <td style="width:15pt; vertical-align:middle;">
                                                                                              <p style="margin-top:0pt; margin-bottom:0pt; font-size:10pt;">&nbsp;</p>
                                                                                          </td>
                                                                                      </tr>
                                                                                  </tbody>
                                                                              </table>
                                                                          </td>
                                                                          <td style="width:129.75pt; vertical-align:top;">
                                                                              <table cellspacing="0" cellpadding="0" style="border-collapse:collapse; float:left;">
                                                                                  <tbody>
                                                                                      <tr>
                                                                                          <td style="width:129.75pt; vertical-align:middle;">
                                                                                              <table cellspacing="0" cellpadding="0" style="width:100%; border-collapse:collapse;">
                                                                                                  <tbody>
                                                                                                      <tr>
                                                                                                          <td style="padding-bottom:18.75pt; vertical-align:middle;">
                                                                                                              <h4 style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:7.5pt;"><span style="font-family:'Segoe UI'; font-weight:normal; color:#002b7a;">La informaci&oacute;n que usted proporcione ser&aacute; estrictamente confidencial y solo se utilizar&aacute; con fines estad&iacute;sticos.&nbsp;</span></h4>
                                                                                                              <h4 style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:12pt;"><a href="https://www.pveaju.unam.mx/aviso-de-privacidad.php" style="text-decoration:none;"><u><span style="font-family:'Segoe UI'; font-size:7.5pt; font-weight:normal; color:#2f5496;">Revise nuestro aviso de privacidad.</span></u></a><span style="font-family:'Segoe UI'; font-size:7.5pt; font-weight:normal; color:#002b7a;">&nbsp;</span></h4>
                                                                                                          </td>
                                                                                                      </tr>
                                                                                                  </tbody>
                                                                                              </table>
                                                                                          </td>
                                                                                      </tr>
                                                                                  </tbody>
                                                                              </table>
                                                                          </td>
                                                                          <td style="width:15pt; vertical-align:middle;">
                                                                              <p style="margin-top:0pt; margin-bottom:0pt; font-size:10pt;">&nbsp;</p>
                                                                          </td>
                                                                          <td style="width:129.75pt; vertical-align:top;">
                                                                              <table cellspacing="0" cellpadding="0" style="border-collapse:collapse; float:right;">
                                                                                  <tbody>
                                                                                      <tr>
                                                                                          <td style="width:129.75pt; vertical-align:middle;">
                                                                                              <table cellspacing="0" cellpadding="0" style="width:100%; border-collapse:collapse;">
                                                                                                  <tbody>
                                                                                                      <tr>
                                                                                                          <td style="vertical-align:middle;">
                                                                                                              <p style="margin-top:0pt; margin-bottom:0pt; line-height:15.75pt;"><br></p>
                                                                                                          </td>
                                                                                                      </tr>
                                                                                                  </tbody>
                                                                                              </table>
                                                                                          </td>
                                                                                      </tr>
                                                                                  </tbody>
                                                                              </table>
                                                                          </td>
                                                                      </tr>
                                                                  </tbody>
                                                              </table>
                                                          </td>
                                                      </tr>
                                                      <tr>
                                                          <td style="padding-top:15pt; padding-right:15pt; padding-left:15pt; vertical-align:middle; background-color:#ffffff;">
                                                              <table cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                                                                  <tbody>
                                                                      <tr>
                                                                          <td style="width:420pt; vertical-align:middle;">
                                                                              <table cellspacing="0" cellpadding="0" style="width:420.75pt; border-collapse:collapse;">
                                                                                  <tbody>
                                                                                      <tr style="height:141.75pt;">
                                                                                          <td style="padding-right:30pt; padding-left:30pt; vertical-align:middle;">
                                                                                              <p style="margin-top:0pt; margin-bottom:0pt; text-align:justify; line-height:15.75pt;"><strong><span style="font-family:'Segoe UI'; font-size:10.5pt; color:#333333;">La finalidad del estudio</span></strong><span style="font-family:'Segoe UI'; font-size:10.5pt; color:#333333;">&nbsp;es identificar las nuevas exigencias que plantea el ejercicio profesional a los egresados y las egresadas de nivel licenciatura, como consecuencia de las transformaciones econ&oacute;micas, sociales y tecnol&oacute;gicas, nutriendo con esta informaci&oacute;n a nuestros planes y programas de estudio.</span></p>
                                                                                              <p style="margin-top:0pt; margin-bottom:0pt; text-align:justify; line-height:15.75pt;"><br></p>
                                                                                              <p style="margin-top:0pt; margin-bottom:0pt; text-align:justify; line-height:15.75pt;"><span style="font-family:'Segoe UI'; font-size:10.5pt; color:#333333;">Una vez contestada la encuesta le agradecer&iacute;amos que nos lo informara v&iacute;a correo electr&oacute;nico a&nbsp;</span><a href="mailto:vinculacionexalumnos@exalumno.unam.mx" target="_blank" style="text-decoration:none;"><strong><u><span style="font-family:'Segoe UI'; font-size:10.5pt; color:#002b7a;">vinculacionexalumnos@exalumno.unam.mx</span></u></strong></a><span style="font-family:'Segoe UI'; font-size:10.5pt; color:#333333;">&nbsp;o dando click en el siguiente bot&oacute;n:</span></p>
                                                                                          </td>
                                                                                      </tr>
                                                                                      <tr style="height:27pt;">
                                                                                          <td style="padding-top:7.5pt; padding-bottom:7.5pt; vertical-align:middle;">
                                                                                              <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:12pt;"><a style="background-color:#b39648;color:white;font-size:16px;font-family:Helvetica,Arial,sans-serif;text-decoration:none;border-radius:6px;line-height:20px;font-weight:normal;white-space:nowrap;padding:8px 12px;border:1px solid transparent" href="mailto:vinculacionexalumnos@exalumno.unam.mx?subject=Encuesta%20Realizada&body=He%20dado%20click%20en%20el%20bot%C3%B3n%20%22Finalizar%20y%20Enviar%22%20de%20la%20encuesta%20que%20me%20solicitaron%20contestar.%0a%0aCualquier%20duda%20o%20comentario%20escr%C3%ADbelo%20aqu%C3%AD:" target="_blank">INFORMA QUE YA HAS LLENADO LA ENCUESTA</a></p>
                                                                                          </td>
                                                                                      </tr>
                                                                                  </tbody>
                                                                              </table>
                                                                          </td>
                                                                      </tr>
                                                                  </tbody>
                                                              </table>
                                                          </td>
                                                      </tr>
                                                      <tr>
                                                          <td style="padding-top:15pt; padding-right:15pt; padding-left:15pt; vertical-align:middle; background-color:#ffffff;">
                                                              <table cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                                                                  <tbody>
                                                                      <tr>
                                                                          <td style="width:420pt; vertical-align:middle;">
                                                                              <table cellspacing="0" cellpadding="0" style="width:100%; border-collapse:collapse;">
                                                                                  <tbody>
                                                                                      <tr>
                                                                                          <td style="padding-top:45pt; padding-right:45pt; padding-left:45pt; vertical-align:middle;">
                                                                                              <h3 style="margin-top:0pt; margin-bottom:0pt; text-align:center; line-height:13.5pt;"><span style="font-family:'Segoe UI'; font-size:9pt; font-weight:normal; color:#333333;">Cualquier duda o aclaraci&oacute;n comun&iacute;quese al&nbsp;</span><span style="font-family:'Segoe UI'; font-size:9pt; color:#333333;">55 5622 6056</span><span style="font-family:'Segoe UI'; font-size:9pt; font-weight:normal; color:#333333;">&nbsp;con Martha Nava, de lunes a viernes, de 9:30 a 18:30 horas. O al correo electr&oacute;nico&nbsp;</span><a href="mailto:vinculacionexalumnos@exalumno.unam.mx" style="text-decoration:none;"><u><span style="font-family:'Segoe UI'; font-size:9pt; color:#000000;">vinculacionexalumnos@exalumno.unam.mx</span></u></a><span style="font-size:13.5pt; font-weight:normal;">&nbsp;</span></h3>
                                                                                              <p style="margin-top:0pt; margin-bottom:0pt; line-height:15.75pt;"><span style="font-family:Arial; font-size:10.5pt; color:#333333;">&nbsp;</span></p>
                                                                                          </td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                          <td style="vertical-align:middle;">
                                                                                              <h1 style="margin-top:0pt; margin-bottom:0pt; text-align:center; line-height:15.75pt;"><span style="font-family:'Segoe UI'; font-size:10.5pt; color:#002b7a;">VISITE NUESTRA P&Aacute;GINA:</span></h1>
                                                                                          </td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                          <td style="padding-top:3.75pt; padding-bottom:11.25pt; vertical-align:middle;">
                                                                                              <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:12pt;"><a style="background-color:#1a16f0;color:rgb(194, 151, 32);font-size:16px;font-family:Helvetica,Arial,sans-serif;text-decoration:none;border-radius:6px;line-height:20px;font-weight:normal;white-space:nowrap;padding:8px 12px;border:1px solid transparent" href="https://www.pveaju.unam.mx/encuesta/01/seguimiento2024/" target="_blank">PVEAJU.UNAM.MX/SEGUIMIENTO</a></p>
                                                                                          </td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                            <td style="padding-top:22.5pt; padding-bottom:7.5pt; vertical-align:middle;">
                                                                                                <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; line-height:15.75pt;"><span style="font-family:Arial; font-size:8.5pt; color:#002b7a;">Te invitamos a revisar nuestro aviso de privacidad en&nbsp;</span></p>
                                                                                                <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; line-height:15.75pt;"><a href="https://www.pveaju.unam.mx/aviso-de-privacidad.php" style="text-decoration:none;"><u><span style="font-family:Arial; font-size:8.5pt; color:#4472c4;">https://www.pveaju.unam.mx/aviso-de-privacidad.php</span></u></a></p>
                                                                                                <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; line-height:15.75pt;"><span style="font-family:Arial; font-size:8.5pt; color:#002b7a;">&nbsp;</span></p>
                                                                                                <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; line-height:15.75pt;"><span style="font-family:Arial; font-size:8.5pt; color:#002b7a;">AGRADECEMOS SU PARTICIPACI&Oacute;N</span></p>
                                                                                            </td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                            <td>
                                                                                                <img src="cid:PVEAJU-footer" alt="PVEAJU-footer">
                                                                                            </td>
                                                                                      </tr>
                                                                                  </tbody>
                                                                              </table>
                                                                          </td>
                                                                      </tr>
                                                                  </tbody>
                                                              </table>
                                                          </td>
                                                      </tr>
                                                      <tr>
                                                          <td style="padding-top:15pt; padding-right:15pt; padding-left:15pt; vertical-align:middle; background-color:#ffffff;">
                                                              <table cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                                                                  <tbody>
                                                                      <tr>
                                                                          <td style="width:420pt; vertical-align:middle;">
                                                                              <table cellspacing="0" cellpadding="0" style="width:100%; border-collapse:collapse;">
                                                                                  <tbody>
                                                                                      <tr>
                                                                                          <td style="vertical-align:middle;">
                                                                                          </td>
                                                                                      </tr>
                                                                                  </tbody>
                                                                              </table>
                                                                          </td>
                                                                      </tr>
                                                                  </tbody>
                                                              </table>
                                                          </td>
                                                      </tr>
                                                  </tbody>
                                              </table>
                                          </div>
                                      </td>
                                  </tr>
                              </tbody>
                          </table>
                      </div>
                  </td>
              </tr>
          </tbody>
      </table>
    </div>
    <p><br style="clear:both; mso-break-type:section-break;"></p>
    <div>
        <p style="margin-top:0pt; margin-bottom:0pt;">&nbsp;</p>
    </div>
  </body>
</html>
"""

# Record the MIME types of both parts - text/plain and text/html.
    msg.attach(MIMEText(html, 'html'))

# Attach parts into message container.
# According to RFC 2046, the last part of a multipart message, in this case
# the HTML message, is best and preferred.

    with open('img/correo/invitacion/PVEAJU-mail-header.png', 'rb') as img_file:
      imgheader = MIMEImage(img_file.read())
      imgheader.add_header('Content-ID', '<PVEAJU-header>')  # Referencia para el HTML
      imgheader.add_header('Content-Disposition', 'inline', filename='PVEAJU-header.jpg')
      msg.attach(imgheader)

    with open('img/correo/invitacion/PVEAJU-mail-footer.png', 'rb') as img_file:
      imgfooter = MIMEImage(img_file.read())
      imgfooter.add_header('Content-ID', '<PVEAJU-footer>')  # Referencia para el HTML
      imgfooter.add_header('Content-Disposition', 'inline', filename='PVEAJU-footer.jpg')
      msg.attach(imgfooter)

# Send the message via local SMTP server.
    mail = smtplib.SMTP('smtp.gmail.com', 587)

    mail.ehlo()

    mail.starttls()

    mail.login('vinculacionexalumnos@exalumno.unam.mx', 'programa')
    mail.sendmail(me, you, msg.as_string())
    mail.quit()
nombre=str(sys.argv[1])
email=str(sys.argv[2])
cuenta=str(sys.argv[3])
carrera=str(sys.argv[4])
plantel=str(sys.argv[5])
link=str(sys.argv[6])
AvisoPrivacidad(nombre,email,cuenta,carrera,plantel,link)