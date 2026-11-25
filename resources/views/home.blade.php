@extends('layouts.app')

@section('content')
    <div class="contenedor-inicio">
        @if(config('app.countdown_visible'))
        <div id="countdown-widget" aria-live="polite">
            <div class="countdown-title">Faltan para el 11 de diciembre</div>
            <div class="countdown-digits">
                <div class="countdown-unit">
                    <div id="countdown-days" class="digit-group" aria-label="0 días"></div>
                    <div class="countdown-unit-label">días</div>
                </div>
                <div class="digit-separator">:</div>
                <div class="countdown-unit">
                    <div id="countdown-hours" class="digit-group" aria-label="0 horas"></div>
                    <div class="countdown-unit-label">horas</div>
                </div>
                <div class="digit-separator">:</div>
                <div class="countdown-unit">
                    <div id="countdown-minutes" class="digit-group" aria-label="0 minutos"></div>
                    <div class="countdown-unit-label">minutos</div>
                </div>
                <div class="digit-separator">:</div>
                <div class="countdown-unit">
                    <div id="countdown-seconds" class="digit-group" aria-label="0 segundos"></div>
                    <div class="countdown-unit-label">segundos</div>
                </div>
            </div>
        </div>
        @endif
        <div>
        <div id="message-div">
    <h1>¡Bienvenid@ {{Auth::user()->name }}!</h1><br>
    <h1 id="random-message"> </h1>
    </div>
    <br><br><br>
    <div class="botones-inicio">
        <br><br><br> 
    </div>
       <div class="row"> 
        <div class="col">
            <div class="cuadro-amarillo">
                <h3> Total encuestas 2022:  {{$total22}}</h3>
                <h3> por internet: {{$Internet}} </h3>
            </div>
        </div>
           @can('ver_muestra_posgrado')
        <div class="col">
            <div class="cuadro-amarillo">
                <h3> Total encuestas posgrado:  {{$TotalPos}}</h3>
                <h3> por internet: {{$InternetPos}} </h3>
            </div>
        </div>
        @endcan
        <div class="col">
            <div class="cuadro-amarillo">
                <h3> Total encuestas 2016:   {{$total16}} </h3>
                <h3> por internet: {{$Internet16}} </h3>
            </div>
        </div>
    </div>
    <div class="row">
      <div class="col-12 col-md-6 mb-4">
        <div class="card card-outline card-warning p-3"> <!-- Pastel de avence 2022 -->
            <div class="chart-wrapper-fixed">
                <x-chart-js 
                    id="pie22" 
                    type="doughnut" 
                    title="Avance del estudio seg 2022" 
                    :labels="['Realizadas Internet','Realizadas telef','No realizadas']" 
                    :data="[$Internet,$telefonicas, $requeridas-$Internet-$telefonicas]" 
                    :colors="['#002b7a', 'rgba(52, 152, 219, 0.7)', '#ba800d']"
                />
            </div>
        </div>
    </div>
   @can('ver_muestra_posgrado')
    <div class="col-12 col-md-6 mb-4">
        <div class="card card-outline card-warning p-3"> <!-- Pastel de avence posgrado -->
            <div class="chart-wrapper-fixed">
                <x-chart-js 
                    id="pie_posgrado" 
                    type="doughnut" 
                    title="Avance del estudio posgrado" 
                    :labels="['Realizadas Internet','Realizadas telef','No realizadas']" 
                    :data="[$InternetPos,$telefonicasPos, $requeridasPos-$InternetPos-$telefonicasPos]" 
                    :colors="['#002b7a', 'rgba(52, 152, 219, 0.7)', '#ba800d']"
                />
            </div>
        </div>
    </div>
   @endcan
     <div class="col-12 col-md-6 mb-4">
        <div class="card card-outline card-warning p-3"> <!-- Pastel de avence 2016 -->
            <div class="chart-wrapper-fixed">
                <x-chart-js 
                    id="pie16" 
                    type="doughnut" 
                    title="Avance del estudio act 2016" 
                    :labels="['Realizadas Internet','Realizadas telef','No realizadas']" 
                    :data="[$Internet16,$telefonicas16, $requeridas16-$Internet16-$telefonicas16]" 
                    :colors="['#002b7a', 'rgba(52, 152, 219, 0.7)', '#ba800d']"
                />
            </div>
        </div>
    </div>
     @can('ver_graficas')
    <div class="col-12 col-md-6 mb-4">
        <div class="card card-outline card-warning p-3"> <!-- 2022 encuestas por aplciador -->
            <div class="chart-wrapper-fixed">
                <x-chart-js 
                    id="name22" 
                    type="bar" 
                    title="Cuestionarios por encuestador 2022" 
                    :labels="$chartName22['labels']" 
                    :data="$chartName22['data']" 
                />
            </div>
        </div>
    </div>
    
     <div class="col-12 col-md-6 mb-4">
        <div class="card card-outline card-warning p-3"> <!-- Por tipo de estudio,  apilado por encuestador  -->
            <div class="chart-wrapper-fixed">
                <x-chart-js 
                    id="stackedEnc" 
                    :labels="$stackedEnc['labels']" 
                    :data="$stackedEnc['datasets']" 
                    type="bar" 
                    title="Encuestadores por periodo"
                    :stacked="true"
                />
            </div>
        </div>
        </div>
        <div class="col-12 col-md-6 mb-4">
               
        <div class="card card-outline card-warning p-3"> <!-- Multi serie encuestas por semana historico -->
            <div class="chart-wrapper-fixed">
                <x-chart-js 
                    id="weeklyAll" 
                    :labels="$chartWeeklyAll['labels']" 
                    :data="$chartWeeklyAll['datasets']" 
                    type="line" 
                    title="Encuestas semanales por estudio"
                    :stacked="false"
                />
            </div>
        </div>
    </div>
    @endcan
    </div>
