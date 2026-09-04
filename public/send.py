import os
import base64
import pickle
from email.mime.text import MIMEText
from google.auth.transport.requests import Request
from google.oauth2.credentials import Credentials
from google_auth_oauthlib.flow import InstalledAppFlow
from googleapiclient.discovery import build

SCOPES = ['https://www.googleapis.com/auth/gmail.send']

def authenticate_gmail():
    creds = None

    if os.path.exists("token.pickle"):
        with open("token.pickle", "rb") as token:
            creds = pickle.load(token)

    if not creds or not creds.valid:
        if creds and creds.expired and creds.refresh_token:
            creds.refresh(Request())
        else:
            flow = InstalledAppFlow.from_client_secrets_file("credentials.json", SCOPES)

            # 🔹 Para servidores remotos sin navegador:
            creds = flow.run_local_server(port=8080, open_browser=False)

        with open("token.pickle", "wb") as token:
            pickle.dump(creds, token)

    return creds

def send_email(to, subject, message):
    creds = authenticate_gmail()
    service = build('gmail', 'v1', credentials=creds)

    msg = MIMEText(message)
    msg['to'] = to
    msg['subject'] = subject
    raw_msg = base64.urlsafe_b64encode(msg.as_bytes()).decode()

    message = {'raw': raw_msg}
    send_message = service.users().messages().send(userId="me", body=message).execute()
    print(f"📨 Correo enviado correctamente, ID: {send_message['id']}")

if __name__ == "__main__":
    destinatario = "felmiquiztli@gmail.com"
    asunto = "Correo de prueba desde servidor"
    contenido = "Este es un correo enviado desde Python en un servidor remoto."
    send_email(destinatario, asunto, contenido)

