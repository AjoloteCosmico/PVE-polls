@extends('layouts.app')

@section('content')

<div class="container-fluid"  background="{{asset('img/Fondo2.jpg')}}" id='cuerpo' style="scroll-behavior: smooth;">

<div style="padding:30px;" id='datos'>
    <h1 class="text-white-50">
                 @if(!is_null($Encuesta->cuenta))
                 COMPLETAR ENCUESTA 2014 @else
                 HACER NUEVA ENCUESTA 2014 @endif </h1>
        <h1 class="text-white-50"> </h1>
        <div >  
        <table class="table text-xl">
          <TR>
            <td>Egresad@: </td>
            <td> {{$Encuesta->nombre}} {{$Encuesta->paterno}} {{$Encuesta->materno}} </td>
          </TR>
          
          <tr><td>Carrera:</td><td> {{$Carrera}}  </td> </tr>
          <tr><td>Plantel:</td><td> {{$Plantel}}</td> </tr>
        </table>
        <br>
       
        </div>
    </div>
   <!-- aqui se va a mostrar la encuesta -->
    <div  > <nav class="navbar navbar-light bg-light">
  <a class="navbar-brand" href="#" onClick="unhide('A')" id='Abtn'> <p id='Atxt'>Seccion A</p></a>
  <a class="navbar-brand" href="#" onClick="unhide('B')" id='Bbtn'><p id='Btxt'>Seccion B</p></a>
  <a class="navbar-brand" href="#" onClick="unhide('C')" id='Cbtn'><p id='Ctxt'>Seccion C</p></a>
  <a class="navbar-brand" href="#" onClick="unhide('D')" id='Dbtn'><p id='Dtxt'>Seccion D</p></a>
  <a class="navbar-brand" href="#" onClick="unhide('E')" id='Ebtn'><p id='Etxt'>Seccion E</p></a>
  <a class="navbar-brand" href="#" onClick="unhide('F')" id='Fbtn'><p id='Ftxt'>Seccion F</p></a>
  <a class="navbar-brand" href="#" onClick="unhide('G')" id='Gbtn'><p id='Gtxt'>Seccion G</p></a>
</nav>
</div>
<form action="{{ route('encuestas14.real_update', $Encuesta->registro) }}" method="POST" enctype="multipart/form-data" id='forma_sagrada' name='forma'>
@csrf
<input type="text" value='{{$Encuesta->cuenta}}' name='cuenta' hidden>
    <div class='Scroll'> 
     
   
      <div class='col' id='A' style='text-align: center;'>
      <h1 class="seccion">DATOS PERSONALES</h1>

      <h2 class="reactivo">FECHA EN QUE SE CAPTURA </h2> 
    <!--------FECHA DE NACIMIENTO-->
    <center>
    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
        <input type="radio" class="btn-check" name="btnradio" id="btnradioa" autocomplete="off" checked onclick="automatico();">
        <label class="btn btn-outline-danger" for="btnradioa">fecha<br> actual</label>
        <input type="radio" class="btn-check" name="btnradio" id="btnradiob" autocomplete="off" onclick="manual();">
        <label class="btn btn-outline-danger" for="btnradiob">fecha <br> anterior </label>
        </div>
        </center> <br>
        <center> <div class="form-group" id="fecha-group" style="display:none;">
       
          
          <input type="date"  class="fecha" name="fec_capt" id="fec_capt"  value="2023-01-01" style="width : 30%;"/> 
          </div></center>
          
          <h2 class="reactivo">1.-  Teléfono de casa</h2> 
 <INPUT type="text" class="texto"   id="telcasa" size="12" maxlength="15"  name="telcasa" value="{{$Encuesta->telcasa}}">

 
<h2 class="reactivo">2.-Teléfono  Celular: </h2>
<INPUT type="text" class="texto"  id="teltra"   size="12" maxlength="13"  name="teltra" value="{{$Encuesta->teltra}}">

Extensión: 
 <INPUT type="text" class="texto" id="exttra" size="5" maxlength="5" name="exttra"  value="{{$Encuesta->exttra}}" >

<h2 class="reactivo">3.- ¿Tiene correo electrónico?</h2>  

<select class="select" id="ncrcc" name="ncrcc"  onchange="bloquear('ncrcc',[2],[correo,nar1_a])" >
<option value="" ></option>
        <option  selected  value='1'>Sí</option>
        <option value='2'  >No</option> 
</select>
<div name="correo" id="correo">
  <br>
  <h2 class="reactivo">3a).-Cúal es su correo : </h2>

<INPUT type="text" class="texto"  id="nar1_a" name="nar1_a" size="39" maxlength="39" value="{{$Encuesta->nar1_a}}"  >
</div>
          <h2 class="reactivo">4.- Estado civil:</h2>
           
            <select class="select"  id="nar8" name="nar8" onchange="bloquear('nar8',[1],[nar11,nar11a,nar14,nar14otra])" > 
            <option value="" selected></option>
			<option value=1  @if($Encuesta->nar8==1) selected @endif>Soltero(a)</option>
			<option value=2 @if($Encuesta->nar8==2) selected @endif>Casado(a)</option>
			<option value=3 @if($Encuesta->nar8==3) selected @endif>Divorciado(a)</option>
			<option value=4 @if($Encuesta->nar8==4) selected @endif>Unión Libre</option>
			<option value=5 @if($Encuesta->nar8==5) selected @endif>Viudo(a)</option>
             </select>
             <h2 class="reactivo"> 5.- ¿Tiene hijos?</h2>
         
         <select class="select" id="nar9" name="nar9"  onchange="bloquear('nar9',[2],[nar9adiv,nar10])" >
         <option value="" selected></option>
        <option value='1' @if($Encuesta->nar9==1) selected @endif>Sí</option>
        <option value='2'@if($Encuesta->nar9==2) selected @endif>No</option> 
</select>
<div name = "nar9adiv" id="nar9adiv">
<h2 class="reactivo">a).- ¿Cuántos?: </h2></div>
<input class="texto" type="text"  id="nar10" name="nar10" size="2" maxlength="2" @if(strlen($Encuesta->nar10)>1) value="{{$Encuesta->nar10}}" @else value="0" hidden @endif> 


  <div name="nar11div" id="nar11div"  >
    <h2 class="reactivo"> 6.- Nivel de estudios de su esposo(a)</h2>
 
      <select class="select" id="nar11" name="nar11"   onchange="bloquear('nar11',[1,2,3,4,5,6,7,8,9,10,11,12],[nar11a])"  >
     <option value=""></option>
      <option value=1 @if($Encuesta->nar11==1) selected @endif >Sin instrucción</option>
      <option value=2 @if($Encuesta->nar11==2) selected @endif >Primaria</option;n>
      <option value=3 @if($Encuesta->nar11==3) selected @endif >Carrera técnica o comercial después de primaria</option>
      <option value=4 @if($Encuesta->nar11==4) selected @endif >Secundaria</option>
      <option value=5 @if($Encuesta->nar11==5) selected @endif >Escuela Normal</option>
      <option value=6 @if($Encuesta->nar11==6) selected @endif >Carrera técnica o comercial después de secundaria</option>
      <option value=7 @if($Encuesta->nar11==7) selected @endif >Bachillerato o vocacional</option>
      <option value=8 @if($Encuesta->nar11==8) selected @endif >Esc. Normal Superior</option>
      <option value=9 @if($Encuesta->nar11==9) selected @endif >Carrera técnica o com. después de bachillerato</option>
      <option value=10 @if($Encuesta->nar11==10) selected @endif >Licenciatura</option>
      <option value=11 @if($Encuesta->nar11==11) selected @endif >Posgrado</option>
      <option value=12 @if($Encuesta->nar11==12) selected @endif >Lo desconoce</option>
      <option value=13  @if($Encuesta->nar11==13) selected @endif >Otro (Especifíque)</option>
      <option value=0  hidden></option> 
    </select>
Otra:<input type="text" class="texto"   id="nar11a" name="nar11a" size="50" maxlength="50" @if(strlen($Encuesta->nar11a)>2) value="{{$Encuesta->nar11a}}" @else value="" hidden @endif > 

  
<h2 class="reactivo">7.-Ocupación de su esposo(a)</h2>

<select class="select" id="nar14" name="nar14"  onchange="bloquear('nar14',[19,20,23,24,27,30,31,32,26,36,37,44,28,25,41,21,35,34,33,22,29,16,39,17,18],[nar14otra])"  >
       <option value="" ></option>
