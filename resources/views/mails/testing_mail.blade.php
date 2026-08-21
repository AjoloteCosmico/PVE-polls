<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información de cuenta</title>
</head>
<body style="font-family: Arial, sans-serif; background:#f5f5f5; padding:20px;">
    <div style="max-width:600px; margin:0 auto; background:#ffffff; border-radius:8px; padding:30px;">
        <h2 style="color:#333;">Hola {{ $nombre }},</h2>

        <p style="font-size:16px; color:#555;">
            Te informamos que tu número de cuenta es:
        </p>

        <p style="font-size:22px; font-weight:bold; color:#1f2937; text-align:center;">
            {{ $numeroCuenta }}
        </p>

        <p style="color:#555;">
            Gracias por tu confianza.
        </p>

        <p style="color:#777; font-size:12px;">
            Este correo fue enviado automáticamente por el sistema.
        </p>
    </div>
</body>
</html>