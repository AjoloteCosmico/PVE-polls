@extends('layouts.app')
@section('content')
@php
use \App\Http\Controllers\ComponentController; 
@endphp
<div> 
        <div class="titulos">
            <h1>ENCUESTA DE SEGUIMIENTO NIVEL POSGRADO UNAM</h1>
        </div>
        
    <div  id='datos'>  @include('posgrado.personal_data') </div>
<form action="">
    <div class="posgrado_reactivos">
    
     @foreach($Reactivos as $reactivo)
        @php
            $opciones = \App\Models\Option::where('clave_reactivo', $reactivo->clave)->get();
        @endphp
        <div class="react_container">
        <h3>{{$reactivo->orden}}.- {{$reactivo->description}}</h3>
        {{ComponentController::RenderReactive($reactivo,$opciones)}}
        </div>
     @endforeach
    </div>
</form>
</div>
@stop

@push('css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital@0;1&display=swap" rel="stylesheet">
    
<style>
    *{
    font-family: "Montserrat", sans-serif;
}

/*estilos de texto*/

/*titulo*/
h1{
    font-weight: bolder;
    font-size: 30px;
    color: white;
}

/*subtitulo azul*/
h2{
    font-size: 24px;
    color: #002b7a;
    font-weight: bolder;
    padding-left: 10%;
}

/*subtitulo blanco*/
h3{
    font-size: 20px;
    color: white;
    font-weight: bolder;
    margin: 0;
}


/*texto*/
h6{
    font-size: 16px;
    color: white;
    font-weight: 500;
}

a{
    font-weight: 700;
    font-size: 12pt;
    color: #00183f;
    text-align: none;
}

hr{
    background-color: #ba800d;
    width: 100px;
    height: 10px;
    border-radius: 3px;
    margin: auto;
}

/*estilo de tablas*/
table{
    table-layout: fixed;
    width: 80%;
    border-collapse: collapse;
    border: 2px solid #000b1b;
    background-color: white;
}
th{
    border: 2px solid #000b1b;
    text-align: center;
    background-color: #000b1b;
    color: white;
}
td{
    border: 2px solid #000b1b;
    text-align: center;
    background-color: white;
    padding: 8px;
    font-weight: 600;
}

/*estilos de boton*/
.boton-oscuro{
    background-color: #000b1b;
    border: none;
    border-radius: 6px;
    padding: 5px;
    color: white;
    font-weight: 800;
    font-size: 14px;
}
.boton-oscuro:hover{
    background-color: #002b7a;
}

.boton-borde{
    margin-top: 10px;;
    background-color: transparent;
    border: 1px solid white;
    border-radius: 6px;
    color: white;
}
.boton-borde:hover{
    background-color: rgba(255, 255, 255, 0.664);
    color: #000b1b;
}

.boton-borde-oscuro{
    margin-top: 10px;;
    background-color: transparent;
    border: 1px solid #000b1b;
    border-radius: 6px;
    color: #000b1b;
}
.boton-borde-oscuro:hover{
    background-color: #000b1b94;
    color: #ffffff;
}

.boton-dorado{
    background-color: #ba800d;
    border: none;
    border-radius: 6px;
    color: white;
    font-size: 14px;
    font-weight: 800;
    padding: 6px;
}
.boton-dorado:hover{
    background-color: #002b7a;
}

.boton-azul{
    background-color: #002b7a;
    color: white;
    padding: 6px;
    border-radius: 8px;
    border: none;
}
.boton-azul:hover{
    background-color: #ba800d;
}

.boton-muestras{
    background-color: #002b7a;
    color: white;
    padding: 25px;
    padding-left: 60px;
    padding-right: 60px;
    border-radius: 8px;
    border: none;
}
.boton-muestras:hover{
    background-color: #ba800d;
}

/*Form controls*/
input{
    border-radius: 6px;
    border: none;
    width: 350px;
    padding: 10px;
    text-align: center;
    font-size: 16px;
    font-weight: 800;
    color: #000b1b;
    margin: 10px;
    background-color: white;
}

select{
    border-radius: 6px;
    border: none;
    width: 350px;
    padding: 10px;
    text-align: center;
    font-size: 16px;
    font-weight: 800;
    color: black;
    margin: 10px;
    background-color: white;
}
.select-selected:after {
   color: black;
}
option{
    font-size: 16px;
    font-weight: 800;
    color: black;
}
/*estilo de contenedores*/
div{
    background-color: #050a30;
}
.titulos{
    padding-top: 50px;
    text-align: center;
    margin-bottom: 50px;
    margin-top: 50px;
}

.subtitulo{
    padding-top: 50px;
    margin-bottom: 50px;
    margin-top: 50px;
    background-color: transparent;
}

.botones-inicio{
    margin: auto;
    width: 80%;
    display: flex;
    justify-content: space-between;
}
.aviso{
    background-color: #ba800d;
    width: 80%;
    border-radius: 10px;
    margin: auto;
    margin-top: 30px;
    display: flex;
    align-items: center;
}

.cuadro-azul{
    background-color: #002b7a;
    border-radius: 10px;
    width: 60%;
    padding-top: 20px;
    padding-bottom: 50px;
    margin-top: 30px;
    margin: auto;
}

.cuadro-amarillo{
    background-color: #ba800d;
    margin-left: 30px;
    max-width: 92%;
    border-radius: 10px;
    padding-top: 10px;
    padding-bottom: 10px;
    padding-left: 20px;
    margin-top: px;
    margin-bottom: 30px;
}

.posgrado_reactivos{
    width:100%;
    display: flex;
    flex-wrap: wrap;
    align-content: flex-start;
    align-items: flex-start;
    flex-direction: row;
    margin-top: 50px;
}
.react_container{
    padding:0.7vw;
    max-width: 30%;
    margin:0.7vw;
    border: 2px solid white;
    border-radius:20px;
}
.tabla{
    display: grid;
    place-items: center;
    background-color: transparent;
}

.elementos-centrados{
    display: grid;
    place-items: center;
}

.codigos-color{
    display: grid;
    place-items: center;
    margin: auto;
    margin-top: 50px;
    margin-bottom: 50px;
    width: 80%;
    border: 1px solid #ffffff;
    border-radius: 15px;
    padding: 20px;
}

.degradado{
    background-image: linear-gradient(#b8b8b8 15%, #ffffff 70%, #b8b8b8 );
}

#amarillo{
    height: 20px;
    width: 40px;
    background-color: #f0da19;
    margin: 10px;
}
#gris{
    height: 20px;
    width: 40px;
    background-color: #979797;
    margin: 10px;
}
#rojo{
    height: 20px;
    width: 40px;
    background-color: #b61d1d;
    margin: 10px;
}
#azul{
    height: 20px;
    width: 40px;
    background-color: #1e95c4;
    margin: 10px;
}
#morado{
    height: 20px;
    width: 40px;
    background-color: #8b1db6;
    margin: 10px;
}
#naranja{
    height: 20px;
    width: 40px;
    background-color: #e45b0c;
    margin: 10px;
}
</style>
@endpush