<option value=28 @if($Encuesta->nar14otra==28) selected @endif >Artesanos y obrero</option>
<option value=25 @if($Encuesta->nar14otra==25) selected @endif >Comerciante, empleado en comercios y agente de ventas</option>
<option value=41 @if($Encuesta->nar14otra==41) selected @endif >Conductores de maquinaria móvil terrestre, aérea, marítima, de vías ferreras</option>
<option value=21 @if($Encuesta->nar14otra==21) selected @endif >Funcionario y directivo</option>
<option value=35 @if($Encuesta->nar14otra==35) selected @endif >Finado</option>
<option value=34 @if($Encuesta->nar14otra==34) selected @endif >Jubilado</option>
<option value=33 @if($Encuesta->nar14otra==33) selected @endif >Labores del Hogar</option>
<option value=22 @if($Encuesta->nar14otra==22) selected @endif >Mando medio</option>
<option value=29 @if($Encuesta->nar14otra==29) selected @endif >Obreros especializados</option>
<option value=16 @if($Encuesta->nar14otra==16) selected @endif >Profesionista</option>
<option value=39 @if($Encuesta->nar14otra==39) selected @endif >Profesor Enseñanza Superior</option>
<option value=17 @if($Encuesta->nar14otra==17) selected @endif >Profesor Enseñanza Media Superior</option>
<option value=18 @if($Encuesta->nar14otra==18) selected @endif >Profesor Enseñanza Media</option>
<option value=19 @if($Encuesta->nar14otra==19) selected @endif >Profesor Enseñanza Básica</option>
<option value=20 @if($Encuesta->nar14otra==20) selected @endif >Trabajador del arte, espectáculos y deportes</option>
<option value=23 @if($Encuesta->nar14otra==23) selected @endif >Técnico</option>
<option value=24 @if($Encuesta->nar14otra==24) selected @endif >Trabajador de apoyo actividades administrativas</option>
<option value=27 @if($Encuesta->nar14otra==27) selected @endif >Trabajadores en actividades agricolas, ganaderias, silvícolas y de caza y pesca</option>
<option value=30 @if($Encuesta->nar14otra==30) selected @endif >Trabajador en servicios personales</option>
<option value=31 @if($Encuesta->nar14otra==31) selected @endif >Trabajador en servicios doméstico</option>
<option value=32 @if($Encuesta->nar14otra==32) selected @endif >Trabajador de servicios vigilancia y protección y fuerzas armadas</option>
<option value=26 @if($Encuesta->nar14otra==26) selected @endif >Vendedores ambulantes</option>
<option value=36 @if($Encuesta->nar14otra==36) selected @endif >No trabaja</option>
<option value=37 @if($Encuesta->nar14otra==37) selected @endif >No lo sabe</option>
<option value=44 @if($Encuesta->nar14otra==44) selected @endif >Trabajadores en actividades elementales y de apoyo</option>
<option value=38 @if($Encuesta->nar14otra==38) selected @endif >Otra(Especifíque)</option>
<option value=0  hidden></option>     
</select>
    <br>
(Especifíque)
Otra:<input type="text" class="texto" id="nar14otra" name="nar14otra" size="80" maxlength="80" @if(strlen($Encuesta->nar14otra)>2) value="{{$Encuesta->nar14otra}}" @else hidden value=" " @endif > 
 
  </div>

<br><br>
<div class="container" style=" padding: 14px;
  overflow: hidden;">

</div><br>
      </div>


      <div class='col' id='B' style='text-align: center;'>
      
    <h2 class="reactivo">53.-).- ¿Tiene una segunda Licenciatura?</h2>
 
 <select class="select" id= "ner20"  name="ner20"  onchange="bloquear('ner20',[1],[ner20a,ner20txt])" >
   <option selected="selected" value="">
   <option value=1 @if($Encuesta->NER20==1) selected @endif >No </option>
   <option value=2 @if($Encuesta->NER20==2) selected @endif >Si, la estoy cursando</option>
   <option value=3 @if($Encuesta->NER20==3) selected @endif >Si, ya la concluí</option>
 </select>
 <h2 class="reactivo">54.-).- ¿Cuál? </h2>
 <INPUT class="texto" ID="ner20txt" NAME="ner20txt" TYPE=TEXT value="{{$Encuesta->ner20txt}}" SIZE=35 MAXLENGTH=35 @if($Encuesta->NER20==1) hidden value=" " @endif>

 <h2 class="reactivo">15b).¿La ejerce?  </h2>
   <select class="select" id="ner20a" name="ner20a" @if($Encuesta->NER20==1) hidden  @endif>
   <option  value="">
   <option value=1 @if($Encuesta->NER20A==1) selected @endif >No</option>
   <option value=2 @if($Encuesta->NER20A==2) selected @endif >Si</option>
   <option value=0  hidden></option>   
  </select>
 <h2 class="reactivo">8).-¿Bajo qué sistema de enseñanza realizó sus estudios de licenciatura? </h2>
 
 <select class="select" id="nar1" name="nar1" >
 <option value="" ></option>
 <option value=1  @if($Encuesta->NAR1==1) selected @endif >Abierto</option>
 <option value=2 @if($Encuesta->NAR1==2) selected @endif >A distancia</option>
 <option value=3 @if($Encuesta->NAR1==3) selected @endif >Presencial</option>
 </select>
 
 </TD>
  </TR>
 
  <TR>
 <TD width='55%'>
 
 

      </div>

      <div class='col' id='C' style='text-align: center;'>
      <h2 class="reactivo">  9.- ¿Actualmente se encuentra laborando? </h2> 
 
    
 <select class="select" id="ncr1" name="ncr1"  onchange='seccionc2()'>
<option selected  value="">Seleccione...</option>
<option value=1 @if($Encuesta->NCR1==1) selected @endif>Sí (permanente)</option>
<option value=2 @if($Encuesta->NCR1==2) selected @endif>Sí (eventual)</option>
<option value=3 @if($Encuesta->NCR1==3) selected @endif>No (Sin buscar trabajo), (pase a la 42)</option>
<option value=4 @if($Encuesta->NCR1==4) selected @endif>No (En búsqueda de trabajo), (pase a la 42)</option>
<option value=5 @if($Encuesta->NCR1==5) selected @endif>Residente (Médico) (conteste  la 2)</option>
<option value=6 @if($Encuesta->NCR1==6) selected @endif>Nunca ha trabajado, (pase a la 42 y despues a la 63)</option>
</select>
 <h2 class="reactivo"> 10.- ¿Cuál es el Nombre de la empresa o institución donde trabaja ?</h2>
 <INPUT type="text" class="texto" id="ncr2" name="ncr2" value="{{$Encuesta->NCR2}}" size="110" maxlength="110"  >
    
    <h2 class="reactivo"> 10a.-Estado donde se ubica </h2> 


<select class="select" id="ncr2a"  name="ncr2a" > 
<option selected  value=""></option>
<option value=1 @if($Encuesta->NCR2A==1) selected @endif>CDMX</option>
<option value=2 @if($Encuesta->NCR2A==2) selected @endif>EXTRANJERO</option>
<option value=3 @if($Encuesta->NCR2A==3) selected @endif>Aguascalientes</option>
<option value=4 @if($Encuesta->NCR2A==4) selected @endif>Baja California</option>
<option value=5 @if($Encuesta->NCR2A==5) selected @endif>Baja California Sur</option>
<option value=6 @if($Encuesta->NCR2A==6) selected @endif>Campeche</option>
<option value=7 @if($Encuesta->NCR2A==7) selected @endif>Chiapas</option>
<option value=8 @if($Encuesta->NCR2A==8) selected @endif>Chihuahua</option>
<option value=9 @if($Encuesta->NCR2A==9) selected @endif>Coahuila</option>
<option value=10 @if($Encuesta->NCR2A==10) selected @endif>Colima</option>
<option value=11 @if($Encuesta->NCR2A==11) selected @endif>Durango</option>
<option value=12 @if($Encuesta->NCR2A==12) selected @endif>Guanajuato</option>
<option value=13 @if($Encuesta->NCR2A==13) selected @endif>Guerrero</option>
<option value=14 @if($Encuesta->NCR2A==14) selected @endif>Hidalgo</option>
<option value=15 @if($Encuesta->NCR2A==15) selected @endif>Jalisco</option>
<option value=16 @if($Encuesta->NCR2A==16) selected @endif>Estado de México</option>
<option value=17 @if($Encuesta->NCR2A==17) selected @endif>Michoacán</option>
<option value=18 @if($Encuesta->NCR2A==18) selected @endif>Morelos</option>
<option value=19 @if($Encuesta->NCR2A==19) selected @endif>Nayarit</option>
<option value=20 @if($Encuesta->NCR2A==20) selected @endif>Nuevo León</option>
<option value=21 @if($Encuesta->NCR2A==21) selected @endif>Oaxaca</option>
<option value=22 @if($Encuesta->NCR2A==22) selected @endif>Puebla</option>
<option value=23 @if($Encuesta->NCR2A==23) selected @endif>Querétaro</option>
<option value=24 @if($Encuesta->NCR2A==24) selected @endif>Quintana Roo</option>
<option value=25 @if($Encuesta->NCR2A==25) selected @endif>San Luis Potosí</option>
<option value=26 @if($Encuesta->NCR2A==26) selected @endif>Sinaloa</option>
<option value=27 @if($Encuesta->NCR2A==27) selected @endif>Sonora</option>
<option value=28 @if($Encuesta->NCR2A==28) selected @endif>Tabasco</option>
<option value=29 @if($Encuesta->NCR2A==29) selected @endif>Tamaulipas</option>
<option value=30 @if($Encuesta->NCR2A==30) selected @endif>Tlaxcala</option>
<option value=31 @if($Encuesta->NCR2A==31) selected @endif>Veracruz</option>
<option value=32 @if($Encuesta->NCR2A==32) selected @endif>Yucatán</option>
<option value=33 @if($Encuesta->NCR2A==33) selected @endif>Zacatecas</option>
<option value=0  hidden></option>   
</select>

