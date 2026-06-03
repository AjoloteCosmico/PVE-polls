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
<br><br><br>


<br>
</div>
@endsection

@push('css')
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
    const randomEmojis = ['😀', '😃', '😄', '😁', '😆', '🙂', '🙃', '😉', '😊', '😇', '🥰', '😍', '🤩'];
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