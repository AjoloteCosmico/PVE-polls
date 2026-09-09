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
        background-color: #f4f7fa;
        padding: 24px 20px;
        border-top: 1px solid #e5e9ef;
        margin-top: 10px;
    }

    .item-link {
        color: #015190;
        font-weight: bold;
        text-decoration: none;
    }

    h1 {
        color: #015190;
        font-size: 24px;
        margin-bottom: 5px;
    }

    .sender-name {
        color: #B7812C;
        font-weight: bold;
        margin-bottom: 20px;
    }

    /* Pequeños ajustes de seguridad para clientes problemáticos */
    .interest-section img {
        -ms-interpolation-mode: bicubic;
    }
    .container { max-width: 800px; margin: 0 auto; background: #fff; padding: 20px; border-radius: 8px; }
        h1 { color: #2c3e50; text-align: center; }
    .periodo { text-align: center; color: #7f8c8d; margin-bottom: 30px; }
    .cards { display: flex; justify-content: space-around; margin-bottom: 30px; flex-wrap: wrap; }
    .card { background: #f8f9fa; border-radius: 8px; padding: 15px; min-width: 120px; text-align: center; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin: 5px; flex: 1; }
    .card-number { font-size: 28px; font-weight: bold; color: #2c3e50; }
    .card-label { font-size: 14px; color: #7f8c8d; }
    .card-blue .card-number { color: #2980b9; }
    .card-green .card-number { color: #27ae60; }
    .card-orange .card-number { color: #e67e22; }

    table { width: 100%; border-collapse: collapse; margin: 20px 0; }
    th { background: #173d83; color: white; padding: 10px; text-align: center; }
    td { padding: 8px; border: 1px solid #ddd; text-align: center; }
    tr:nth-child(even) { background: #f9f9f9; }
    .footer-row td { background: #173d83; color: white; font-weight: bold; }

    /* Gráfico de barras horizontal */
    .chart-container { margin: 30px 0; }
    .chart-bar { display: flex; align-items: center; margin-bottom: 6px; }
    .chart-label { width: 160px; font-size: 13px; text-align: right; padding-right: 10px; }
    .chart-bar-bg { flex: 1; background: #e9ecef; height: 24px; border-radius: 4px; overflow: hidden; }
    .chart-bar-fill { height: 100%; background: #2980b9; border-radius: 4px; transition: width 0.3s; }
    .chart-value { width: 40px; text-align: center; font-size: 13px; font-weight: bold; margin-left: 5px; }
</style>
</head>
<body style="background-color: #f4f4f4; margin: 0; padding: 20px;">
    <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border-collapse: collapse;">
        <!-- CABECERA (Imagen con bordes superiores redondeados) -->
        <tr>
            <td align="center">
                <img src="{{'https://www.pveaju.unam.mx/encuesta/01/seguimiento_egresados_UNAM/img/mail_sources/'.$header_image}}" alt="Cabecera" style="width: 100%; display: block; border: 0;">
            </td>
        </tr>

        <!-- CUERPO DE LA CÁPSULA -->
        <tr>
            <td class="capsule-body">
                <h1> {{ $encabezado }}</h1>
                <p class="sender-name">De: {{ $remitente }}</p>

            {{--     <!-- TEXTO GRANDE CON ICONO -->
                <table width="100%" cellpadding="0" cellspacing="0" style="margin: 30px 0;">
                    <tr>
                        <td width="80" valign="middle">
                            
                            <img src="{{ $message->embed(public_path('img\correo\logo.png')) }}" width="80" style="display: block;">
                        </td>
                        <td style="font-size: 22px; font-weight: bold; color: #B7812C; line-height: 1.2;">
                           <!-- aqui iria el texto destacado -->
                        </td>
                    </tr>
                </table> --}}
                

                <!-- CONTENIDO DINÁMICO -->
                <div style="font-size: 16px; line-height: 1.6; margin-bottom: 30px;">
                    @yield('content')

                    <br>
                    <a href="https://www.pveaju.unam.mx/encuesta/01/seguimiento_egresados_UNAM"> 👉🏾 visita la página del seguimiento</a>
                </div>

                <!-- SECCIÓN: PODRÍA INTERESARTE -->
@if(isset($intereses) && count($intereses) > 0)
<div class="interest-section">
    <p style="font-weight: bold; color: #015190; margin: 0 0 18px 0; font-size: 16px;">
        Te podría interesar:
    </p>

    <table width="100%" cellpadding="0" cellspacing="0" border="0" role="presentation">
        @foreach(array_chunk($intereses, 2) as $pair)
        <tr>
            @foreach($pair as $item)
            <td width="50%" valign="top" style="padding: 8px;">
                <!-- CARD -->
                <table width="100%" cellpadding="0" cellspacing="0" border="0" role="presentation"
                       style="background-color: #ffffff; border: 1px solid #e8e8e8; border-radius: 10px; overflow: hidden;">
                    <tr>
                        <td style="padding: 14px 14px 10px 14px; text-align: center;">
                            @if(!empty($item['image']))
                                <img src="{{ $item['image'] }}"
                                     width="140"
                                     alt=""
                                     style="display: block; width: 140px; max-width: 100%; height: auto; border-radius: 8px; margin: 0 auto;">
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 0 14px 16px 14px; text-align: center;">
                            <div style="font-size: 13.5px; line-height: 1.4; color: #333333; margin-bottom: 8px;">
                                {{ $item['text'] }}
                            </div>
                            <a href="{{ $item['link'] }}"
                               class="item-link"
                               style="display: inline-block; font-size: 13px; font-weight: bold; color: #015190; text-decoration: none;">
                                Ver más →
                            </a>
                        </td>
                    </tr>
                </table>
            </td>
            @endforeach

            {{-- Si queda un item solo, completamos la fila --}}
            @if(count($pair) === 1)
            <td width="50%" style="padding: 8px;"></td>
            @endif
        </tr>
        @endforeach
    </table>
</div>
@endif

        <!-- PIE DE PÁGINA (Imagen con bordes inferiores redondeados) -->
        <tr>
            <td align="center">
                <img src="{{'https://www.pveaju.unam.mx/encuesta/01/seguimiento_egresados_UNAM/img/mail_sources/'.$footer_image}}" alt="Pie de página" style="width: 100%; display: block; border: 0;">
            </td>
        </tr>
        <img src="{{'https://encuestas.pveaju.unam.mx/track/'.$tracking_uuid }}" alt="" width="1" height="1" style="display:none; width:1px; height:1px;">
    </table>
</body>
</html>