<h2 class="reactivo"> 11.- La empresa o institución donde trabaja es: 
</h2>


<select class="select" id="ncr3"  name="ncr3" > 
<option selected  value=""></option>
<option value=1 @if($Encuesta->NCR3==1) selected @endif>Pública</option>
<option value=2 @if($Encuesta->NCR3==2) selected @endif>Privada</option>
<option value=3 @if($Encuesta->NCR3==3) selected @endif>Social</option>
<option value=0  hidden></option>   
</select>
<h2 class="reactivo">  12.- ¿En qué sector se ubica? </h2>


<select class="select" id="ncr4" name="ncr4"   onchange="bloquear('ncr4',[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,22],[ncr4a])">
<option selected="selected" value="">
<option value=1 @if($Encuesta->NCR4==1) selected @endif> Agricultura, ganadería, aprovechamiento forestal, caza y pesca</option>
<option value=19 @if($Encuesta->NCR4==19) selected @endif>Asociaciones y agrupaciones</option>
<option value=20 @if($Encuesta->NCR4==20) selected @endif>Actividades de gobierno, organismos internacionales y extraterritoriales</option>
<option value=4 @if($Encuesta->NCR4==4) selected @endif>Construcción</option>
<option value=6 @if($Encuesta->NCR4==6) selected @endif>Comercio al por mayor</option>
<option value=7 @if($Encuesta->NCR4==7) selected @endif>Comercio al por menor</option> 
<option value=13 @if($Encuesta->NCR4==13) selected @endif>Dirección de corporativos y empresas</option>
<option value=23 @if($Encuesta->NCR4==23) selected @endif>Editorial</option>
<option value=3 @if($Encuesta->NCR4==3) selected @endif>Electricidad, agua y suministro de gas</option>
<option value=5 @if($Encuesta->NCR4==5) selected @endif>Industrias manufactureras o de la transformación</option>
<option value=9 @if($Encuesta->NCR4==9) selected @endif>Información en medios masivos</option>
<option value=2 @if($Encuesta->NCR4==2) selected @endif>Minería</option>
<option value=10 @if($Encuesta->NCR4==10) selected @endif>Servicios financieros y de seguros</option>
<option value=11 @if($Encuesta->NCR4==11) selected @endif>Servicio inmobiliario y de alquiler de bienes muebles e intangibles</option>
<option value=12 @if($Encuesta->NCR4==12) selected @endif>Servicios profesionales, científicos y técnicos</option>
<option value=14 @if($Encuesta->NCR4==14) selected @endif>Servicios de apoyo a los negocios, manejo de desecho y servicios de remediación</option>
<option value=15 @if($Encuesta->NCR4==15) selected @endif>Servicios de salud</option>
<option value=16 @if($Encuesta->NCR4==16) selected @endif>Servicios educativos</option>
<option value=17 @if($Encuesta->NCR4==17) selected @endif>Servicios de esparcimiento, cultural, deportivos y otros centros recreativos</option>
<option value=18 @if($Encuesta->NCR4==18) selected @endif>Servicios de alojamiento temporal, de preparación de alimentos y bebidas (hotel, restaurant, bar) </option>
<option value=8 @if($Encuesta->NCR4==8) selected @endif>Transporte, correos y almacenamiento</option>
<option value=22 @if($Encuesta->NCR4==22) selected @endif>Telecomunicaciones </option>
<option value=21 @if($Encuesta->NCR4==21) selected @endif>Otro (Especifíque)</option>
<option value=0  hidden></option>   
</select><br>

<h2 class="reactivo">  

12a).- Otra:</h2> 
<input  class="texto" id="ncr4a" name="ncr4a" size="65" maxlength="65" value=0 > 


<h2 class="reactivo"> 13.-Aproximadamente, ¿cuántas personas laboran en la empresa?  </h2>

<select class="select" id="ncr5" name="ncr5"  >
  <option selected="selected" value="">
  <option value=1 @if($Encuesta->NCR5==1) selected @endif> Hasta 15 empleados</option>
  <option value=2 @if($Encuesta->NCR5==2) selected @endif>Entre 16 y 100 empleados </option>
  <option value=3 @if($Encuesta->NCR5==3) selected @endif>Entre 101 y 250 empleados</option>
  <option value=4 @if($Encuesta->NCR5==4) selected @endif>Más de 251 empleados</option>
  <option value=0  hidden></option>   
</select>

<h2 class="reactivo"> 14.- ¿Cuál es su condición en el trabajo? </h2>

<select class="select" id="ncr6a2"  name="ncr6" onchange="bloquear('ncr6a2',[4],[ncr6a,ncr6otra])">
    <option selected="selected" value="">
    <option value=1 @if($Encuesta->NCR6==2) selected @endif @if($Encuesta->NCR6==3) selected @endif>Autoempleo</option>
    <option value=4 @if($Encuesta->NCR6==4) selected @endif>Empleado </option>
    <option value=5 @if($Encuesta->NCR6==5) selected @endif>Otro (Especifíque)</option>
    <option value=0  hidden></option>   
</select>

    
    <h2 class="reactivo"> 14a.-¿Tipo de autoempleo? </h2>
<select class="select" id="ncr6a" name="ncr6t"  >
<option selected="selected" value="">
<option value=2 @if($Encuesta->NCR6==2) selected @endif>Propietario</option>
    <option value=3 @if($Encuesta->NCR6==3) selected @endif>Profesional independiente</option>
    <option value=0  hidden></option>   
</select>
<br>
<h2 class="reactivo">
 Otra: </h2><input type="text" class="texto" id="ncr6otra" name="ncr6_a" size="65" maxlength="65" value=" " > 

 <h2 class="reactivo">  15.- ¿Cuál es su puesto? </h2>


 <INPUT type="text" class="texto" id="ncr7a" name="ncr7a" value="{{$Encuesta->NCR7_A}}" size="110" maxlength="110"  >

<h2 class="reactivo">16.- ¿Requiere tener título profesional para el puesto que ocupa? </h2>


<select class="select" id="ncr7b" name="ncr7b"  >
    <option selected="selected" value="">
    <option value=1 @if($Encuesta->NCR7B==1) selected @endif>Sí</option>
    <option value=2 @if($Encuesta->NCR7B==2) selected @endif>No</option> 
    <option value=0  hidden></option>   
</select>

    <h2 class="reactivo"> 17.- En su trabajo,¿tiene personal a su cargo? </h2>
<select class="select" id="ncr8" name="ncr8"  onchange="bloquear('ncr8',[2],[ncr9])" >
    <option selected="selected" value="">
    <option value=1 @if($Encuesta->NCR8==1) selected @endif>Sí</option>
    <option value=2 @if($Encuesta->NCR8==2) selected @endif>No</option>
    <option value=0  hidden></option>   
 </select>
    <h2 class="reactivo"> 18.- ¿Cuántas personas trabajan con usted? </h2>


<select class="select" id="ncr9"  >
    <option selected="selected" value="">
    <option value=1 @if($Encuesta->NCR9==1) selected @endif>1 a 5 </option>
    <option value=2 @if($Encuesta->NCR9==2) selected @endif>6 a 10</option> 
    <option value=3 @if($Encuesta->NCR9==3) selected @endif>11 a 20</option> 
    <option value=4 @if($Encuesta->NCR9==4) selected @endif>21 a 30</option> 
    <option value=5 @if($Encuesta->NCR9==5) selected @endif>31 o más</option> 
    <option value=0  hidden></option>   
</select>

<h2 class="reactivo">  19.- ¿Su trabajo es de tiempo completo?</h2> 
<select class="select" id="ncr10" name="ncr10"  >
    <option selected="selected" value="">
    <option value=1 @if($Encuesta->NCR10==1) selected @endif>Sí</option>
    <option value=2 @if($Encuesta->NCR10==2) selected @endif>No</option> 
    <option value=0  hidden></option>   
</select>

 
    <h2 class="reactivo"> 20.- ¿Qué tanto está relacionado su trabajo actual con su profesión? </h2> 

<select class="select" id="ncr11" name="ncr11"   onchange="bloquear('ncr11',[1,2],[ncr15])" >
  <option selected="selected" value="">
  <option value=1 @if($Encuesta->NCR11==1) selected @endif>Muy relacionado</option>
  <option value=2 @if($Encuesta->NCR11==2) selected @endif>Medianamente relacionado</option> 
  <option value=3 @if($Encuesta->NCR11==3) selected @endif>No está relacionado</option> 
  <option value=0  hidden></option>   

