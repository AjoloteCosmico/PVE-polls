@extends('layouts.app')
@section('content')
@php
use \App\Http\Controllers\ComponentController; 
@endphp
{{-- {{session('logs')}} --}}

@include('encuesta.seg20.modal_create_telefono')
@include('encuesta.seg20.modal_create_correo')
@include('empresas.modal_create', ['typeStudy' => 'act'])
<div> 
        <div class="titulos">
            <h1>ENCUESTA DE ACTUALIZACION GEN 2016 UNAM</h1>
        </div>
    <div  id='datos' style=" position: fixed; top: 0px; left: flex ">  @include('encuesta.personal_data_16') </div>
    <form action="{{ url('encuestas/2016/update/'. $Encuesta->registro) }}" method="POST" enctype="multipart/form-data" id='forma_sagrada' name='forma'>
    @csrf
    <input type="hidden" value="" name="btn_pressed" id="btn-pressed">
    <br><br>
@foreach($Secciones as $section)
     <h1> Sección {{$section['number']}} : {{$section['desc']}}</h1>
    <br>
     <div class="posgrado_reactivos">
     @foreach($Reactivos->whereIn('section',[$section['letter'],'act'.$section['letter'],'tact'.$section['letter']])->sortBy('act_order') as $reactivo)
        @php
            $opciones = \App\Models\Option::where('reactivo', $reactivo->clave)->get();
        @endphp
        @if($reactivo->type=='label')r
        <br>
            <div class="label_container" id="{{'container'.$reactivo->clave}}"  style="width:90%">
                <h3>{{$reactivo->description}} </h3>
            </div>
            <br>
        @else
            <div class="react_container" id="{{'container'.$reactivo->clave}}" >    
            <h3>{{$reactivo->act_order}}.- @if($reactivo->act_description) {{$reactivo->act_description}} @else {{$reactivo->description}} @endif {{$reactivo->clave}}</h3>
            @php $field_presenter=$reactivo->clave @endphp
              @if($reactivo->clave=='ncr2') 
                    <div class="row" style="display:flex; justify-content:flex-start;"> 
                        <div class="col col-lg-10">
                            {{ComponentController::RenderReactive($reactivo,$opciones,$Encuesta->$field_presenter)}}
                        </div>
                            @can('crear_empresa_encuesta')
                            <div class="col col-lg-2"> 
                                <button class="btn boton-dorado w-10" data-toggle="modal"  onclick="update_empresa_form()" data-target="#empresaModal" type="button"> <i class="fas fa-plus-circle fa-xl"></i>&nbsp; Nueva  </button>
                            </div>
                            @endcan
                        <div class="col">
                        </div>
                    </div>
                   <div class="resultados-div" id="resultados"></div>
                @else 
                    {{ComponentController::RenderReactive($reactivo,$opciones,$Encuesta->$field_presenter)}}
                @endif
            </div>
        @endif
     @endforeach
     </div>
     @endforeach

    <div class="posgrado_reactivos">

    </div>
    <div style="display:flex; flex-direction: row-reverse; padding:1.2vw" class='fixed'> <button   style="font-size:1.9vw; padding:1.4vw" type="button" onclick="send_form('guardar')" class="boton-azul">
<i class="fas fa-save fa-xl"></i>   Guardar
 </button></div>
</form>
</div>

@stop

@push('css')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital@0;1&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
    *{
    font-family: "Montserrat", sans-serif;
}

.fixed {
    position:fixed;
    bottom:0;
    right:0;
  width: 10.0vw;
  height: 6.0vw;
  display: flex;
  justify-content: center;
  align-items: center;
  box-shadow: 0 0 6px #000;
  color: #fff;
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
    background-color:rgb(1, 42, 103);
    color: white;
}
td{
    border: 2px solid #000b1b;
    text-align: center;
    background-color: white;
    padding: 8px;
    font-weight: 600;
}

