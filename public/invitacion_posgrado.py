import smtplib
import xlsxwriter
import pandas as pd
import re

from email.mime.multipart import MIMEMultipart
from email.mime.text import MIMEText
from email.mime.image import MIMEImage
from email.mime.base import MIMEBase
from email import encoders
import sys
import os

def validar_correo(correo):
    if pd.isna(correo):
        return False
    # Expresión regular para validar el formato del correo electrónico
    patron = r"^[^@ \t\r\n]+@[^@ \t\r\n]+\.[a-zA-Z]{2,}$"
    return re.match(patron, correo.strip()) is not None


#Nota: podemos quitar correo2 de la funcion enviar_encuesta, ya que no se usa 
def enviar_encuesta(nombre, cuenta, plan, programa, correo1, correo2 ):
    remitente = "VINCULACION EGRESADOS UNAM <vinculacionexalumnos@exalumno.pve.unam.mx>"
    destinatario = correo1
    
    # Crear el mensaje
    msg = MIMEMultipart('related')
    msg['Subject'] = "Invitación a Encuesta de Seguimiento de Posgrado"
    msg['From'] = remitente
    msg['To'] = destinatario
    
    # Cuerpo del mensaje
    html = f"""\
        <html>
    <body style="font-family: 'Montserrat', sans-serif; text-align: center;">

         <!-- CABECERA CON IMAGEN -->
        <img src="cid:header_img" alt="Cabecera PVE" style="width: 100%; display: block; margin: 0; padding: 0; border: 0;">
        
        
        <h2 style="margin-top: 20px; font-size: 2vw; color:#015190; text-align: left;">Estimado Egresado</h2>
        <p style="font-size: 3vw; color:#B7812C;">{nombre}</p>
        <p style="font-size: 2vw; color:#B7812C; text-align: left;"><strong>Número de cuenta:</strong> {cuenta}</p>
        <p style="font-size: 2vw; color:#B7812C; text-align: left;"><strong>Facultad:</strong> {programa}</p>
        <p style="font-size: 2vw; color:#B7812C; text-align: left;"><strong>plan:</strong> {plan}</p><br>
        <br>
        
         <!-- IMAGEN CON LINK -->
         <a href="https://encuestas.pveaju.unam.mx/encuesta_posgrado" target="_blank" style="text-decoration: none;">
            <img src="cid:imagen_encuesta" alt="Encuesta UNAM" 
            style="max-width: 100%; height: auto; border: 0;">
        </a><br>
        
         
        
         <!-- FOOTER -->
        <br><br>
        <img src="cid:footer_img" alt="Pie de seguimiento" style="width: 100%; display: block; margin: 0; padding: 0; border: 0;">
    </body>
    </html>
    """
    
    #Usee table en los enlaces para asegurar que se vean bien en todos los clientes de correo
    
    msg.attach(MIMEText(html, 'html'))
    
    # Adjuntar la imagen principal
    with open('img/correo/invitacion/ENCUESTA POSGRADO_CUERPO.jpg', 'rb') as img_file:
        imagen = MIMEImage(img_file.read(), _subtype='jpeg')
        imagen.add_header('Content-ID', '<imagen_encuesta>')
        imagen.add_header('Content-Disposition', 'inline', filename='posgrado.jpg')
        msg.attach(imagen)
        
    # Adjuntar la imagen de cabecera
    with open('img/correo/invitacion/ENCUESTA POSGRADO_CABECERA.jpg', 'rb') as img_file:
        header_img = MIMEImage(img_file.read(), _subtype='jpeg')
        header_img.add_header('Content-ID', '<header_img>')
        header_img.add_header('Content-Disposition', 'inline', filename='Cabecera_posgrado.jpg')
        msg.attach(header_img)
        
    # Adjuntar la imagen de pie de página
    with open('img/correo/invitacion/ENCUESTA POSGRADO_PIE.jpg', 'rb') as img_file:
        footer_img = MIMEImage(img_file.read(), _subtype='jpeg')
        footer_img.add_header('Content-ID', '<footer_img>')
        footer_img.add_header('Content-Disposition', 'inline', filename='Pie_posgrado.jpg')
        msg.attach(footer_img)
        
    
     # ADJUNTAR UN ARCHIVO (BANNER)


    try:
        with open('imagenes/Banner_POSGRADO.jpg', "rb") as adjunto:
            # Crear un objeto MIMEBase para el archivo adjunto
            parte = MIMEBase('application', 'octet-stream')
            parte.set_payload(adjunto.read())
            
        # Codificar el archivo en Base64
        encoders.encode_base64(parte)
        
        # Agregar el encabezado 'Content-Disposition' para que el cliente de correo lo reconozca como adjunto
        parte.add_header(
            'Content-Disposition',
            f'attachment; filename= {os.path.basename("Banner_POSGRADO.jpg")}',
        )
        
        # Adjuntar la parte al mensaje
        msg.attach(parte)
        
    except FileNotFoundError:
        print(f"Error: El archivo no fue encontrado.")
        
        
    # Configuración del servidor SMTP
    servidor = smtplib.SMTP('exalumno.pve.unam.mx', 587)
    servidor.starttls()
    servidor.login('vinculacionexalumnos@exalumno.pve.unam.mx', 'programa')
    servidor.sendmail(remitente, destinatario, msg.as_string())
    servidor.quit()
#leer argumentos de la línea de comandos
if __name__ == '__main__':
    nombre = sys.argv[1]
    correo = sys.argv[2]
    cuenta = sys.argv[3]
    plan = sys.argv[4]
    programa = sys.argv[5]
    link = sys.argv[6]

    enviar_encuesta(nombre, correo, cuenta, plan, programa, link)
        
        
        