</select>
<h2 class="reactivo">  21.- ¿Que actividades realiza? 

</TD>
<TD>

Especifique:</h2>
<INPUT type="text" class="texto" id="ncr12_a" name="ncr12_a" value="{{$Encuesta->NCR12_A}}" size="200" maxlength="200"  >

<h2 class="reactivo"> 22.- ¿Si su trabajo no está relacionado con su carrera
         es porque usted asílo decidió? </h2>

<select class="select" id="ncr15" name="ncr15"  >
<option selected="selected" value="" @if($Encuesta->NCR11!=3) hidden @endif>
    <option value=1 @if($Encuesta->NCR15==1) selected @endif>Sí</OPTION>
    <option value=2 @if($Encuesta->NCR15==2) selected @endif>No</OPTION> 
    <option value=0  hidden></option>   
</select>

<h2 class="reactivo"> 23.- ¿Cómo considera qué lo preparó el estudio de la carrera para el desempeño de su trabajo actual? </h2>
    
    <select class="select" id="ncr16" name="ncr16"   > 
           <option selected="selected" value="">
          <option value=1 @if($Encuesta->NCR16==1) selected @endif>Muy Bien</option>
          <option value=2 @if($Encuesta->NCR16==2) selected @endif>Bien</option>
          <option value=3 @if($Encuesta->NCR16==3) selected @endif>Medianamente</option>
          <option value=4 @if($Encuesta->NCR16==4) selected @endif>Mal</option>
          <option value=5 @if($Encuesta->NCR16==5) selected @endif>Muy mal</option>
          <option value=0  hidden></option>   
 </select>
    
         <h2 class="reactivo">  24.¿Cuál es su grado de satisfacción con su trabajo actual? </h2>
         <select class="select" id="ncr17" name="ncr17" >  
       <option selected="selected" value="">
       <option value=1 @if($Encuesta->NCR17==1) selected @endif>Muy satisfecho(a)</option>
       <option value=2 @if($Encuesta->NCR17==2) selected @endif>Satisfecho(a)</option>
       <option value=3 @if($Encuesta->NCR17==3) selected @endif>Medianamente satisfecho(a)</option>
       <option value=4 @if($Encuesta->NCR17==4) selected @endif>Poco satisfecho(a)</option>
       <option value=5 @if($Encuesta->NCR17==5) selected @endif>Nada satisfecho(a)</option>
       <option value=0  hidden></option>   
</select>
         <h2 class="reactivo">25.- ¿Considera que el salario que percibe en su  trabajo es congruente con su preparación?
        </h2>
    
       <select class="select" id="ncr18" name="ncr18">  
       <option selected="selected" value="">
       <option value=1 @if($Encuesta->NCR18==1) selected @endif>Totalmente de acuerdo</option>
       <option value=2 @if($Encuesta->NCR18==2) selected @endif>De acuerdo</option>
       <option value=3 @if($Encuesta->NCR18==3) selected @endif>Medianamente de acuerdo</option>
       <option value=4 @if($Encuesta->NCR18==4) selected @endif>En desacuerdo</option>
       <option value=5 @if($Encuesta->NCR18==5) selected @endif>Totalmente en desacuerdo</option>
       <option value=0  hidden></option>   
</select>
    
       <h2 class="reactivo">38.- ¿Considera que las actividades y responsabilidades que tiene 
        en su trabajo, corresponden a su nivel educativo?  </h2>
    
       <select class="select" id="ncr19" name="ncr19" > 
       <option selected="selected" value="">
       <option value=5 @if($Encuesta->NCR19==5) selected @endif>Totalmente de acuerdo</option>   
       <option value=4 @if($Encuesta->NCR19==4) selected @endif>De acuerdo</option>
       <option value=3 @if($Encuesta->NCR19==3) selected @endif>Medianamente de acuerdo</option>
       <option value=2 @if($Encuesta->NCR19==2) selected @endif>En desacuerdo</option>   
       <option value=1 @if($Encuesta->NCR19==1) selected @endif>Totalmente  en desacuerdo</option>
       <option value=0  hidden></option>   
</select>
<h2 class="reactivo">39.- ¿Por cuanto tiempo ha laborado en este trabajo?  </h2>
    
    <select class="select" id="ncra20" name="ncra20"  > 
    <option selected="selected" value="">
    <option value=1 @if($Encuesta->NCRA20==1) selected @endif>Menos de un año</option>
    <option value=2 @if($Encuesta->NCRA20==2) selected @endif>Un año</option>
    <option value=3 @if($Encuesta->NCRA20==2) selected @endif>Dos</option>
    <option value=4 @if($Encuesta->NCRA20==2) selected @endif>Tres</option>
    <option value=5 @if($Encuesta->NCRA20==2) selected @endif>Cuatro</option>
    <option value=6 @if($Encuesta->NCRA20==2) selected @endif>Cinco</option>
    <option value=7 @if($Encuesta->NCRA20==3) selected @endif>Seis o más</option>    
</select>
    <h2 class="reactivo">39.- ¿Cuantos trabajos tiene actualmente?  </h2>
    
          <select class="select" id="ncr20" name="ncr20"  > 
          <option selected="selected" value="">
          <option value=1 @if($Encuesta->NCR20==1) selected @endif>Uno</option>
          <option value=2 @if($Encuesta->NCR20==2) selected @endif>Dos</option>
          <option value=3 @if($Encuesta->NCR20==3) selected @endif>Tres o más</option>
          <option value=0  hidden></option>   
</select>
    
           <h2 class="reactivo"> 40.- ¿Cuáles son sus ingresos mensuales promedio en su o sus trabajos?  </h2>
    
    <INPUT type="text" class="texto"  id="ncr21_a" name="ncr21_a" size="10" maxlength="6" value="{{$Encuesta->NCR21_A}}"  onKeyPress="return acceptNum(event)" > 
    (solo enteros, sin centavos, comas, ni puntos) 
    <h2 class="reactivo"> 41.- Durante los años que han transcurrido desde que contesto la encuesta ,
        ¿ha dejado de trabajar? </h2>
    
    
    <select class="select" id="ncr22" name="ncr22"  onchange="bloquear('ncr22',[2],[ncr24,ncr23]) "> 
    <option value="" selected="selected"></option>
    <option value=1 @if($Encuesta->NCR22==1) selected @endif>Sí</option>
    <option value=2 @if($Encuesta->NCR22==2) selected @endif>No</option>
    <option value=0  hidden></option>   

    </select>
    
    <h2 class="reactivo"> 42.-¿Cuál es la razón principal por la que usted no está trabajando o 
        ha dejado de trabajar? </h2>
     <select class="select" id="ncr24" name="ncr24" onchange="bloquear('ncr24',[1,2,3,4,5,6,7,8,9,10,11,13,14,15,16,17,18,19,20,29],[ncr24porque])" >
      <option value=0 @if($Encuesta->NCR24==0) selected @endif> -</option>
      <option value=1 @if($Encuesta->NCR24==1) selected @endif> Estar estudiando</option>
      <option value=13 @if($Encuesta->NCR24==13) selected @endif>Embarazo </option>
      <option value=11 @if($Encuesta->NCR24==11) selected @endif>Razones de salud </option>
      <option value=4 @if($Encuesta->NCR24==4) selected @endif> Obligaciones familiares</option>
      <option value=10 @if($Encuesta->NCR24==10) selected @endif>No le interesaba trabajar </option>
      <option value=5 @if($Encuesta->NCR24==5) selected @endif>Las ofertas eran poco atractivas con relación al salario </option>
      <option value=6 @if($Encuesta->NCR24==6) selected @endif>Las ofertas eran poco atractivas con relación a las actividades profesionales </option>
      <option value=2 @if($Encuesta->NCR24==2) selected @endif>Falta de ofertas de trabajo </option>
      <option value=7 @if($Encuesta->NCR24==7) selected @endif>Falta de experiencia laboral</option>
      <option value=3 @if($Encuesta->NCR24==3) selected @endif>No tenía las competencias necesarias para el trabajo al que aspiraba </option>
      <option value=8 @if($Encuesta->NCR24==8) selected @endif> No tener el título de licenciatura</option>
      <option value=9 @if($Encuesta->NCR24==9) selected @endif>No tener estudios de posgrado </option>
      <option value=12 @if($Encuesta->NCR24==12) selected @endif> Perdió o dejó su trabajo (¿por qué?)</option>
      <option value=13 @if($Encuesta->NCR24==13) selected @endif>Embarazo</option> 
      <option value=15 @if($Encuesta->NCR24==15) selected @endif>Hacer la tesis o trámites de titulación </option> 
      <option value=16 @if($Encuesta->NCR24==16) selected @endif>Servicio social o prácticas profesionales</option> 
      <option value=17 @if($Encuesta->NCR24==17) selected @endif>Cambio de residencia</option> 
      <option value=18 @if($Encuesta->NCR24==18) selected @endif>Emprender un negocio o empresa propios</option> 
      <option value=19 @if($Encuesta->NCR24==19) selected @endif>Motivos personales</option> 
      <option value=20 @if($Encuesta->NCR24==29) selected @endif>Derivado de la pandemia</option> 
      <option value=14 @if($Encuesta->NCR24==14) selected @endif>Otra </option>
      <option value=0  hidden></option>   
