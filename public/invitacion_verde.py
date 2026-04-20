import smtplib

from email.mime.multipart import MIMEMultipart
from email.mime.text import MIMEText
from email.mime.image import MIMEImage
from email.mime.base import MIMEBase
from email import encoders
import sys
import os


def enviar_encuesta(nombre, correo, cuenta, carrera, plantel, link):
    remitente = "vinculacionexalumnos@exalumno.unam.mx"
    destinatario = correo
    
    # Crear el mensaje
    msg = MIMEMultipart('related')
    msg['Subject'] = "Invitación a Encuesta de Empleabilidad Verde"
    msg['From'] = remitente
    msg['To'] = destinatario
    
    # Cuerpo del mensaje
    html = f"""\
        <html>
        <body style="font-family: 'Montserrat', sans-serif; text-align: center;">
        <img src="cid:header_img" alt="Cabecera" style="width: 100%; display: block; border: 0;">
        
        <h2 style="margin-top: 20px; font-size: 3vw; color:#3373BB; text-align: left;">Estimado Egresado</h2>
        <p style="font-size: 3vw; color:#8DAF00; text-align: left;">{nombre}</p>
        <p style="font-size: 2vw; color:#283C9D; text-align: left;"><strong>Número de cuenta:</strong> {cuenta}</p>  
        <p style="font-size: 2vw; color:#283C9D; text-align: left;"><strong>Plantel:</strong> {plantel}</p>
        <p style="font-size: 2vw; color:#283C9D; text-align: left;"><strong>Carrera:</strong> {carrera}</p>
        <br>
        
       
        
        <div style="text-align: justify; font-size: 2vw; width:100%;">
        
             En el marco de la participación anual de la <strong style="color: #3373BB;">Universidad Nacional Autónoma de México</strong>, en el <strong style="color: #3373BB;">UI GreenMetric World University Rankings</strong>; sistema de evaluación internacional que compara los esfuerzos de las universidades en beneficio de la sustentabilidad, y en colaboración con la Dirección General de Atención a la Comunidad, te invitamos a participar en la <strong style="color: #3373BB;">Encuesta: Empleabilidad verde</strong>, la cual, nos permitirá obtener información valiosa sobre el impacto de la inserción laboral de los egresados, en los ámbitos profesionales relacionados con el medio ambiente y la sustentabilidad.<br><br>
        Tu participación contribuirá no solo a posicionar mejor a nuestra universidad en este importante ranking, sino también a fortalecer la formación de profesionistas conscientes de los retos sociales y ambientales.<br><br>
        De antemano, agradecemos el tiempo dedicado a contestar este breve cuestionario (2 minutos aproximadamente).
        
        </div>
        <br>
        <p>
            <a href="{link}" target="_blank" 
               style="background-color:#8DAF00; color:white; padding: 15px 22px; text-decoration: none; border-radius: 22px; font-size: 2vw;">
               Ir a la Encuesta
            </a>
        </p>
        <br>
        <img src="cid:footer_img" alt="Pie" style="width: 100%; display: block; border: 0;">
    </body>
    </html>
     """
     
     
    msg.attach(MIMEText(html, 'html'))
    
    # Adjuntar Imágenes CID (Header/Footer)
    for cid, path in [('header_img', 'img/correo/invitacion/cabecera_verde.jpg'), ('footer_img', 'img/correo/invitacion/pie_verde.jpg')]:
        try:
            with open(path, 'rb') as f:
                img = MIMEImage(f.read())
                img.add_header('Content-ID', f'<{cid}>')
                msg.attach(img)
        except FileNotFoundError:
            print(f"Imagen no encontrada: {path}")
            
    #Banner        
    try:
        with open('img/correo/invitacion/Banner.png', "rb") as adjunto:
            parte = MIMEBase('image', 'png')
            parte.set_payload(adjunto.read())
            encoders.encode_base64(parte)
            parte.add_header(
                'Content-Disposition',
                f'attachment; filename= {os.path.basename("img/correo/invitacion/Banner.png")}',
            )
            msg.attach(parte)
    except FileNotFoundError:
        print(f"Error: El archivo Banner.png no fue encontrado.")


    # SMTP
    try:
        servidor = smtplib.SMTP('smtp.gmail.com', 587)
        servidor.starttls()
        servidor.login('vinculacionexalumnos@exalumno.unam.mx', 'mfdd bsjr yiku wahf')
        servidor.sendmail(remitente, destinatario, msg.as_string())
        servidor.quit()
        return True
    except Exception as e:
        print(f"Error SMTP: {e}")
        return False
    
if __name__ == '__main__':
    nombre = sys.argv[1]
    correo = sys.argv[2]
    cuenta = sys.argv[3]
    carrera = sys.argv[4]
    plantel = sys.argv[5]
    link = sys.argv[6]
    
enviar_encuesta(nombre, correo, cuenta, carrera, plantel, link)