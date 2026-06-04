@extends('layouts.app')

@section('content')
    <div class="contenedor-inicio">
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
               @can('ver_graficas')
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
    const randomMessage = ['¡Que tengas un excelente día!', '¡Sigue haciendo un gran trabajo!', '¡Eres increíble!', '¡Gracias por tu dedicación!', '¡Tu esfuerzo es apreciado!','Eres Fabulos@','Hoy tendrás un gran dia','Los egresados te adoran!'];
    const messageElement = document.getElementById('random-message');
    function showRandomMessage() {
        const randomEmoji = randomEmojis[Math.floor(Math.random() * randomEmojis.length)];
        const randomMsg = randomMessage[Math.floor(Math.random() * randomMessage.length)];
        messageElement.textContent = `${randomEmoji} ${randomMsg}`;
    }
    showRandomMessage();
});
</script>

 @endpush