</select>
    <br>(Especifíque)
    Otra:
    <input type="text" class="texto" ID="ncr24a" name="ncr24a" size="55" maxlength="55"  @if($Encuesta->NCR24!=14) hidden  value=0 @endif> 
    
    
    <h2 class="reactivo">   42a):-Perdió o dejó su trabajo, ¿por qué? </h2>
  
     <select class="select" id="ncr24porque" name="ncr24porque" @if($Encuesta->NCR24!=12) hidden value=0 @endif>
              <option  value="" selected></option>
     <option value=1 @if($Encuesta->ncr24porque==1) selected @endif>Cerró la empresa</option> 
     <option value=2 @if($Encuesta->ncr24porque==2) selected @endif>Liquidación</option> 
     <option value=3 @if($Encuesta->ncr24porque==3) selected @endif>Término de contrato o proyecto</option> 
     <option value=4 @if($Encuesta->ncr24porque==4) selected @endif>Renuncia</option> 
     <option value=15 @if($Encuesta->ncr24porque==15) selected @endif>Renuncia debido a la  pandemia</option>
     <option value=16 @if($Encuesta->ncr24porque==16) selected @endif>Despido debido a la pandemia</option>
     <option value=17 @if($Encuesta->ncr24porque==17) selected @endif>Cerro la empresa debido a la pandemia</option>
     <option value=5  @if($Encuesta->ncr24porque==5) selected @endif>Otra</option> 
     <option value=0   @if($Encuesta->NCR24!=12) selected @endif hidden></option>   
</select>
       
     <h2 class="reactivo"> 43.- ¿Ciál es el periodo más largo que ha permanecido sin laborar? </h2>
    
    
    <select class="select" id="ncr23" name="ncr23" >
        <option selected="selected" value="">
        <option value=1 @if($Encuesta->NCR23==1) selected @endif>De 1 a 3 meses</option>
        <option value=2 @if($Encuesta->NCR23==2) selected @endif>Más de 3 y hasta 6 meses</option> 
        <option value=3 @if($Encuesta->NCR23==3) selected @endif>Más de 6 y hasta un año</option> 
        <option value=4 @if($Encuesta->NCR23==4) selected @endif>Más de un año</option> 
        <option value=0  hidden></option>   
    </select>
      
  </div>

      <div class='col' id='D' style='text-align: center;'>
    

  <h2 class="reactivo"> 60.- ¿Cuántos trabajos ha tenido desde que egresó de la licenciatura? </h2>
<select class="select" id="ndr17" name="ndr17" >
<option selected="selected" value="">
   <option value=1  @if($Encuesta->NDR17==1) selected @endif>Uno</option>
   <option value=2  @if($Encuesta->NDR17==2) selected @endif>Dos </option>
   <option value=3  @if($Encuesta->NDR17==3) selected @endif>De tres a seis</option>
 <option value=4  @if($Encuesta->NDR17==4) selected @endif>Más de seis</option>
 <option value=5  @if($Encuesta->NDR17==5) selected @endif>Ninguno</option>
 <option value=0  hidden></option>   
</select>cd ..

 <h2 class="reactivo">  Desde su inserción al campo laboral a la fecha, considera que su situación, con relación a el:</h2>

 <h2 class="reactivo">61).- Puesto que ocupa    </h2>
<select class="select" id="ndr18" name="ndr18">
        <option selected="selected" value="">
<option value=1  @if($Encuesta->NDR18==1) selected @endif>Mejoró</option>
<option value=2  @if($Encuesta->NDR18==2) selected @endif>Es la misma</option>
<option value=3  @if($Encuesta->NDR18==3) selected @endif>Empeoró</option>
<option value=0  hidden></option>   
</select>

    <h2 class="reactivo">62).- Salario    </h2> 
<select class="select" id="ndr19" name="ndr19" >
        <option selected="selected" value="">
<option value=1  @if($Encuesta->NDR19==1) selected @endif>Mejoró</option>
<option value=2  @if($Encuesta->NDR19==2) selected @endif>Es la misma</option>
<option value=3  @if($Encuesta->NDR19==3) selected @endif>Empeoró</option>
<option value=0  hidden></option>   
</select>

      </div>

      <div class='col' id='E' style='text-align: center;'>
       
      <h1 class="seccion">SECCION E1</h1>
    <h2 class="reactivo">  
    63.- ¿Desde que egresó de la licenciatura ha realizado actividades formales de actualización en su campo profesional?
    (cursos, diplomados,seminarios, etc.)</h2>
         <select class="select" id="ner1" name="ner1"  onchange="bloquear('ner1',[2],[ner2,ner3,ner4,ner5,ner6,ner7,ner7int,ner7a])" > 
        <option  value="" selected></option>
       <option value=1  @if($Encuesta->NER1==1) selected @endif>Sí</option>
       <option value=2  @if($Encuesta->NER1==2) selected @endif>No (pase a la 72)</option>
       <option value=0  hidden></option>   
</select>

         <h2 class="reactivo">  
    64.- ¿Cada cuando lo realiza?-----------</h2>
          <select class="select" id="ner2" name="ner2"  >
          <option value=""></option>
       <option value=1  @if($Encuesta->ner2==1) selected @endif>Cada seis meses</option>
       <option value=2  @if($Encuesta->ner2==2) selected @endif>Cada año</option>
       <option value=3  @if($Encuesta->ner2==3) selected @endif>Cada dos o tres años</option>
       <option value=4  @if($Encuesta->ner2==4) selected @endif>Continuamente</option>
       <option value=0  hidden></option>   
 </select>
  

         <h2 class="reactivo">  
    <b>¿Dónde las ha realizado?</b></h2>
    
    <h2 class="reactivo">  
    65.- En la UNAM</h2>
    <select class="select" id="ner3"  name="ner3" >
    <option value="" selected="selected"></option>
        <option value=1  @if($Encuesta->ner3==1) selected @endif>Sí</option>
       <option value=2  @if($Encuesta->ner3==2) selected @endif>No</option>
       <option value=0  hidden></option>   
</select>

       <h2 class="reactivo">  
    66.- En otra institución pública</h2>
    <select class="select" id="ner4" name="ner4" >
    <option value="" selected="selected"></option>
        <option value=1  @if($Encuesta->ner4==1) selected @endif>Sí</option>
       <option value=2  @if($Encuesta->ner4==2) selected @endif>No</option>
       <option value=0  hidden></option>   
</select>
    
       <h2 class="reactivo">  
67.- En otra institución privada</h2>
    <select class="select" id="ner5" name="ner5" >
      <option value="" selected="selected"></option>
      <option value=1  @if($Encuesta->ner5==1) selected @endif>Sí</option>
      <option value=2  @if($Encuesta->ner5==2) selected @endif>No</option>
      <option value=0  hidden></option>   
</select>

       <h2 class="reactivo">  
    68.-En la empresa o institución en la que trabaja</h2>
    <select class="select" id="ner6" name="ner6" >
    <option value="" selected="selected"></option>
    <option value=1  @if($Encuesta->ner6==1) selected @endif>Sí</option>
    <option value=2  @if($Encuesta->ner6==2) selected @endif>No</option>
    <option value=0  hidden></option>   
</select>

    <h2 class="reactivo">  
    69.-En una asociación</h2>
    <select class="select" id="ner7" name="ner7" >
    <option value="" selected="selected"></option>
    <option value=1  @if($Encuesta->ner7==1) selected @endif>Sí</option>
    <option value=2  @if($Encuesta->ner7==2) selected @endif>No</option>
    <option value=0  hidden></option>  
    <option value=0  hidden></option>   
</select>
   
    <h2 class="reactivo">  
    70.-En Internet</h2>
    <select class="select" id="ner7int" name="ner7int" >
      <option value="" selected="selected"></option>
      <option value=1  @if($Encuesta->ner7int==1) selected @endif>Sí</option>
      <option value=2  @if($Encuesta->ner7int==2) selected @endif>No</option>
      <option value=0  hidden></option>   
</select>
  
    <h2 class="reactivo">  
    71.-Otro lugar</h2>
    <h2 class="reactivo">  
    71a).-¿Cúal?</h2>
    <INPUT id="ner7a" NAME="ner7a" TYPE=TEXT class="texto"  value=" " SIZE=60 MAXLENGTH=60 >
      
      <h2 class="reactivo">  
    <B>Ha realizado estudios de:</B> <BR></h2>
    <h2 class="reactivo">  
    72.- <B>¿Posgrado?</B></h2>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <select class="select" id="ner8" name="ner8"  onchange="bloquear('ner8',[2],[ner9,ner10,ner10a,ner11,ner12,ner13,ner14,ner15,ner12a,ner12b,ner16,ner17,ner18,ner19])" >
       <option selected="selected" value="">
       <option value=1  @if($Encuesta->ner8==1) selected @endif>Sí</option>
       <option value=2  @if($Encuesta->ner8==2) selected @endif>No (pase a 82 o 77)</option >
       <option value=0  hidden></option>   