<br><br><br>


<br>
</div>
@endsection

@push('css')

<style>
    /* Forzamos al contenedor a mantener dimensiones rígidas que no rompan el Flexbox de AdminLTE */
    .chart-wrapper-fixed {
        position: relative;
        display: block;
        width: 100% !important;
        height: 500px !important; /* Altura fija para que el canvas no se estire al infinito */
        overflow: hidden;         /* Evita que subelementos desborden el layout principal */
        box-sizing: border-box;
    }

    /* Aseguramos que el componente de Chart.js y su contenedor interno respeten el límite */
    .chart-container-js {
        position: relative;
        height: 100% !important;
        width: 100% !important;
    }

    /* Forzar al Canvas a no romper el bloque */
    .chart-wrapper-fixed canvas {
        display: block;
        width: 100% !important;
        height: 100% !important;
    }
</style>
<style>
    #countdown-widget {
        position: fixed;
        top: 62px;
        right: 24px;
        z-index: 1000;
        min-width: 210px;
        padding: 5px 7px 4px;
        border: 1px solid #1d1d1d;
        border-radius: 5px;
        background: linear-gradient(145deg, #343434, #111 75%);
        box-shadow: 0 4px 9px rgba(0, 0, 0, 0.35), inset 0 0 6px rgba(255, 170, 0, 0.08);
        color: #ffb000;
        text-align: center;
    }

    .countdown-title {
        margin-bottom: 3px;
        color: #f1c27d;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    .countdown-digits {
        display: flex;
        align-items: flex-start;
        justify-content: center;
        gap: 2px;
    }

    .countdown-unit {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .digit-group {
        display: flex;
        gap: 1.5px;
        height: 36px;
    }

    .countdown-unit-label {
        margin-top: 2px;
        color: #f1c27d;
        font-size: 8px;
        font-weight: 700;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    .digit-separator {
        height: 36px;
        color: #ffb000;
        font-family: Consolas, monospace;
        font-size: 26px;
        line-height: 32px;
        text-shadow: 0 0 4px #ff8a00;
    }

    .seven-digit {
        position: relative;
        width: 20px;
        height: 36px;
    }

    .seven-digit span {
        position: absolute;
        background: #2a2114;
        box-shadow: inset 0 0 1px #000;
        transition: background 120ms, box-shadow 120ms;
    }

    .seven-digit span.on {
        background: #ffb000;
        box-shadow: 0 0 4px #ff8a00, 0 0 6px rgba(255, 176, 0, 0.7);
    }

    .seven-digit .a, .seven-digit .g, .seven-digit .d {
        left: 3.5px;
        width: 13px;
        height: 3.5px;
        clip-path: polygon(12% 0, 88% 0, 100% 50%, 88% 100%, 12% 100%, 0 50%);
    }
    .seven-digit .a { top: 0; }
    .seven-digit .g { top: 16px; }
    .seven-digit .d { bottom: 0; }

    .seven-digit .b, .seven-digit .c, .seven-digit .e, .seven-digit .f {
        width: 3.5px;
        height: 14.5px;
        clip-path: polygon(50% 0, 100% 12%, 100% 88%, 50% 100%, 0 88%, 0 12%);
    }
    .seven-digit .f { top: 2px; left: 0; }
    .seven-digit .b { top: 2px; right: 0; }
    .seven-digit .e { bottom: 2px; left: 0; }
    .seven-digit .c { bottom: 2px; right: 0; }

    @media (max-width: 768px) {
        #countdown-widget {
            top: 58px;
            right: 8px;
            min-width: 210px;
            transform: scale(0.78);
            transform-origin: top right;
        }
    }
</style>
<style>
  #message-div {
    position: relative !important; /* Fuerza la posición */
    padding: 40px !important;
    background: rgba(255, 255, 255, 0.1) !important;
    border-radius: 15px !important;
    color: white !important;
    opacity: 0;
    /* Usamos 'forwards' para que se quede visible al terminar */
    animation: fadeIn 2s ease-in-out forwards, glow 3s infinite alternate !important;
  }

  @keyframes fadeIn {
    to { opacity: 1; }
  }

  @keyframes glow {
    from { box-shadow: 0 0 5px #a0c4ff !important; }
    to { box-shadow: 0 0 20px #c4a1ff, 0 0 40px #c4a1ff !important; }
  }

  /* Aseguramos que los pseudo-elementos tengan display */
  #message-div::before, #message-div::after {
    content: "✦" !important;
    position: absolute !important;
    display: block !important;
    color: gold !important;
    animation: sparkle 2s infinite !important;
  }
    @keyframes sparkle {
    0% { transform: scale(0); opacity: 0; }
    50% { transform: scale(1.5); opacity: 1; }
    100% { transform: scale(0); opacity: 0; }
  }
  /* ... resto del CSS igual ... */
</style>


@endpush

@push('js')
<script>
    document.addEventListener('DOMContentLoaded', () => {
    const randomEmojis = ['😀', '😃', '😄', '😁', '🙂', '😉', '😊', '😇', '🥰', '😍', '🤩', '🌻','🌄🌞'];
    const randomMessage = ['¡Que tengas un excelente día!', '¡Sigue haciendo un gran trabajo!', 
    '¡Eres increíble!', '¡Gracias por tu dedicación!', '¡Tu esfuerzo es apreciado!','Eres Fabulos@',
    'Hoy tendrás un gran dia','Los egresados te adoran!','Los egresados te temen más a ti que tu a ellos','Tu voz es tu poder ;)'];
    const messageElement = document.getElementById('random-message');
    function showRandomMessage() {
        const randomEmoji = randomEmojis[Math.floor(Math.random() * randomEmojis.length)];
        const randomMsg = randomMessage[Math.floor(Math.random() * randomMessage.length)];
        messageElement.textContent = `${randomEmoji} ${randomMsg}`;
    }
    showRandomMessage();
});
</script>

 @if(config('app.countdown_visible'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const target = new Date({!! json_encode(str_replace(' ', 'T', config('app.countdown_target'))) !!});
            const segmentMap = {
                '0': 'abcdef', '1': 'bc', '2': 'abdeg', '3': 'abcdg',
                '4': 'bcfg', '5': 'acdfg', '6': 'acdefg', '7': 'abc',
                '8': 'abcdefg', '9': 'abcdfg'
            };

            function createDigit(value) {
                const digit = document.createElement('div');
                digit.className = 'seven-digit';
                ['a', 'b', 'c', 'd', 'e', 'f', 'g'].forEach(segment => {
                    const bar = document.createElement('span');
                    bar.className = segment;
                    if ((segmentMap[value] || '').includes(segment)) bar.classList.add('on');
                    digit.appendChild(bar);
                });
                return digit;
            }

            function renderValue(id, value, length, label) {
                const group = document.getElementById(id);
                if (!group) return;

                const text = String(value).padStart(length, '0');
                group.replaceChildren(...[...text].map(createDigit));
                group.setAttribute('aria-label', value + ' ' + label);
            }

            function updateCountdown() {
                const remainingMilliseconds = target.getTime() - Date.now();

                let days = 0, hours = 0, minutes = 0, seconds = 0;
                if (Number.isFinite(target.getTime()) && remainingMilliseconds > 0) {
                    const remainingSeconds = Math.floor(remainingMilliseconds / 1000);
                    days = Math.floor(remainingSeconds / 86400);
                    hours = Math.floor((remainingSeconds % 86400) / 3600);
                    minutes = Math.floor((remainingSeconds % 3600) / 60);
                    seconds = remainingSeconds % 60;
                }

                renderValue('countdown-days', days, 2, 'días');
                renderValue('countdown-hours', hours, 2, 'horas');
                renderValue('countdown-minutes', minutes, 2, 'minutos');
                renderValue('countdown-seconds', seconds, 2, 'segundos');
            }

            updateCountdown();
            window.setInterval(updateCountdown, 1000);
        });
    </script>
    @endif
 @endpush