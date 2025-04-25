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
    msg['Subject'] = "Invitación a Encuesta de Egresados 2020"
    msg['From'] = remitente
    msg['To'] = destinatario
    
    # Cuerpo del mensaje
    html = f"""\
        <html>
    <body style="font-family: 'Montserrat', sans-serif; text-align: center;">

         <!-- CABECERA CON IMAGEN -->
        <img src="cid:header_img" alt="Cabecera PVE" style="width: 100%; display: block; margin: 0; padding: 0; border: 0;">
        
        
        <h2 style="color:black;">Hola {nombre},</h2>
        <p style="color:black;">Te invitamos a responder la Encuesta de Egresados 2020 de la UNAM.</p>
        <p style="color:black;"><strong>Número de cuenta:</strong> {cuenta}</p>
        <p style="color:black;"><strong>Facultad:</strong> {plantel}</p>
        <p style="color:black;"><strong>Carrera:</strong> {carrera}</p>
        <p>
            <a href="{link}" target="_blank" style="background-color:  #002B7A; color: white; padding: 15px 22px; text-decoration: none; border-radius: 5px;">Ir a la encuesta</a>
        </p>
        <br>
        <img src="cid:imagen_encuesta" alt="Encuesta UNAM" style="max-width: 100%; height: auto;">
    </body>
    </html>
    """
    
    msg.attach(MIMEText(html, 'html'))
    
    # Adjuntar la imagen principal
    with open('img/correo/invitacion/Encuesta2020.jpg', 'rb') as img_file:
        imagen = MIMEImage(img_file.read())
        imagen.add_header('Content-ID', '<imagen_encuesta>')
        imagen.add_header('Content-Disposition', 'inline', filename='Encuesta2020.jpg')
        msg.attach(imagen)
        
    # Adjuntar la imagen de cabecera
    with open('img/correo/invitacion/Cabecera_Seguimiento.png', 'rb') as img_file:
        header_img = MIMEImage(img_file.read())
        header_img.add_header('Content-ID', '<header_img>')
        header_img.add_header('Content-Disposition', 'inline', filename='Cabecera_Seguimiento.png')
        msg.attach(header_img)
        
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