</select>
   
    <h2 class="reactivo">  
    72a).-¿Qué tan relacionados están los estudios de posgrado que realiza y su carrera?</h2>
    <select class="select" id="ner9" name="ner9" >
       <option selected="selected" value="">
       <option value=1  @if($Encuesta->ner9==1) selected @endif>Muy relacionados</option>
       <option value=2  @if($Encuesta->ner9==2) selected @endif>Medianamente relacionados</option>
     <option value=3  @if($Encuesta->ner9==3) selected @endif>Poco o nada relacionados</option>
     <option value=0  hidden></option>   
   </select>
 
    
    <h2 class="reactivo"> 
    73.- <B>¿Especialización?</B> </h2>
    <select class="select" id="ner10" name="ner10"  onchange="bloquear('ner10',[2],[ner10a,ner11,ner12])" >
      <option selected="selected" value="">
      <option value=1  @if($Encuesta->ner10==1) selected @endif>Sí</option>
      <option value=2  @if($Encuesta->ner10==2) selected @endif>No</option>
      <option value=0  hidden></option>   
</select>


    <h2 class="reactivo">  
    ¿Cuál? </h2>
    <INPUT   id="ner10a" name="ner10a" TYPE=TEXT class="texto"  value=" " SIZE=100 MAXLENGTH=60 >
   
    <h2 class="reactivo"> 
    <TD width=30%>73a).- ¿Ya se graduó? </h2>
    <select class="select" id="ner11" name="ner11" >
      <option selected="selected" value="">
      <option value=1  @if($Encuesta->ner11==1) selected @endif>Sí</option>
      <option value=2  @if($Encuesta->ner11==2) selected @endif>No</option>
      <option value=0  hidden></option>   
</select>
    
      <h2 class="reactivo"> 
    74.- ¿En dónde los hizo? </h2>
     <select class="select" id="ner12" name="ner12" >
       <option selected="selected" value="">
       <option value=1  @if($Encuesta->ner12==1) selected @endif>En la UNAM</option>
       <option value=2  @if($Encuesta->ner12==2) selected @endif>En otra institución pública</option>
       <option value=3  @if($Encuesta->ner12==3) selected @endif>En otra institución privada</option>
       <option value=4  @if($Encuesta->ner12==4) selected @endif>En el extranjero</option>
       <option value=0  hidden></option>   
</select>
   
      <h2 class="reactivo">  
    75.- <b>¿Maestría?</b></h2>
    <select class="select" id="ner13" name="ner13"  onchange="bloquear('ner13',[2],[ner14,ner15])" >
        <option selected="selected" value="">
        <option value=1  @if($Encuesta->ner13==1) selected @endif>Sí</option>
        <option value=2  @if($Encuesta->ner13==2) selected @endif>No</option>
        <option value=0  hidden></option>   
</select>
  
     <h2 class="reactivo">  
    75a).- ¿Ya se graduó?</h2>
    <select class="select" id="ner14" name="ner14" >
       <option selected="selected" value="">
       <option value=1  @if($Encuesta->NER14==1) selected @endif>Sí</option>
       <option value=2  @if($Encuesta->NER14==2) selected @endif>No</option>
       <option value=0  hidden></option>   
</select>
   
      <h2 class="reactivo"> 
    76.- ¿En dónde los hizo? </h2>
    <select class="select" id="ner15"  name="ner15" >
       <option selected="selected" value="">
       <option value=1  @if($Encuesta->NER15==1) selected @endif>En la UNAM</option>
       <option value=2  @if($Encuesta->NER15==2) selected @endif>En otra institución pública</option>
       <option value=3  @if($Encuesta->NER15==3) selected @endif>En otra institución privada</option>
       <option value=4  @if($Encuesta->NER15==4) selected @endif>En el extranjero</option>
       <option value=0  hidden></option>   
</select>
    
 
    
      <h2 class="reactivo">
    77.-¿Subespecialización? (solo médicos)  </h2>
    <select class="select" id="ner12a" name="ner12a" onchange="bloquear('ner12a',[2],[ner12b])" @if(($Encuesta->nbr2!=208) && ($Encuesta->nbr2 !=202)) hidden value=0 @endif>
      <option value=0 >-</option>
      <option value=1  @if($Encuesta->ner12a==1) selected @endif>Sí</option>
      <option value=2  @if($Encuesta->ner12a==2) selected @endif>No</option>
      <option value=0  hidden></option>   
</select>
    
      <h2 class="reactivo">  
    77a).-¿En qué área? </h2>
    <INPUT   id="ner12b" name="ner12b" TYPE=TEXT  class="texto" value=" " SIZE=120 MAXLENGTH=120 @if(($Encuesta->nbr2!=208) && ($Encuesta->nbr2 !=202)) hidden value=0 @endif>
    
 
      <h2 class="reactivo">  
    78.-¿Ha realizado estudios de Doctorado?</h2>
    <select class="select" id="ner16" name="ner16"  onchange="bloquear('ner16',[2],[ner17,ner18])" >
      <option selected="selected" value="">
      <option value=1  @if($Encuesta->ner16==1) selected @endif>Sí</option>
      <option value=2  @if($Encuesta->ner16==2) selected @endif>No (Pase a la 81)</option>
      <option value=0  hidden></option>   
</select>
   
     <h2 class="reactivo">  
    79.- ¿Ya se graduó?</h2>
    <select class="select" id="ner17" name="ner17" @if($Encuesta->ner16==2) hidden value=0 @endif>
    <option selected="selected" value="">
      <option value=1  @if($Encuesta->NER17==1) selected @endif>Sí</option>
       <option value=2  @if($Encuesta->NER17==2) selected @endif>No</option>
       <option value=0  hidden></option>   
</select>
   
      <h2 class="reactivo">  
    80).- ¿En dónde los hizo?-</h2>
    <select class="select" id="ner18" name="ner18" @if($Encuesta->ner16==2) hidden value=0 @endif>
    <option selected="selected" value="">
       <option value=1  @if($Encuesta->NER18==1) selected @endif>En la UNAM</option>
       <option value=2  @if($Encuesta->NER18==2) selected @endif>En otra institución pública</option>
       <option value=3  @if($Encuesta->NER18==3) selected @endif>En otra institución privada</option>
       <option value=4  @if($Encuesta->NER18==4) selected @endif>En el extranjero</option>
       <option value=0  hidden></option>   
 </select>
    
      <h2 class="reactivo">  
    <BR>81.-¿Cuál es la razón más importante por la que realiza(ó) estos estudios (posgrado y/o especialidad y/o doctorado)?
    </h2>
     <select class="select" id="ner19" name="ner19"  > 
       <option selected="selected" value="">
       <option value=1   @if($Encuesta->ner19==1) selected @endif> Interés por la investigación</option>
       <option value=2  @if($Encuesta->ner19==2) selected @endif> Interés en profundizar en la disciplina</option>
       <option value=3  @if($Encuesta->ner19==3) selected @endif> Quería cambiar de campo</option>
       <option value=4  @if($Encuesta->ner19==4) selected @endif> Falta de oportunidades de empleo en la carrera</option>
       <option value=5  @if($Encuesta->ner19==5) selected @endif> Incrementar ingresos</option>
       <option value=6  @if($Encuesta->ner19==6) selected @endif> Alcanzar un nivel más alto en el trabajo</option>
       <option value=7  @if($Encuesta->ner19==7) selected @endif> Otra</option>
       <option value=0  hidden></option>   
</select>
      </div>

      <div class='col' id='F' style='text-align: center;'>
       
 
<TR>
  <TD>  <h2 class="reactivo"> 
100.- ¿Ya se tituló? </h2>
    </TD>
    <TD>
   <select class="select" id="nfr27"  name="nfr27"  onchange="titulado()" >
     <option value="" selected="selected"></option>
     <option value=1 @if($Encuesta->NFR27==1) selected @endif>Sí</option>
     <option value=2 @if($Encuesta->NFR27==2) selected @endif>No</option>
     <OPTION VALUE=3 @if($Encuesta->NFR27==3) selected @endif>No, estoy en trámite</OPTION>
     <option value=0 hidden> </option>
    </select>
    <h2 class="reactivo"> 
101.- ¿Cuánto tiempo después de egresar se tituló? </h2>

