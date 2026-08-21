<!DOCTYPE html>
<html>
<head>
    <style>
        .capsule-body {
            background-color: #ffffff;
            padding: 20px 40px;
            color: #333333;
            font-family: 'Montserrat', Helvetica, Arial, sans-serif;
        }
        .interest-section {
            background-color: #f8f9fa;
            padding: 20px;
            border-top: 1px solid #eeeeee;
        }
        .item-link { color: #015190; font-weight: bold; text-decoration: none; }
        h1 { color: #015190; font-size: 24px; margin-bottom: 5px; }
        .sender-name { color: #B7812C; font-weight: bold; margin-bottom: 20px; }
    </style>
</head>
<body style="background-color: #f4f4f4; margin: 0; padding: 20px;">
    <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border-collapse: collapse;">
        <!-- CABECERA (Imagen con bordes superiores redondeados) -->
        <tr>
            <td align="center">
                <img src="{{ $message->embed(public_path('imagenes/header_rounded.png')) }}" alt="Cabecera" style="width: 100%; display: block; border: 0;">
            </td>
        </tr>

        <!-- CUERPO DE LA CÁPSULA -->
        <tr>
            <td class="capsule-body">
                <h1>{{ $encabezado }}</h1>
                <p class="sender-name">De: {{ $remitente }}</p>

                <!-- TEXTO GRANDE CON ICONO -->
                <table width="100%" cellpadding="0" cellspacing="0" style="margin: 30px 0;">
                    <tr>
                        <td width="80" valign="middle">
                            <img src="{{ $message->embed(public_path('imagenes/icon_main.png')) }}" width="60" style="display: block;">
                        </td>
                        <td style="font-size: 22px; font-weight: bold; color: #B7812C; line-height: 1.2;">
                            {{ $texto_destacado }}
                        </td>
                    </tr>
                </table>

                <!-- CONTENIDO DINÁMICO -->
                <div style="font-size: 16px; line-height: 1.6; margin-bottom: 30px;">
                    @yield('content')
                </div>

                <!-- SECCIÓN: PODRÍA INTERESARTE -->
                @if(isset($intereses) && count($intereses) > 0)
                <div class="interest-section">
                    <p style="font-weight: bold; color: #015190; margin-bottom: 15px;">Te podría interesar:</p>
                    @foreach($intereses as $item)
                    <table width="100%" style="margin-bottom: 10px;">
                        <tr>
                            @if(isset($item['image']))
                            <td width="50">
                                <img src="{{ $item['image'] }}" width="40" style="border-radius: 4px;">
                            </td>
                            @endif
                            <td>
                                <div style="font-size: 14px;">
                                    {{ $item['text'] }} <br>
                                    <a href="{{ $item['link'] }}" class="item-link">Ver más →</a>
                                </div>
                            </td>
                        </tr>
                    </table>
                    @endforeach
                </div>
                @endif
            </td>
        </tr>

        <!-- PIE DE PÁGINA (Imagen con bordes inferiores redondeados) -->
        <tr>
            <td align="center">
                <img src="{{ $message->embed(public_path('imagenes/footer_rounded.png')) }}" alt="Pie de página" style="width: 100%; display: block; border: 0;">
            </td>
        </tr>
    </table>
</body>
</html>