import smtplib

from email.mime.multipart import MIMEMultipart
from email.mime.text import MIMEText
from email.mime.image import MIMEImage
import sys
import os


def enviar_encuesta(nombre, correo, cuenta, carrera, plantel, link):
    remitente = "vinculacionexalumnos@exalumno.unam.mx"
    destinatario = correo
    
    # Crear el mensaje
    msg = MIMEMultipart('related')
    msg['Subject'] = "Invitación a Encuesta de Egresados 2021"
    msg['From'] = remitente
    msg['To'] = destinatario
    
    # Cuerpo del mensaje
    html = f"""\
        <html>
    <body style="font-family: 'Montserrat', sans-serif; text-align: center;">

         <!-- CABECERA CON IMAGEN -->
        <img src="cid:header_img" alt="Cabecera PVE" style="width: 100%; display: block; margin: 0; padding: 0; border: 0;">
        
        
        <h2 style="margin-top: 20px; font-size: 20px; color:#015190; text-align: left;">Estimado Egresado</h2>
        <p style="font-size: 18px; color:#015190;">{nombre}</p>
        <p style="font-size: 16px; color:#015190; text-align: left;"><strong>Número de cuenta:</strong> {cuenta}</p>
        <p style="font-size: 16px; color:#015190; text-align: left;"><strong>Facultad:</strong> {plantel}</p>
        <p style="font-size: 16px; color:#015190; text-align: left;"><strong>Carrera:</strong> {carrera}</p><br>
        <br>
        <img src="cid:imagen_encuesta" alt="Encuesta UNAM" style="max-width: 100%; height: auto;"><br>
        
         <p>
            <a href="{link}" target="_blank" style="background-color:#BA800D; color:white; padding: 15px 22px; text-decoration: none; border-radius: 5px;">Ir a la encuesta</a>
        </p>
        
        <!-- Enlaces (versión compatible con correos) -->
        <table style="width: 100%; margin-top: 20px; margin-bottom: 20px;">
        <tr>
            <td style="text-align: left;">
                <a href="http://www.pveaju.unam.mx/avisodeprivacidad" target="_blank" style="font-size: 14px; color: #015190; text-decoration: underline;">
                    Aviso de Privacidad
                </a>
            </td>
            <td style="text-align: right;">
                <a href="https://www.pveaju.unam.mx/" target="_blank" style="font-size: 14px; color: #015190; text-decoration: underline;">
                    Sitio Oficial PVEAJU
                </a>
            </td>
        </tr>
        </table>
        
         <!-- FOOTER -->
        <br><br>
        <img src="cid:footer_img" alt="Pie de seguimiento" style="width: 100%; display: block; margin: 0; padding: 0; border: 0;">
    </body>
    </html>
    """
    
    msg.attach(MIMEText(html, 'html'))
    
    # Adjuntar la imagen principal
    with open('img/correo/invitacion/Encuesta2021.png', 'rb') as img_file:
        imagen = MIMEImage(img_file.read())
        imagen.add_header('Content-ID', '<imagen_encuesta>')
        imagen.add_header('Content-Disposition', 'inline', filename='Encuesta2021.png')
        msg.attach(imagen)
        
    # Adjuntar la imagen de cabecera
    with open('img/correo/invitacion/Cabecera_Seguimiento.png', 'rb') as img_file:
        header_img = MIMEImage(img_file.read())
        header_img.add_header('Content-ID', '<header_img>')
        header_img.add_header('Content-Disposition', 'inline', filename='Cabecera_Seguimiento.png')
        msg.attach(header_img)
    
    # Adjuntar la imagen de pie de página
    with open('img/correo/invitacion/Pie_seguimiento.png', 'rb') as img_file:
        footer_img = MIMEImage(img_file.read())
        footer_img.add_header('Content-ID', '<footer_img>')
        footer_img.add_header('Content-Disposition', 'inline', filename='Pie_seguimiento.png')
        msg.attach(footer_img)
        
    # Configuración del servidor SMTP
    servidor = smtplib.SMTP('smtp.gmail.com', 587)
    servidor.starttls()
    servidor.login('vinculacionexalumnos@exalumno.unam.mx', 'mfdd bsjr yiku wahf')
    servidor.sendmail(remitente, destinatario, msg.as_string())
    servidor.quit()
    
#leer argumentos de la línea de comandos
if __name__ == '__main__':
    nombre = sys.argv[1]
    correo = sys.argv[2]
    cuenta = sys.argv[3]
    carrera = sys.argv[4]
    plantel = sys.argv[5]
    link = sys.argv[6]
    
enviar_encuesta(nombre, correo, cuenta, carrera, plantel, link)

#ESPECIFICAR LA IMAGEN PRINCIPAL EL NOMBREEEEEE