<select class="select" id="nfr28" name="nfr28" @if($Encuesta->NFR27!=1) hidden value=0 @else value={{$Encuesta->NFR28}} @endif>Sí>
  <option value="" selected="selected"></option>
  <option value=1 @if($Encuesta->NFR28==1) selected @endif>Durante el primer año después de egresar</option>
  <option value=2 @if($Encuesta->NFR28==2) selected @endif>Dos años después de egresar</option>
  <option value=3 @if($Encuesta->NFR28==3) selected @endif>Tres años o más después de egresar</option>
  <option value=0 @if($Encuesta->NFR27!=1)selected  @endif hidden></option>  

</select>

<h2 class="reactivo"> 
102.- ¿Cuál es el motivo más importante por el que no se ha titulado? </h2>
     <select class="select" id="nfr29"  name="nfr29"  onchange="bloquear('nfr29',[1,2,3,4,5,6,7,8,10,11,12,13,14,15,16],[nfr29a])">
<option value="" selected="selected"></option>
   <option value=1 @if($Encuesta->NFR29==1) selected @endif>Trámites  engorrosos y difíciles</option>
  <option value=2 @if($Encuesta->NFR29==2) selected @endif>No he tenido tiempo por estar trabajando</option>
  <option value=3 @if($Encuesta->NFR29==3) selected @endif>No he tenido tiempo por obligaciones familiares</option>
  <option value=4 @if($Encuesta->NFR29==4) selected @endif>No he podido concluir la tesis</option>
  <option value=5 @if($Encuesta->NFR29==5) selected @endif>No he hecho la tesis</option>
  <option value=6 @if($Encuesta->NFR29==6) selected @endif>No me interesa hacerlo</option>
  <option value=7 @if($Encuesta->NFR29==7) selected @endif>No, por estar estudiando</option>
  <option value=10 @if($Encuesta->NFR29==10) selected @endif>No acreditar el o los idiomas</option>
  <option value=11 @if($Encuesta->NFR29==11) selected @endif>Economicas</option>
  <option value=12 @if($Encuesta->NFR29==12) selected @endif>Esperar la convocatoria para diplomados o examen de conocimientos</option>
  <option value=13 @if($Encuesta->NFR29==13) selected @endif>Problemas con el asesor</option>
  <option value=14 @if($Encuesta->NFR29==14) selected @endif>No ha realizado el servicio social</option>
  <option value=15 @if($Encuesta->NFR29==15) selected @endif>Cursando el diplomado o alguna otra modalidad de titulación</option>
  <option value=16 @if($Encuesta->NFR29==16) selected @endif>Motivos de salud</option>
  <option value=8 @if($Encuesta->NFR29==8) selected @endif>No deseo contestar</option>
  <option value=9 @if($Encuesta->NFR29==9) selected @endif>Otra (especifíque)</option>
  <option value=0 hidden ></option>
    
</select> 
  <h2 class="reactivo">  
102a).- Otra (especifíque):</h2>
<INPUT  id="nfr29a" name="nfr29a" TYPE=TEXT  class="texto"  SIZE=47 MAXLENGTH=47 > 

      </div>

  <div class='col' id='G' style='text-align: center;'>

   
  <h2 class="reactivo">  
117.- Para el desempeño de su o sus trabajo ¿Qué nivel de dominio del idioma inglés requiere de las siguientes habilidades?
<br></h2>
<select class="select" id="g13"  name="ngr13" onchange="bloquear('g13',[11],[ngr13,ngr13b,ngr13c,ngr13d])" >
	      <option value="" selected="selected"></option>
        <option value=12 @if($Encuesta->NGR13==12) selected @endif>Sí</option>
        <option value=11 @if($Encuesta->NGR13==11) selected @endif>No</option>

  </select>
<h2 class="reactivo">  
Comprensión auditiva<br></h2>
     <select class="select" id="ngr13"  name="ngr13a" >
	<option value="" selected="selected"></option>
        <option value=11 @if($Encuesta->NGR13A==11) selected @endif>Básico</option>
        <option value=12 @if($Encuesta->NGR13A==12) selected @endif>Intermedio </option>
        <option value=13 @if($Encuesta->NGR13A==13) selected @endif>Avanzado</option>
        <option value=14 @if($Encuesta->NGR13A==14) selected @endif>No es necesario</option>
        <option value=0 hidden > </option>
      </select>
     <h2 class="reactivo">
Comprensión de lectura<br>  </h2>
     <select class="select" id="ngr13b"  name="ngr13b" >
	<option value="" selected="selected"></option>
        <option value=11 @if($Encuesta->NGR13B==11) selected @endif>Básico</option>
        <option value=12 @if($Encuesta->NGR13B==12) selected @endif>Intermedio </option>
        <option value=13 @if($Encuesta->NGR13B==13) selected @endif>Avanzado</option>
        <option value=14 @if($Encuesta->NGR13B==14) selected @endif>No es necesario</option>
        <option value=0 hidden > </option>
      </select>

     <h2 class="reactivo">  
   Expresión oral<br></h2>
     <select class="select" id="ngr13c"  name="ngr13c" >
	<option value="" selected="selected"></option>
        <option value=11 @if($Encuesta->NGR13C==11) selected @endif>Básico</option>
        <option value=12 @if($Encuesta->NGR13C==12) selected @endif>Intermedio </option>
        <option value=13 @if($Encuesta->NGR13C==13) selected @endif>Avanzado</option>
        <option value=14 @if($Encuesta->NGR13C==14) selected @endif>No es necesario</option>
        <option value=0 hidden > </option>
      </select>

     <h2 class="reactivo">  
        Expresión escrita<br></h2>
     <select class="select" id="ngr13d"  name="ngr13d" >
      	<option value="" selected="selected"></option>
        <option value=11 @if($Encuesta->NGR13D==11) selected @endif>Básico</option>
        <option value=12 @if($Encuesta->NGR13D==12) selected @endif>Intermedio </option>
        <option value=13 @if($Encuesta->NGR13D==13) selected @endif>Avanzado</option>
        <option value=14 @if($Encuesta->NGR13D==14) selected @endif>No es necesario</option>
        <option value=0 hidden > </option>
      </select>

  <h2 class="reactivo">  
118.- ¿Adquirió o mejoró el dominio de otro idioma, diferente al inglés? </h2>
<select class="select" id="ngr11a"  name="ngr11a"  >
    <option value="" selected="selected"></option>
      <option value=11 @if($Encuesta->NGR11==11) selected @endif>No</option>
      <option value=12 @if($Encuesta->NGR11==12) selected @endif>Sí, </option>
      <option value=0 hidden > </option>
      </select>
      </div>
    </div>
  <br><br>
</div>

<div class="fixed">
 <button class="btn fixed" name='boton1'  value=0 type="button" onclick="post_data()" style="background-color:{{Auth::user()->color}} ; color:white; display: flex;">
    <i class="fas fa-save fa-lg"></i> &nbsp; Guardar
  </button>
</div>
</form>
</div>
@stop

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
<style>
  .Scroll {
  height:600px;
  overflow-y: scroll;
  scroll-behavior: smooth;
}
.reactivo{
text-align: center;
  padding: 10px;
  font-weight: bold;
  font-size: 25px;
  color: #c2bcce;
  text-shadow: 3px  0px 0px black,
               0px  3px 0px black,
              -3px  0px 0px black,
               0px -3px 0px black;
}
.texto{
  font-size:25px;
  color:{{Auth::user()->color}};
}
.fecha{
  font-size:25px;
  color:{{Auth::user()->color}};
}
.select{
  font-size:25px;
  color:{{Auth::user()->color}};
}
</style>
<style>
  .fixed {
    position:fixed;
    bottom:0;
    right:0;
  background: {{Auth::user()->color}};
  width: 150px;
  height: 110px;
  display: flex;
  justify-content: center;
  align-items: center;
  box-shadow: 0 0 6px #000;
  color: #fff;
}


</style>
<style>
body {
  margin: 0;
  font-family: Arial, Helvetica, sans-serif;
}

.top-container {
  background-color: #f1f1f1;
  padding: 30px;
  text-align: center;
}

.header {
  padding: 10px 16px;
  background: #555;
  color: #f1f1f1;
}

.content {
  padding: 16px;
}

.sticky {
  position: fixed;
  top: 0;
  width: 100%;
}

.sticky + .content {
  padding-top: 102px;
}
</style>
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"/>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

<style>
  
.swal2-popup {
    font-size: 18px !important;
}
</style>
@endpush

@push('js')
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  function hide_all(){
    sections=['A','B','C','D','E','F','G'];
   for (let i = 0; i < sections.length; i++) {
    //  console.log(sections[i])   
     document.getElementById(sections[i]).style.display='none';
     document.getElementById(sections[i]+'btn').style.backgroundColor="#ffffff";
     document.getElementById(sections[i]+'txt').style.color="rgb(23,23,23)";
    }
  }
  function unhide(sec){
    hide_all();
    document.getElementById(sec).style.display='block';
    document.getElementById(sec+'btn').style.backgroundColor="{{Auth::user()->color}}";
    console.log(document.getElementById(sec+'btn').style.color)
    document.getElementById(sec+'txt').style.color="white";
    var el = document.querySelector('#cuerpo');
    window.scrollTo(888, 1000);
    el.scrollTo(88, 100); 
    document.body.scrollTop=200;
    console.log('scroleado¿?');
   

// get scroll position in px
console.log(el.scrollLeft, el.scrollTop);

// set scroll position in px
el.scrollLeft = 500;
el.scrollTop = 1000;
var scrollLeft = window.pageXOffset || document.documentElement.scrollLeft,
    scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    document.documentElement.scrollTop = document.body.scrollTop = 1000;
document.documentElement.scrollLeft = document.body.scrollLeft = 500;
  }
  unhide('A');

 </script>

 <script>