.table-personal{
    th{
    border: 2px solid #000b1b;
    text-align: center;
    background-color: #002b7a;
    color: white;
}
td{
    border: 2px solid #000b1b;
    text-align: center;
    background-color: white;
    padding: 8px;
    font-weight: 600;
}
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
    padding: 2.3vw;
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
input:disabled {
    background-color:#979797 !important; 
    color: #666;
    cursor: not-allowed;
}
textarea{
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
    max-width: 8.5vw;
    min-width: 7.5vw;
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


        /* 2. Estilos para el contenedor principal de Select2 */
    /* Select2 reemplaza el <select> original, por eso apuntamos a su contenedor */
    .select2-container--default .select2-selection--single {
        /* Aquí aplicamos la mayoría de tus estilos de apariencia */
        border-radius: 6px;
        border: none;
        background-color: white;
        margin: 10px; /* Aplica el margen al contenedor para el espaciado */
        height: auto; /* Permite que el padding determine la altura */
    }

    /* 3. Estilos para el texto y padding dentro del Select2 */
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        /* El texto seleccionado y el placeholder van aquí */
        padding: 10px 10px; /* El padding que tenías en el select */
        text-align: center;
        text-justify: center;
        font-size: 16px !important; /* El tamaño de letra que deseas */
        font-weight: 800 !important;
        color: black !important;
        /* El ancho del contenedor, que es lo más complicado con Select2 y unidades vw */
        /* La propiedad width se debe pasar como opción en el JS, pero podemos darle un ancho mínimo y máximo al contenedor si es necesario. */
        width: 100%;
        min-width: 7.5vw;
    }

    /* 4.Para el cuadro de búsqueda dentro del desplegable */
    .select2-container .select2-search--dropdown .select2-search__field {
        font-size: 16px; /* Un tamaño más pequeño para el campo de búsqueda */
        padding: 5px;
    }
    /* Estilos para el texto de cada opción dentro del menú desplegable de Select2 */
.select2-container--default .select2-results__option {
    /* Aplicamos tus estilos de fuente */
    font-size: 16px !important; 
    font-weight: 800 !important; 
    color: black !important; 
    
    /* Opcional: Para mejorar el espaciado si lo necesitas */
    padding: 8px 12px;
}
.select2-results__options  {
    height: 450px; /* <--- Esta es la clave para el "largo" de la cajita */
    overflow-y: auto;  /* Asegura que aparezca la barra de scroll si las opciones exceden el max-height */
}

/* Opcional: Estilo para la opción que está siendo resaltada (hover) */
.select2-container--default .select2-results__option--highlighted.select2-results__option--selectable {
    background-color: #3875d7 !important; /* Puedes cambiar este color */
    color: white !important; /* El color de letra al hacer hover */
}
    option { 
        font-size: 16px; 
        font-weight: 800; 
        color: black; 
    }
/* --- Estilos para el Componente Rating de Estrellas --- */

.rating-stars-container {
    display: flex; /* Muestra las opciones en línea */
    align-items: flex-end; /* Alinea las bases de las estrellas para el efecto progresivo */
    gap: 15px; /* Espacio entre cada opción de estrella */
    padding: 15px 0;
    color: white; 
}

.rating-option-wrapper {
    display: flex;
    flex-direction: column; /* Estrella y descripción apiladas */
    align-items: center; /* Centra la estrella y la descripción */
    min-width: 60px; /* Ancho mínimo para la descripción */
    align-self:start;
}

/* Ocultar el radio button nativo */
.rating-input {
    /* Clases para ocultar visualmente el input (si usas Tailwind, usa 'sr-only') */
    position: absolute;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    overflow: hidden;
    clip: rect(0, 0, 0, 0);
    white-space: nowrap;
    border-width: 0;
}

/* Estilo de la Estrella (La etiqueta <label>) */
.rating-star {
    cursor: pointer;
    color: #ffffffff; /* Color de estrella sin seleccionar (gris) */
    transition: color 0.2s ease, font-size 0.2s ease;
    line-height: 1; /* Para que el tamaño de fuente controle la altura */
    position: relative;
    
}

/* Color de la estrella seleccionada */
.rating-input:checked + .rating-star {
    color: gold;
}

/* Color al pasar el ratón (hover) */
.rating-star:hover {
    color: orange;
}

/* --- Tamaños Progresivos para el Efecto de Escalado --- */

/* Los tamaños serán progresivamente mayores basados en el índice */
.star-size-1 { font-size: 20px; }
.star-size-2 { font-size: 24px; }
.star-size-3 { font-size: 28px; }
.star-size-4 { font-size: 32px; }
.star-size-5 { font-size: 36px; }
.star-size-6 { font-size: 40px; }
/* ... añade más si tienes más de 6 opciones ... */


/* Estilo de la Descripción */
.rating-description {
    margin-top: 5px;
    font-size: 10px; /* Letra pequeña para la descripción debajo */
    text-align: center;
    color: #ffffffff;
}

/* Ocultar el tooltip por defecto */
.rating-star::after, 
.rating-star::before {
    visibility: hidden;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.3s ease;
}

/* El cuadro del tooltip (el contenido) */
.rating-star::after {
    content: attr(data-tooltip); /* Toma el texto del nuevo atributo data-tooltip */
    position: absolute;
    bottom: 100%; /* Lo coloca encima de la estrella */
    left: 50%;
    transform: translateX(-50%);
    
    /* TU ESTILO REQUERIDO: Fondo Negro y Letra Blanca */
    background-color: black; 
    color: white; 
    
    padding: 5px 10px;
    border-radius: 4px;
    white-space: nowrap; /* Evita que el texto se rompa */
    font-size: 14px; /* Un tamaño de letra legible para el tooltip */
    z-index: 10; /* Asegura que esté por encima de otros elementos */
}

/* El pequeño "triángulo" debajo del tooltip (opcional) */
.rating-star::before {
    content: '';
    position: absolute;
    top: -5px; /* Lo pone justo debajo del tooltip::after */
    left: 50%;
    transform: translateX(-50%);
    border: 5px solid transparent;
    border-top-color: black; /* Color de fondo del tooltip */
    z-index: 9;
}

/* Mostrar el tooltip al hacer hover sobre la estrella */
.rating-star:hover::after,
.rating-star:hover::before {
    visibility: visible;
    opacity: 1;
}

/*estilo de contenedores*/
div{
    background-color: #050a30;
}
.resultados-div{
    padding: 5px;
    text-align: center;
    font-size: 20px;
    font-weight: 800;
    color: white;
    margin: 5px;
    background-color: white !important;
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
 .fade{
        background-color: rgba(14, 21, 68, 0.6) !important;  
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
    margin-top: 10px;
    margin-bottom: 30px;
}

.posgrado_reactivos{
    width:100%;
    display: flex;
    flex-wrap: wrap;
    align-content: stretch;
    align-items: stretch;
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
.label_container{
    padding:0.7vw;
    width: 80%;
    margin:0.7vw;
    border: 2px solid white;
    bold: bolder;
    border-radius:20px;
    background-color:rgb(8, 16, 71);
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

@keyframes fadeIn {
  0% { background-color: rgba(255, 255, 0, 0.5); }
  100% { background-color: transparent; }
}

.highlight {
  animation: fadeIn 1.5s ease-in;
}
</style>

@endpush

@push('js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
function send_form(value){
    document.getElementById('btn-pressed').value=value;
    document.getElementById('forma_sagrada').submit();
}
</script>

@include('posgrado.scripts_bloquear')

@if(session('status')=='incompleta')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript">
  Swal.fire({
  title: "Encuesta Incompleta",
  text: "faltan  respuestas",
  icon: "warning",
});
</script>
<script>
    console.log('falta {{session('falta')}}');
    document.getElementById('{{session('falta')}}').style="border: 0.3vw  solid red";
    document.getElementById('{{session('falta')}}').focus();
</script>
@endif


<script>
function setValueWithEffect(element, value) {
    console.log('setting value');
  // Quitar la clase si ya existe
  element.classList.remove('highlight');
  
  // Forzar reinicio de la animación (truco de reflow)
  void element.offsetWidth;
  
  // Asignar el nuevo valor
  element.value = value;
  
  // Aplicar el efecto
  element.classList.add('highlight');
}
 const searchBox = document.getElementById('ncr2');
const resultadosDiv = document.getElementById('resultados');

searchBox.addEventListener('input', function(e) {
    const searchTerm = e.target.value;
    
    if (searchTerm.length < 2) {
        resultadosDiv.innerHTML = '';
        return;
    }

    // Enviar solicitud AJAX
    fetch(`/search_empresa?q=${encodeURIComponent(searchTerm)}`)
        .then(response => response.json())
        .then(data => {
            resultadosDiv.innerHTML = '';
            data.forEach(item => {
                
                const nombre = item.nombre.replace(/'/g, "\\'").replace(/"/g, '&quot;');
                resultadosDiv.innerHTML += `<div onclick="rellenar_empresa('${nombre}','${item.sector}','${item.clave_giro}','${item.giro_especifico}')"> ${item.nombre} ${item.giro_especifico.substring(0,6)}</div>`;
            });
        })
        .catch(error => console.error('Error:', error));
});

function rellenar_empresa(nombre,sector,giro,giro_esp){

    // document.getElementById('ncr2').value=nombre;
    // document.getElementById('ncr3').value=sector;
    // document.getElementById('ncr4').value=giro;
    // document.getElementById('giro_especifico').value=giro_esp;

    setValueWithEffect(document.getElementById('ncr2'), nombre);
    setValueWithEffect(document.getElementById('ncr3'), sector);
    // setValueWithEffect(document.getElementById('ncr4'), giro);
     $('#ncr4').val(giro).trigger('change');
    // setValueWithEffect(document.getElementById('giro_especifico'), giro_esp);
    console.log('se ha seleccionado una empresa',sector,giro);
    resultadosDiv.innerHTML = '';
}

function update_empresa_form(){
    nombre=document.getElementById('ncr2').value;
    sector=document.getElementById('ncr3').value;
    rama=document.getElementById('ncr4').value;
    // giro=document.getElementById('giro_especifico').value;
    document.getElementById('nombre_empresa').value=nombre;
    document.getElementById('rama').value=rama;
    document.getElementById('sector').value=sector;
    // document.getElementById('giro_modal').value=giro;
}

document.addEventListener('DOMContentLoaded', function () {
    
    const ner1 = document.getElementById('ner1');

    if (ner1) {
        ner1.addEventListener('change', function () {
            if (this.value === '1') { // Si el usuario elige "Sí"
                const reactivosObjetivo = ['ner2', 'ner3', 'ner4', 'ner5', 'ner6', 'ner7', 'ner7int', 'ner7_a'];

                reactivosObjetivo.forEach(id => {
                    const select = document.getElementById(id);
                    if (select && !select.value) {
                        select.value = '2'; // Forzar "No"
                    }
                });
            }
        });
    }


@if($Encuesta->ncr24!=14)
    checkBloqueos('ncr24');
@endif
@if($Encuesta->ncr22==2)
    checkBloqueos('ncr22');
@endif
checkBloqueos('nfr27');

    // Si ya hay valor en ncr2, intenta obtener la empresa y rellenar
    const ncr2 = document.getElementById('ncr2');
    if (ncr2 && ncr2.value.trim().length >= 2) {
        fetch(`/search_empresa?q=${encodeURIComponent(ncr2.value.trim())}`)
        .then(response => response.json())
        .then(data => {
            if (data.length > 0) {
                const item = data[0]; // asumimos el primer match
                rellenar_empresa(item.nombre, item.sector, item.clave_giro, item.giro_especifico);
            }
        })
        .catch(error => console.error('Error al buscar empresa al cargar:', error));
    }

    });
</script>
<script>
    $(document).ready(function() {
    // 1. Obtener el número de opciones
   
            // 3. Inicializar Select2 en el select deseado
             $('.select2-searchable').select2({
                // Opciones opcionales de Select2, por ejemplo, el placeholder:
                placeholder: "Selecciona o busca una opción...",
                allowClear: true,
                width: '100%' // Asegura que tome todo el ancho del contenedor
            });
        
});
</script>

@endpush