function bloquear(reactivo,options,reactivosPorCerrar){


var val=document.getElementById(reactivo);
console.log ('entrando a bloqueo '+reactivo+', opciones:'+val.value);
console.log(options);
console.log(options.includes(parseInt(val.value)));
if(options.includes(parseInt(val.value))){
 
  reactivosPorCerrar.forEach(ocultar);
}else{
  reactivosPorCerrar.forEach(visibilizar);
}

}


function ocultar(item){
console.log('ocultando'+item.id);
document.getElementById(item.id).value=0;
document.getElementById(item.id).hidden="hidden";
console.log(document.getElementById(item.id).value);
}

function visibilizar(item){
  console.log('visibilizando'+document.getElementById(item.id).name);
  if(document.getElementById(item.id).value==0){
    console.log('xd');
document.getElementById(item.id).hidden="";
document.getElementById(item.id).value="";}
}

function check_beca(){
  console.log('executing function beca');
  nar2a=document.getElementById("nar2a").value;
  nar3a=document.getElementById("nar3a").value;
  console.log(nar3a);
  if(nar2a==1 && nar3a==1){
   console.log('hay que cerrar la beca xd');
   ocultar(document.getElementById("nar4a"));
   ocultar(document.getElementById("nar5a"));
  }
  else{
  if(document.getElementById("nar4a").value==0){
   visibilizar(document.getElementById("nar4a"));
   visibilizar(document.getElementById("nar5a"));}
  }
  
}

function seccionc2(){
  c1_value=document.getElementById("ncr1").value;
  console.log(c1_value);
  switch(c1_value){
    case '1':
      reactivosPorCerrar=[ncr2,ncr2a,ncr3,ncr4,ncr4a,ncr5,ncr6a,ncr6otra,ncr6a2,ncr7a,ncr7b,ncr8,ncr9,ncr10,ncr11,ncr12_a,ncr15,ncr16,ncr17,ncr18,ncr19,ncra20,ncr20,ncr21_a,ncr22,ncr23,ndr17,ndr18,ndr19,ngr13,ngr13b,ngr13c,ngr13d, ngr11a];
      reactivosPorCerrar.forEach(visibilizar);
    break;
    case '2':
      reactivosPorCerrar=[ncr2,ncr2a,ncr3,ncr4,ncr4a,ncr5,ncr6a,ncr6otra,ncr6a2,ncr7a,ncr7b,ncr8,ncr9,ncr10,ncr11,ncr12_a,ncr15,ncr16,ncr17,ncr18,ncr19,ncra20,ncr20,ncr21_a,ncr22,ncr23,ndr17,ndr18,ndr19, ngr13,ngr13b,ngr13c,ngr13d, ngr11a];
      reactivosPorCerrar.forEach(visibilizar);
    break;
    case '3':
      reactivosPorCerrar=[ncr2,ncr2a,ncr3,ncr4,ncr5,ncr4a,ncr6a,ncr6otra,ncr6a2,ncr7a,ncr7b,ncr8,ncr9,ncr10,ncr11,ncr12_a,ncr15,ncr16,ncr17,ncr18,ncr19,ncra20,ncr20,ncr21_a,ncr22];
      reactivosPorCerrar.forEach(ocultar);
    break;
    case '4':
      reactivosPorCerrar=[ncr2,ncr2a,ncr3,ncr4,ncr5,ncr4a,ncr6a,ncr6otra,ncr6a2,ncr7a,ncr7b,ncr8,ncr9,ncr10,ncr11,ncr12_a,ncr15,ncr16,ncr17,ncr18,ncr19,ncra20,ncr20,ncr21_a,ncr22];
      reactivosPorCerrar.forEach(ocultar);
    break;
    case '5':
      reactivosPorCerrar=[ncr3,ncr4,ncr5,ncr4a,ncr6a,ncr6otra,ncr6a2,ncr7a,ncr7b,ncr8,ncr9,ncr10,ncr11,ncr12_a,ncr15,ncr16,ncr17,ncr18,ncr19,ncra20,ncr20,ncr21_a,ncr22];
      reactivosPorCerrar.forEach(ocultar);
    break;
    case '6':
      reactivosPorCerrar=[ncr2,ncr2a,ncr3,ncr4,ncr5,ncr4a,ncr6a,ncr6otra,ncr6a2,ncr7a,ncr7b,ncr8,ncr9,ncr10,ncr11,ncr12_a,ncr15,ncr16,ncr17,ncr18,ncr19,ncra20,ncr20,ncr21_a,ncr22,ncr23,ndr17,ndr18,ndr19,ngr13,ngr13b,ngr13c,ngr13d ,ngr11a];
      reactivosPorCerrar.forEach(ocultar);
    break;
  }
}
function titulado(){
  console.log('cerrando titulado');
  console.log(document.getElementById('nfr27').value);
  bloquear('nfr27',[1],[nfr29,nfr29a]);
  bloquear('nfr27',[2,3],[nfr28]);
  bloquear('nfr29',[0,1,2,3,4,5,6,7,8,10,11,12,13,14,15,16],[nfr29a]);
}
 </script>

 
 <script>
 function post_data(){
  console.log('ey k once :v');
  forma=document.querySelector('#forma_sagrada');
  console.log(forma.name);
  var elements = document.getElementById("forma_sagrada").elements;

  for (var i = 0, element; element = elements[i++];) {
      if (element.value == "" ){
          console.log("falta "+element.name+"  "+element.value);
          Swal.fire({
  title: 'GUARDAR ENCUESTA',
  text: 'Estas a punto de guardar una encuesta incompleta, falta: '+element.name+' ¿deseas guardarla aun así?',
  showDenyButton: true,
  showCancelButton: true,
  confirmButtonText: 'Sí, guardar',
  denyButtonText: 'No',
  width: '50%',
  customClass: {
    actions: 'my-actions',
    cancelButton: 'order-1 right-gap',
    confirmButton: 'order-2',
    denyButton: 'order-3',
  }
}).then((result) => {
  if (result.isConfirmed) {
    Swal.fire('Saved!', '', 'success')
    forma.submit();
  } else if (result.isDenied) {
    Swal.fire('Changes are not saved', '', 'info')
    document.getElementById(element.id).focus();
  }
})
          
          return;
      }
  }
  forma.submit();
 }
 </script>
  <script>
      function manual(myRadio) {
    var folio = document.getElementById("fecha-group");
    folio.style.display="block";
}
function automatico(myRadio) {
    var group = document.getElementById("fecha-group");
    var fecha = document.getElementById("fec_capt");
    group.style.display="none";
    fecha.value="2023-01-01";
}
    </script>

<script>
//   var elements = document.getElementById("forma_sagrada").elements;
//  var macalacarray="'"; 
//   for (var i = 0, element; element = elements[i++];) {
//         macalacarray=macalacarray+element.name+"', '"
//         }
//         console.log(macalacarray);
  
  seccionc2();
  bloquear('ncr4',[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,22],[ncr4a]);
  bloquear('ncr6a2',[4],[ncr6a,ncr6otra]);
  bloquear('ncr8',[2],[ncr9]);
  bloquear('ncr11',[1,2],[ncr15]);
  bloquear('ncr22',[2],[ncr24,ncr23]);
  bloquear('nar8',[1],[nar11,nar11a,nar14,nar14otra])
  bloquear('ner1',[2],[ner2,ner3,ner4,ner5,ner6,ner7,ner7int,ner7a,]);
  bloquear('ner8',[2],[ner9,ner10,ner10a,ner11,ner12, @if(($Encuesta->nbr2==208) || ($Encuesta->nbr2 ==202)) ner12b,ner12a, @endif ner13,ner14,ner15,ner16,ner17,ner18,ner19]);
  bloquear('ner10',[2],[ner10a,ner11,ner12]);
  bloquear('ner13',[2],[ner14,ner15])
  bloquear('ner16',[2],[ner17,ner18]);
  // bloquear('ngr6',[1],[ngr6a,ngr6b,ngr6c,ngr6d,ngr6e,ngr6f,ngr6g]);
  // bloquear('ngr8',[1],[ngr9a,ngr9b,ngr9c,ngr9d]);
  // bloquear('ngr11a',[11],[ ngr11a,]);
  bloquear('g13',[11],[ngr13,ngr13b,ngr13c,ngr13d])
  titulado();
</script>

@endpush