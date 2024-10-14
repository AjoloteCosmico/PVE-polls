@extends('layouts.blank_app')

@section('content')
<h1 > COMPLETAR ENCUESTA </h1>
<div  id='datos'>  @include('encuesta.personal_data') </div>
<div style="padding:1.2vw;">
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{$error}} {{str_replace('The ','',str_replace('field is required', '', $error)) }} </li>
            @endforeach
        </ul>
    </div>
@endif
<form action="{{ url('encuestas/2020/G_update/'. $Encuesta->registro) }}" method="POST" enctype="multipart/form-data" id='forma_sagrada' name='forma'>
@csrf
<table class="encuesta_table">
        <!-- primera fila  -->
<tr>
  <td colspan="4">
<h1 class="seccion">DURANTE SUS ESTUDIOS EN LICENCIATURA UNAM</h1>

</td>
</tr> 

<tr>
<td>
<h2 class="reactivo">Tiene computadora en:   <br>
104).- Su casa</h2>
  <select class="select" id="Pregunta 110" name="ngr4" >
    <option selected="selected" value="">
    <option value=1 @if($Encuesta->ngr4==1) selected @endif>Sí</option>
    <option value=2 @if($Encuesta->ngr4==2) selected @endif>No</option>
  </select>
    </td>
<td>
<h2 class="reactivo">
105).- Su trabajo </h2>
  <select class="select" id="ngr5" name="ngr5" >
    <option value="" selected="selected"></option>
    <option value=1 @if($Encuesta->ngr5==1) selected @endif>Sí</option>
    <option value=2 @if($Encuesta->ngr5==2) selected @endif>No</option>
    <option value=3 @if($Encuesta->ngr5==3) selected @endif>Sin trabajo</option>
    <option value=0 hidden > </option>     
   </select>
       </td>

<td>
<h2 class="reactivo"> 
106).- ¿Incrementó y/o adquirió habilidades para la computación durante sus estudios de licenciatura?
</h2>
<select class="select" id="ngr6" name="ngr6"   onchange="bloquear('ngr6',[1,5],[ngr6a,ngr6b,ngr6c,ngr6d,ngr6e,ngr6f,ngr6g])">
    <option selected="selected" value="">
    <option value=1 @if($Encuesta->ngr6==1) selected @endif>No</option>
    <option value=2 @if($Encuesta->ngr6==2) selected @endif>Sí, en la UNAM </option>
    <option value=3 @if($Encuesta->ngr6==3) selected @endif>Sí, en instituciones externas (distinta) a la UNAM </option>
    <option value=4 @if($Encuesta->ngr6==4) selected @endif>Sí, por autoaprendizaje </option>
    <option value=5 @if($Encuesta->ngr6==5) selected @endif>Ya contaba con el </option>
   </select>

       </td>
</tr>


<tr>
  <td colspan="4">
  Habilidades para la computación </h2>
<table id="comp_table">
  <thead >
    <tr style='border-style: solid;
  border-color: red;'>

<th>
<h2 class="reactivo">Habilidad </h2></th>
<th>  
<h2 class="reactivo">
¿Cuánto las incrementó y/o adquirió 
durante sus estudios de licenciatura?</h2></th>
<th>
<h2 class="reactivo">
¿Han  sido  necesarias  para  
su desempeño laboral?</h2>
</th>
</tr>
  </thead>
  <tbody>
    <tr>
<td>
<h2 class="reactivo">a).- Procesadores de texto </h2></td>
<td>107a).-     
  <select class="select" id="ngr6a" name="ngr6a" >
        <option value="" selected="selected"></option>
        <option value=1 @if($Encuesta->ngr6a==1) selected @endif>Muy alto</option>
        <option value=2 @if($Encuesta->ngr6a==2) selected @endif>Alto</option>
        <option value=3 @if($Encuesta->ngr6a==3) selected @endif>Medio</option>
        <option value=4 @if($Encuesta->ngr6a==4) selected @endif>Bajo</option>
        <option value=5 @if($Encuesta->ngr6a==5) selected @endif>Nulo</option>
        <option value=0 hidden > </option>
      </select>
</td>
<td>108a).-
  <select class="select" id="ngr7a" name="ngr7a" >
    <option value="" selected="selected"></option>
    <option value=11 @if($Encuesta->ngr7a==11) selected @endif>Sí</option>
    <option value=12 @if($Encuesta->ngr7a==12) selected @endif>No</option>
    <option value=0 hidden > </option>
      </select>
</td>
    </tr>

    <tr>
<td>
<h2 class="reactivo"> b).- Diseño </h2></td>
      <td>107b).-     
      <select class="select" id="ngr6b" name="ngr6b" >
       <option value="" selected="selected"></option>
        <option value=1 @if($Encuesta->ngr6b==1) selected @endif>Muy alto</option>
        <option value=2 @if($Encuesta->ngr6b==2) selected @endif>Alto</option>
        <option value=3 @if($Encuesta->ngr6b==3) selected @endif>Medio</option>
        <option value=4 @if($Encuesta->ngr6b==4) selected @endif>Bajo</option>
        <option value=5 @if($Encuesta->ngr6b==5) selected @endif>Nulo</option>
        <option value=0 hidden > </option>
      </select>

      <td>
   108b).-
  <select class="select" id="ngr7b" name="ngr7b" >
    <option value="" selected="selected"></option>
    <option value=11 @if($Encuesta->ngr7b==11) selected @endif>Sí</option>
    <option value=12 @if($Encuesta->ngr7b==12) selected @endif>No</option>
    <option value=0 hidden > </option>
      </select></td>
      </td>
    </tr>
    <tr>
      <td> 
<h2 class="reactivo">
       c).- Programación</h2></td>
       <td>
107c).-
      <select class="select" id="ngr6c" name="ngr6c" >
       <option value="" selected="selected"></option>
        <option value=1 @if($Encuesta->ngr6c==1) selected @endif>Muy alto</option>
        <option value=2 @if($Encuesta->ngr6c==2) selected @endif>Alto</option>
        <option value=3 @if($Encuesta->ngr6c==3) selected @endif>Medio</option>
        <option value=4 @if($Encuesta->ngr6c==4) selected @endif>Bajo</option>
        <option value=5 @if($Encuesta->ngr6c==5) selected @endif>Nulo</option>
        <option value=0 hidden > </option>
      </select>
    </td>
<td>
  
108c).-
<select class="select" id="ngr7c" name="ngr7c" >
    <option value="" selected="selected"></option>
    <option value=11 @if($Encuesta->ngr7c==11) selected @endif>Sí</option>
    <option value=12 @if($Encuesta->ngr7c==12) selected @endif>No</option>
    <option value=0 hidden > </option>
      </select></td>
    </tr>
    <tr>
<td>
<h2 class="reactivo"> d).- Software especializado </h2> </td>
      <td>107d).-
      <select class="select" id="ngr6d" name="ngr6d" >
       <option value="" selected="selected"></option>
        <option value=1 @if($Encuesta->ngr6d==1) selected @endif>Muy alto</option>
        <option value=2 @if($Encuesta->ngr6d==2) selected @endif>Alto</option>
        <option value=3 @if($Encuesta->ngr6d==3) selected @endif>Medio</option>
        <option value=4 @if($Encuesta->ngr6d==4) selected @endif>Bajo</option>
        <option value=5 @if($Encuesta->ngr6d==5) selected @endif>Nulo</option>
        <option value=0 hidden > </option>
      </select>
             </td>
      <td>
            
108d).-
<select class="select" id="ngr7d" name="ngr7d" >
    <option value="" selected="selected"></option>
    <option value=11 @if($Encuesta->ngr7d==11) selected @endif>Sí</option>
    <option value=12 @if($Encuesta->ngr7d==12) selected @endif>No</option>
    <option value=0 hidden > </option>
      </select></td>
    </tr>


    <tr>
<td>
<h2 class="reactivo">
  e).- Internet y/o correo electrónico</h2></td>
<td>107e).-
      <select class="select" id="ngr6e" name="ngr6e" >
       <option value="" selected="selected"></option>
        <option value=1 @if($Encuesta->ngr6e==1) selected @endif>Muy alto</option>
        <option value=2 @if($Encuesta->ngr6e==2) selected @endif>Alto</option>
        <option value=3 @if($Encuesta->ngr6e==3) selected @endif>Medio</option>
        <option value=4 @if($Encuesta->ngr6e==4) selected @endif>Bajo</option>
        <option value=5 @if($Encuesta->ngr6e==5) selected @endif>Nulo</option>
        <option value=0 hidden > </option>
       </select>
</td>
<td>
108e).-
<select class="select" id="ngr7e" name="ngr7e" >
    <option value="" selected="selected"></option>
    <option value=11 @if($Encuesta->ngr7e==11) selected @endif>Sí</option>
    <option value=12 @if($Encuesta->ngr7e==12) selected @endif>No</option>
    <option value=0 hidden > </option>
      </select></td>
    </tr>

    <tr>
<td>
<h2 class="reactivo"> 
f).- Base de datos<BR> </h2>
</td>
      <td>107f).- 
      <select class="select" id="ngr6f" name="ngr6f" >
       <option value="" selected="selected"></option>
        <option value=1 @if($Encuesta->ngr6f==1) selected @endif>Muy alto</option>
        <option value=2 @if($Encuesta->ngr6f==2) selected @endif>Alto</option>
        <option value=3 @if($Encuesta->ngr6f==3) selected @endif>Medio</option>
        <option value=4 @if($Encuesta->ngr6f==4) selected @endif>Bajo</option>
        <option value=5 @if($Encuesta->ngr6f==5) selected @endif>Nulo</option>
        <option value=0 hidden > </option>
      </select>

</td>
      <td>
108f).-
<select class="select" id="ngr7f" name="ngr7f" >
    <option value="" selected="selected"></option>
    <option value=11 @if($Encuesta->ngr7f==11) selected @endif>Sí</option>
    <option value=12 @if($Encuesta->ngr7f==12) selected @endif>No</option>
    <option value=0 hidden > </option>
      </select></td>
    </tr>
    <tr>
<td>
<h2 class="reactivo">
g).-Hoja de cálculo</h2>
</td><td>
107g).-
   <select class="select" id="ngr6g" name="ngr6g" >
       <option value="" selected="selected"></option>
        <option value=1 @if($Encuesta->ngr6a==1) selected @endif>Muy alto</option>
        <option value=2 @if($Encuesta->ngr6a==2) selected @endif>Alto</option>
        <option value=3 @if($Encuesta->ngr6a==3) selected @endif>Medio</option>
        <option value=4 @if($Encuesta->ngr6a==4) selected @endif>Bajo</option>
        <option value=5 @if($Encuesta->ngr6a==5) selected @endif>Nulo</option>
        <option value=0 hidden > </option>
      </select>
             </td><td>
108g).-
<select class="select" id="ngr7g" name="ngr7g" >
    <option value="" selected="selected"></option>
    <option value=11 @if($Encuesta->ngr7g==11) selected @endif>Sí</option>
    <option value=12 @if($Encuesta->ngr7g==12) selected @endif>No</option>
    <option value=0 hidden > </option>
      </select>

      </td>

    </tr>
  </tbody>
</table>

  </td>
</tr>

<tr>
<td>
<h2 class="reactivo"> 
109.-¿Adquirió o mejoró el dominio del idioma inglés? </h2>
<select class="select" id="ngr8"  name="ngr8"  onchange="bloquear('ngr8',[1,5],[ngr9a,ngr9b,ngr9c,ngr9d])">
<option value="" selected="selected"></option>
<option value=1 @if($Encuesta->ngr8==1) selected @endif>No</option>
<option value=2 @if($Encuesta->ngr8==2) selected @endif>Sí, en la UNAM </option>
<option value=3 @if($Encuesta->ngr8==3) selected @endif>Sí, en instituciones externas (distinta) a la UNAM </option>
<option value=4 @if($Encuesta->ngr8==4) selected @endif>Sí, por autoaprendizaje </option>
<option value=5 @if($Encuesta->ngr8==5) selected @endif>Ya contaba con el </option>
</select>

 </td>
<td colspan="3">
<h2 class="reactivo"> 
110.- ¿Cuál es el nivel de dominio del idioma Inglés que tiene sobre las siguientes habilidades?  
</td>
</tr><tr>
<td>

<h2 class="reactivo"> 
a).- Comprensión auditiva<br> </h2> 
<select class="select" id="ngr9a"  name="ngr9a" >
<option value="" selected="selected"></option>
<option value=11 @if($Encuesta->ngr9a==11) selected @endif>Básico</option>
<option value=12 @if($Encuesta->ngr9a==12) selected @endif>Intermedio </option>
<option value=13 @if($Encuesta->ngr9a==13) selected @endif>Avanzado</option>
<option value=0 hidden > </option>
</select>
 </td>

<td>
<h2 class="reactivo">b).-
Comprensión de lectura<br></h2>
<select class="select" id="ngr9b"  name="ngr9b" >
<option value="" selected="selected"></option>
<option value=11 @if($Encuesta->ngr9b==11) selected @endif>Básico</option>
<option value=12 @if($Encuesta->ngr9b==12) selected @endif>Intermedio </option>
<option value=13 @if($Encuesta->ngr9b==13) selected @endif>Avanzado</option>
<option value=0 hidden > </option>
</select>
 </td>
<td>
<h2 class="reactivo">    c).-
Expresión oral<br></h2> 
<select class="select" id="ngr9c"  name="ngr9c" >
<option value="" selected="selected"></option>
<option value=11 @if($Encuesta->ngr9c==11) selected @endif>Básico</option>
<option value=12 @if($Encuesta->ngr9c==12) selected @endif>Intermedio </option>
<option value=13 @if($Encuesta->ngr9c==13) selected @endif>Avanzado</option>
<option value=0 hidden > </option>
</select>
</td>
<td>
<h2 class="reactivo">d).-
Expresión escrita<br></h2>
<select class="select" id="ngr9d"  name="ngr9d" >
<option value="" selected="selected"></option>
<option value=11 @if($Encuesta->ngr9d==11) selected @endif>Básico</option>
<option value=12 @if($Encuesta->ngr9d==12) selected @endif>Intermedio </option>
<option value=13 @if($Encuesta->ngr9d==13) selected @endif>Avanzado</option>
<option value=0 hidden > </option>
</select>
</td>
</tr>

<tr >
<td colspan="4">
<h2 class="reactivo">
  <br><br>
111.- Para el desempeño de su o sus trabajo ¿Qué nivel de dominio del idioma inglés requiere de las siguientes habilidades?
<br></h2>
    </td>
</tr>
<tr>
<td>
<h2 class="reactivo">
Comprensión auditiva<br></h2>
     <select class="select" id="ngr13"  name="ngr13" >
	<option value="" selected="selected"></option>
        <option value=11 @if($Encuesta->ngr13==11) selected @endif>Básico</option>
        <option value=12 @if($Encuesta->ngr13==12) selected @endif>Intermedio </option>
        <option value=13 @if($Encuesta->ngr13==13) selected @endif>Avanzado</option>
        <option value=14 @if($Encuesta->ngr13==14) selected @endif>No es necesario</option>
        <option value=0 hidden > </option>
      </select>

         </td>
<td>
<h2 class="reactivo">
Comprensión de lectura<br>  </h2>
     <select class="select" id="ngr13b"  name="ngr13b" >
	<option value="" selected="selected"></option>
        <option value=11 @if($Encuesta->ngr13b==11) selected @endif>Básico</option>
        <option value=12 @if($Encuesta->ngr13b==12) selected @endif>Intermedio </option>
        <option value=13 @if($Encuesta->ngr13b==13) selected @endif>Avanzado</option>
        <option value=14 @if($Encuesta->ngr13b==14) selected @endif>No es necesario</option>
        <option value=0 hidden > </option>
      </select>
         </td>
<td>
<h2 class="reactivo">
   Expresión oral<br></h2>
     <select class="select" id="ngr13c"  name="ngr13c" >
	<option value="" selected="selected"></option>
        <option value=11 @if($Encuesta->ngr13c==11) selected @endif>Básico</option>
        <option value=12 @if($Encuesta->ngr13c==12) selected @endif>Intermedio </option>
        <option value=13 @if($Encuesta->ngr13c==13) selected @endif>Avanzado</option>
        <option value=14 @if($Encuesta->ngr13c==14) selected @endif>No es necesario</option>
        <option value=0 hidden > </option>
      </select>
     </td>
<td>
<h2 class="reactivo">
        Expresión escrita<br></h2>
     <select class="select" id="ngr13d"  name="ngr13d" >
	<option value="" selected="selected"></option>
        <option value=11 @if($Encuesta->ngr13d==11) selected @endif>Básico</option>
        <option value=12 @if($Encuesta->ngr13d==12) selected @endif>Intermedio </option>
        <option value=13 @if($Encuesta->ngr13d==13) selected @endif>Avanzado</option>
        <option value=14 @if($Encuesta->ngr13d==14) selected @endif>No es necesario</option>
        <option value=0 hidden > </option>
      </select>
      </td>
</tr>

<tr>
<td>
<h2 class="reactivo">
112.- ¿Adquirió o mejoró el dominio de otro idioma, diferente al inglés? </h2>
<select class="select" id="ngr11a"  name="ngr11a"  onchange="bloquear('ngr11a',[11],[ngr11f,ngr11,ngr11b,ngr11c,ngr11d])">
    <option value="" selected="selected"></option>
      <option value=11 @if($Encuesta->ngr11a==11) selected @endif>No</option>
      <option value=12 @if($Encuesta->ngr11a==12) selected @endif>Sí, en la UNAM </option>
      <option value=13 @if($Encuesta->ngr11a==13) selected @endif>Sí, en instituciones externas (distinta) a la UNAM </option>
      <option value=14 @if($Encuesta->ngr11a==14) selected @endif>Sí, por autoaprendizaje </option>
      <option value=0 hidden > </option>
      </select>
    
    </td>
<td>
<h2 class="reactivo">
112a).-¿Cuál?</h2>
<select class="select" id="ngr11f"  name="ngr11f"  >
    <option value="" selected="selected"></option>
      <option value=1 @if($Encuesta->ngr11f==1) selected @endif>Francés</option>
      <option value=2 @if($Encuesta->ngr11f==2) selected @endif>Alemán</option>
      <option value=3 @if($Encuesta->ngr11f==3) selected @endif>Italiano</option>
      <option value=4 @if($Encuesta->ngr11f==4) selected @endif>Portugués</option>
      <option value=7 @if($Encuesta->ngr11f==7) selected @endif>Otro</option>
      <option value=0 hidden > </option>
      </select>

         </td>
<td></td><td></td>
</tr>
<tr>
  <td colspan="4"> <h2 class="reactivo">
113.-¿ Qué grado de dominio tiene de otro idioma diferente al inglés? </h2>
 </td>
</tr>
<tr>
<td>
<h2 class="reactivo"> 
       a).- Comprensión auditiva<br> </h2>
	<select class="select" id="ngr11"  name="ngr11" >
	<option value="" selected="selected"></option>
        <option value=11 @if($Encuesta->ngr11==11) selected @endif>Básico</option>
        <option value=12 @if($Encuesta->ngr11==12) selected @endif>Intermedio </option>
        <option value=13 @if($Encuesta->ngr11==13) selected @endif>Avanzado</option>
        <option value=0 hidden > </option>
      </select>
           </td>
<td>
<h2 class="reactivo">
        b).-Comprensión de lectura<br></h2>
	<select class="select" id="ngr11b"  name="ngr11b" >
	<option value="" selected="selected"></option>
        <option value=11 @if($Encuesta->ngr11b==11) selected @endif>Básico</option>
        <option value=12 @if($Encuesta->ngr11b==12) selected @endif>Intermedio </option>
        <option value=13 @if($Encuesta->ngr11b==13) selected @endif>Avanzado</option>
        <option value=0 hidden > </option>
      </select>
           </td>
<td>
<h2 class="reactivo">
       c).- Expresión oral<br></h2>
	<select class="select" id="ngr11c"  name="ngr11c" >
	<option value="" selected="selected"></option>
        <option value=11 @if($Encuesta->ngr11c==11) selected @endif>Básico</option>
        <option value=12 @if($Encuesta->ngr11c==12) selected @endif>Intermedio </option>
        <option value=13 @if($Encuesta->ngr11c==13) selected @endif>Avanzado</option>
        <option value=0 hidden > </option>
      </select>
           </td>
<td>
<h2 class="reactivo">
        d).- Expresión escrita&nbsp;<br></h2>
	<select class="select" id="ngr11d"  name="ngr11d" >
	<option value="" selected="selected"></option>
        <option value=11 @if($Encuesta->ngr11d==11) selected @endif>Básico</option>
        <option value=12 @if($Encuesta->ngr11d==12) selected @endif>Intermedio </option>
        <option value=13 @if($Encuesta->ngr11d==13) selected @endif>Avanzado</option>
        <option value=0 hidden > </option>
      </select>
    </td>
</tr>
<tr>
<td colspan="4">
<h1 class="seccion">HABILIDADES</h1> <br>
<h2 class="reactivo">
A continuación le pedimos que nos indique para cada una de las
 siguientes habilidades, si las desarrolló o fortaleció durante su 
 formación profesional en la UNAM y que tan necesarias son para su 
 trabajo..
</h2>
</td>
</tr>

<tr>
  <td colspan="4">

  <table id="htable">
<th  style=" background-color:{{Auth::user()->color}}"> <h2 class="reactivo" style="color:white"> Habilidad </h2></th>
<th style=" background-color:{{Auth::user()->color}}">
<h2 class="reactivo" style="color:white"> 
¿Cuánto las desarrolló durante su formación profesional? </h2>
</th>
<th  style=" background-color:{{Auth::user()->color}}">
<h2 class="reactivo" style="color:white" >
¿Qué tan necesario es para 
su desempeño laboral?</h2> 

    </th>
</tr>

    
<tr><td>
<h2 class="reactivo">
114).- Expresar verbalmente  opiniones o ideas en forma clara y precisa</h2>
</td><td>a).-
<select class="select" id="ngr14"  name="ngr14">
<option value="" selected="selected"></option>
  <option value=1 @if($Encuesta->ngr14==1) selected @endif>Muchísimo</option>
  <option value=2 @if($Encuesta->ngr14==2) selected @endif>Mucho</option>
  <option value=3 @if($Encuesta->ngr14==3) selected @endif>Regular</option>
  <option value=4 @if($Encuesta->ngr14==4) selected @endif>Poco</option>
  <option value=5 @if($Encuesta->ngr14==5) selected @endif>Nada</option>
 </select>
 </td><td>


b).-
<select class="select" id="ngr15"  name="ngr15">
<option value="" selected="selected"></option>

  <option value=1 @if($Encuesta->ngr15==1) selected @endif>Muchísimo</option>
  <option value=2 @if($Encuesta->ngr15==2) selected @endif>Mucho</option>
  <option value=3 @if($Encuesta->ngr15==3) selected @endif>Regular</option>
  <option value=4 @if($Encuesta->ngr15==4) selected @endif>Poco</option>
  <option value=5 @if($Encuesta->ngr15==5) selected @endif>Nada</option>
  <option value=0></option>
 </select>

    </td>
    </tr><tr>
<td>
<h2 class="reactivo">
<BR>115).- Expresar por escrito  opiniones o ideas en forma clara y precisa</h2>
</td><td>
a).-<select class="select" id="ngr16"  name="ngr16">
<option value="" selected="selected"></option>
  <option value=1 @if($Encuesta->ngr16==1) selected @endif>Muchísimo</option>
  <option value=2 @if($Encuesta->ngr16==2) selected @endif>Mucho</option>
  <option value=3 @if($Encuesta->ngr16==3) selected @endif>Regular</option>
  <option value=4 @if($Encuesta->ngr16==4) selected @endif>Poco</option>
  <option value=5 @if($Encuesta->ngr16==5) selected @endif >Nada</option>
 </select>
 </td><td>

b).-<select class="select" id="ngr17"  name="ngr17">
<option value="" selected="selected"></option>
  <option value=1 @if($Encuesta->ngr17==1) selected @endif >Muchísimo</option>
  <option value=2 @if($Encuesta->ngr17==2) selected @endif >Mucho</option>
  <option value=3 @if($Encuesta->ngr17==3) selected @endif >Regular</option>
  <option value=4 @if($Encuesta->ngr17==4) selected @endif >Poco</option>
  <option value=5 @if($Encuesta->ngr17==5) selected @endif >Nada</option>
  <option value=0 ></option>
 </select>

     </td>
     </tr><tr>
<td>
<h2 class="reactivo">
116).-Analizar ideas críticamente</h2> 
</td><td>
a).- 
<select class="select" id="ngr18"  name="ngr18">
<option value="" selected="selected"></option>
  <option value=1 @if($Encuesta->ngr18==1) selected @endif >Muchísimo</option>
  <option value=2 @if($Encuesta->ngr18==2) selected @endif >Mucho</option>
  <option value=3 @if($Encuesta->ngr18==3) selected @endif >Regular</option>
  <option value=4 @if($Encuesta->ngr18==4) selected @endif >Poco</option>
  <option value=5 @if($Encuesta->ngr18==5) selected @endif >Nada</option>
 </select>

 </td><td>
b).- <select class="select" id="ngr19"  name="ngr19">
<option value="" selected="selected"></option>
  <option value=1 @if($Encuesta->ngr19==1) selected @endif >Muchísimo</option>
  <option value=2 @if($Encuesta->ngr19==2) selected @endif >Mucho</option>
  <option value=3 @if($Encuesta->ngr19==3) selected @endif >Regular</option>
  <option value=4 @if($Encuesta->ngr19==4) selected @endif >Poco</option>
  <option value=5 @if($Encuesta->ngr19==5) selected @endif >Nada</option>
  <option value=0 ></option>
 </select>

     </td>
     </tr><tr>
<td>
<h2 class="reactivo"> 
 117).- Aprender en forma independiente </h2>
 </td><td>
a).- <select class="select" id="ngr20"  name="ngr20">
<option value="" selected="selected"></option>
  <option value=1 @if($Encuesta->ngr20==1) selected @endif >Muchísimo</option>
  <option value=2 @if($Encuesta->ngr20==2) selected @endif >Mucho</option>
  <option value=3 @if($Encuesta->ngr20==3) selected @endif >Regular</option>
  <option value=4 @if($Encuesta->ngr20==4) selected @endif >Poco</option>
  <option value=5 @if($Encuesta->ngr20==5) selected @endif >Nada</option>
  
 </select>
 </td><td>
b).- <select class="select" id="ngr21"  name="ngr21">
<option value="" selected="selected"></option>
  <option value=1 @if($Encuesta->ngr21==1) selected @endif >Muchísimo</option>
  <option value=2 @if($Encuesta->ngr21==2) selected @endif >Mucho</option>
  <option value=3 @if($Encuesta->ngr21==3) selected @endif >Regular</option>
  <option value=4 @if($Encuesta->ngr21==4) selected @endif >Poco</option>
  <option value=5 @if($Encuesta->ngr21==5) selected @endif >Nada</option>
  <option value=0 ></option>
 </select>

     </td>
     </tr><tr>
<td>
<h2 class="reactivo">
 118).-Actuar en el ámbito laboral conforme a la ética profesional</h2>
 </td><td>
a).-<select class="select" id="ngr22"  name="ngr22">
<option value="" selected="selected"></option>
  <option value=1 @if($Encuesta->ngr22==1) selected @endif >Muchísimo</option>
  <option value=2 @if($Encuesta->ngr22==2) selected @endif >Mucho</option>
  <option value=3 @if($Encuesta->ngr22==3) selected @endif >Regular</option>
  <option value=4 @if($Encuesta->ngr22==4) selected @endif >Poco</option>
  <option value=5 @if($Encuesta->ngr22==5) selected @endif >Nada</option>
 </select>
 </td><td>
b).-<select class="select" id="ngr23"  name="ngr23">
<option value="" selected="selected"></option>
  <option value=1 @if($Encuesta->ngr23==1) selected @endif >Muchísimo</option>
  <option value=2 @if($Encuesta->ngr23==2) selected @endif >Mucho</option>
  <option value=3 @if($Encuesta->ngr23==3) selected @endif >Regular</option>
  <option value=4 @if($Encuesta->ngr23==4) selected @endif >Poco</option>
  <option value=5 @if($Encuesta->ngr23==5) selected @endif >Nada</option>
  <option value=0 ></option>
 </select>

    </td>
    </tr><tr>
<td>
<h2 class="reactivo"> 
119).-Resolver problemas </h2>
</td><td>
  a).-
<select class="select" id="ngr24"  name="ngr24">
<option value="" selected="selected"></option>
  <option value=1 @if($Encuesta->ngr24==1) selected @endif >Muchísimo</option>
  <option value=2 @if($Encuesta->ngr24==2) selected @endif >Mucho</option>
  <option value=3 @if($Encuesta->ngr24==3) selected @endif >Regular</option>
  <option value=4 @if($Encuesta->ngr24==4) selected @endif >Poco</option>
  <option value=5 @if($Encuesta->ngr24==5) selected @endif >Nada</option>
 </select>

 </td><td>
b).-
<select class="select" id="ngr25"  name="ngr25">
<option value="" selected="selected"></option>
  <option value=1 @if($Encuesta->ngr25==1) selected @endif >Muchísimo</option>
  <option value=2 @if($Encuesta->ngr25==2) selected @endif >Mucho</option>
  <option value=3 @if($Encuesta->ngr25==3) selected @endif >Regular</option>
  <option value=4 @if($Encuesta->ngr25==4) selected @endif >Poco</option>
  <option value=5 @if($Encuesta->ngr25==5) selected @endif >Nada</option>
  <option value=0 ></option>
 </select>

     </td>
     </tr><tr>
<td>
<h2 class="reactivo">
 120).-Desarrollo una  actitud de liderazgo</h2>
 </td><td>
a).- <select class="select" id="ngr26"  name="ngr26">
<option value="" selected="selected"></option>
  <option value=1 @if($Encuesta->ngr26==1) selected @endif >Muchísimo</option>
  <option value=2 @if($Encuesta->ngr26==2) selected @endif >Mucho</option>
  <option value=3 @if($Encuesta->ngr26==3) selected @endif >Regular</option>
  <option value=4 @if($Encuesta->ngr26==4) selected @endif >Poco</option>
  <option value=5 @if($Encuesta->ngr26==5) selected @endif >Nada</option>
 </select>

 </td><td>

b).-<select class="select" id="ngr27"  name="ngr27">
<option value="" selected="selected"></option>
  <option value=1 @if($Encuesta->ngr27==1) selected @endif >Muchísimo</option>
  <option value=2 @if($Encuesta->ngr27==2) selected @endif >Mucho</option>
  <option value=3 @if($Encuesta->ngr27==3) selected @endif >Regular</option>
  <option value=4 @if($Encuesta->ngr27==4) selected @endif >Poco</option>
  <option value=5 @if($Encuesta->ngr27==5) selected @endif >Nada</option>
  <option value=0 ></option>
 </select>
      </td>
     </tr><tr>
<td>
<h2 class="reactivo"> 
121).-Usar modelos y/o métodos matemáticos para analizar datos </h2>
</td><td>
a).-  <select class="select" id="ngr28"  name="ngr28">
<option value="" selected="selected"></option>
  <option value=1 @if($Encuesta->ngr28==1) selected @endif >Muchísimo</option>
  <option value=2 @if($Encuesta->ngr28==2) selected @endif >Mucho</option>
  <option value=3 @if($Encuesta->ngr28==3) selected @endif >Regular</option>
  <option value=4 @if($Encuesta->ngr28==4) selected @endif >Poco</option>
  <option value=5 @if($Encuesta->ngr28==5) selected @endif >Nada</option>
 </select>
 </td><td>
b).-<select class="select" id="ngr29"  name="ngr29">
<option value="" selected="selected"></option>
  <option value=1 @if($Encuesta->ngr29==1) selected @endif >Muchísimo</option>
  <option value=2 @if($Encuesta->ngr29==2) selected @endif >Mucho</option>
  <option value=3 @if($Encuesta->ngr29==3) selected @endif >Regular</option>
  <option value=4 @if($Encuesta->ngr29==4) selected @endif >Poco</option>
  <option value=5 @if($Encuesta->ngr29==5) selected @endif >Nada</option>
  <option value=0 ></option>
 </select>

     </td>
     </tr><tr>
<td>
<h2 class="reactivo"> 
 <BR>122).-Formular argumentos lógicos<BR></h2>
 </td><td>
a).-<select class="select" id="ngr30"  name="ngr30">
  <option value="" selected></option>
  <option value=1 @if($Encuesta->ngr30==1) selected @endif >Muchísimo</option>
  <option value=2 @if($Encuesta->ngr30==2) selected @endif >Mucho</option>
  <option value=3 @if($Encuesta->ngr30==3) selected @endif >Regular</option>
  <option value=4 @if($Encuesta->ngr30==4) selected @endif >Poco</option>
  <option value=5 @if($Encuesta->ngr30==5) selected @endif >Nada</option>
 </select>
 </td><td>

b).- <select class="select" id="ngr31"  name="ngr31">
<option value="" selected="selected"></option>
  <option value=1 @if($Encuesta->ngr31==1) selected @endif >Muchísimo</option>
  <option value=2 @if($Encuesta->ngr31==2) selected @endif >Mucho</option>
  <option value=3 @if($Encuesta->ngr31==3) selected @endif >Regular</option>
  <option value=4 @if($Encuesta->ngr31==4) selected @endif >Poco</option>
  <option value=5 @if($Encuesta->ngr31==5) selected @endif >Nada</option>
  <option value=0 ></option>
 </select>

    </td>
    </tr><tr>
<td>
<h2 class="reactivo">
<BR> 123).-Trabajar en colaboración con otras personas</h2>
</td><td>
a).-<select class="select" id="Pregunta 130a"  name="ngr32">
<option value="" selected="selected"></option>
  <option value=1 @if($Encuesta->ngr32==1) selected @endif >Muchísimo</option>
  <option value=2 @if($Encuesta->ngr32==2) selected @endif >Mucho</option>
  <option value=3 @if($Encuesta->ngr32==3) selected @endif >Regular</option>
  <option value=4 @if($Encuesta->ngr32==4) selected @endif >Poco</option>
  <option value=5 @if($Encuesta->ngr32==5) selected @endif >Nada</option>
 </select>

 </td><td>
b).-<select class="select" id="ngr33"  name="ngr33">
<option value="" selected="selected"></option>
  <option value=1 @if($Encuesta->ngr33==1) selected @endif >Muchísimo</option>
  <option value=2 @if($Encuesta->ngr33==2) selected @endif >Mucho</option>
  <option value=3 @if($Encuesta->ngr33==3) selected @endif >Regular</option>
  <option value=4 @if($Encuesta->ngr33==4) selected @endif >Poco</option>
  <option value=5 @if($Encuesta->ngr33==5) selected @endif >Nada</option>
  <option value=0 ></option>
 </select>

    </td>
    </tr><tr>
<td>
<h2 class="reactivo"><BR> 124).-Formular ideas o pensamientos originales o innovadores
</h2>
</td><td> a.-<select class="select" id="ngr34"  name="ngr34">
<option value="" selected="selected"></option>
  <option value=1 @if($Encuesta->ngr34==1) selected @endif >Muchísimo</option>
  <option value=2 @if($Encuesta->ngr34==2) selected @endif >Mucho</option>
  <option value=3 @if($Encuesta->ngr34==3) selected @endif >Regular</option>
  <option value=4 @if($Encuesta->ngr34==4) selected @endif >Poco</option>
  <option value=5 @if($Encuesta->ngr34==5) selected @endif >Nada</option>
 </select>

    </td>
<td>
b).-  <select class="select" id="ngr35"  name="ngr35">
<option value="" selected="selected"></option>
  <option value=1 @if($Encuesta->ngr35==1) selected @endif >Muchísimo</option>
  <option value=2 @if($Encuesta->ngr35==2) selected @endif >Mucho</option>
  <option value=3 @if($Encuesta->ngr35==3) selected @endif >Regular</option>
  <option value=4 @if($Encuesta->ngr35==4) selected @endif >Poco</option>
  <option value=5 @if($Encuesta->ngr35==5) selected @endif >Nada</option>
  <option value=0 ></option>
 </select>



   </td></tr>
   </table>
  </td>
</tr>
<tr>
<td colspan="4">
<h2 class="reactivo">
<B><CENTER>Durante sus formación como universitario adquirió o desarrolló:</CENTER></B></FONT></TD></h2>

    </td>
</tr>

<tr>

<td>
<h2 class="reactivo">
125.- ¿Una cultura general amplia?</h2>
<select class="select" id="ngr36" name="ngr36" >
<option selected="selected" value="">
<option value=1 @if($Encuesta->ngr36==1) selected @endif >Totalmente de acuerdo</option>
<option value=2 @if($Encuesta->ngr36==2) selected @endif >De acuerdo</option>
<option value=3 @if($Encuesta->ngr36==3) selected @endif >Medianamente de acuerdo</option>
<option value=4 @if($Encuesta->ngr36==4) selected @endif >En desacuerdo</option>
<option value=5 @if($Encuesta->ngr36==5) selected @endif >Totalmente en desacuerdo</option>
</select>
    </td>
<td>
<h2 class="reactivo">
126.-¿Asistió a eventos artísticos dentro de la UNAM?</h2>
<select class="select" id="ngr37" name="ngr37"  onchange="artisticos()">
<option selected="selected" value="">
<option value=11 @if($Encuesta->ngr37==11) selected @endif >Sí</option>
<option value=12 @if($Encuesta->ngr37==12) selected @endif >No</option>

<option value=13 @if($Encuesta->ngr37==13) selected @endif >Asistía pero fuera de la UNAM</option>
</select>
</td>
<td>
<h2 class="reactivo">
a).-¿Con qué frecuencia asistió a eventos artísticos?</h2>
<select class="select" id="ngr37a" name="ngr37_a"  >
<option selected="selected" value="">
<option value=11 @if($Encuesta->ngr37_a==11) selected @endif >2 o 3 veces por semana</option>
<option value=12 @if($Encuesta->ngr37_a==12) selected @endif >1 vez a la semana</option>
<option value=13 @if($Encuesta->ngr37_a==13) selected @endif >1 vez al mes</option>
<option value=14 @if($Encuesta->ngr37_a==14) selected @endif >Esporadicamente</option>
<option value=0 hidden > </option>
      </select>
    </td>
<td>
<h2 class="reactivo">
b).-Motivo por el que no asistió a eventos artísticos</h2>
<select class="select" id="ngr37m" name="ngr37m"  >
<option selected="selected" value="">
<option value=1 @if($Encuesta->ngr37m==1) selected @endif >Desinterés</option>
<option value=2 @if($Encuesta->ngr37m==2) selected @endif >Falta de tiempo</option>
<option value=3 @if($Encuesta->ngr37m==3) selected @endif >Falta de instalaciones</option>
<option value=4 @if($Encuesta->ngr37m==4) selected @endif >Falta de difusión</option>
<option value=5 @if($Encuesta->ngr37m==5) selected @endif >Ya contaba con el</option>
<option value=6 @if($Encuesta->ngr37m==6) selected @endif >Otra</option>
<option value=0 hidden > </option>
      </select>

    </td>
</tr>

<tr>

<td>
<h2 class="reactivo">
127.-Fortalecer o incrementar sus valores como ciudadano</h2>
<select class="select" id="ngr42"  name="ngr42" >
<option selected="selected" value="">
<option value=1 @if($Encuesta->ngr42==1) selected @endif >Totalmente de acuerdo</option>
<option value=2 @if($Encuesta->ngr42==2) selected @endif >De acuerdo</option>
<option value=3 @if($Encuesta->ngr42==3) selected @endif >Medianamente de acuerdo</option>
<option value=4 @if($Encuesta->ngr42==4) selected @endif >En desacuerdo</option>
<option value=5 @if($Encuesta->ngr42==5) selected @endif >Totalmente en desacuerdo</option>
</select>
</td>
<td>
<h2 class="reactivo">
128.-Incrementar su concientización e interés por los problemas del medio ambiente</h2>
<select class="select" id="ngr44"  name="ngr44" >
<option selected="selected" value="">
<option value=1 @if($Encuesta->ngr44==1) selected @endif >Totalmente de acuerdo</option>
<option value=2 @if($Encuesta->ngr44==2) selected @endif >De acuerdo</option>
<option value=3 @if($Encuesta->ngr44==3) selected @endif >Medianamente de acuerdo</option>
<option value=4 @if($Encuesta->ngr44==4) selected @endif >En desacuerdo</option>
<option value=5 @if($Encuesta->ngr44==5) selected @endif >Totalmente en desacuerdo</option>
</select>
</td>
<td>
<h2 class="reactivo">
129.-Incrementar su interés por promover y participar en programas de beneficio social</h2>
<select class="select" id="ngr43"  name="ngr43" >
<option selected="selected" value="">
<option value=1 @if($Encuesta->ngr43==1) selected @endif >Totalmente de acuerdo</option>
<option value=2 @if($Encuesta->ngr43==2) selected @endif >De acuerdo</option>
<option value=3 @if($Encuesta->ngr43==3) selected @endif >Medianamente de acuerdo</option>
<option value=4 @if($Encuesta->ngr43==4) selected @endif >En desacuerdo</option>
<option value=5 @if($Encuesta->ngr43==5) selected @endif >Totalmente en desacuerdo</option>
</select>
</td>


<td colspan="2">
<h2 class="reactivo">
130.- ¿Practicó algún deporte dentro de la UNAM?</h2>
<select class="select" id="ngr40" name="ngr40"  onchange="deportes()">
<option selected="selected" value="">
  <option value=11 @if($Encuesta->ngr40==11) selected @endif >Sí</option>
<option value=12 @if($Encuesta->ngr40==12) selected @endif >No</option>
<option value=13 @if($Encuesta->ngr40==13) selected @endif >Lo practicaba fuera de la UNAM</option>

</select>
    </td>

</tr>
<tr>
  <td>
<h2 class="reactivo">
a).-¿Cuál? </h2>
<select class="select" id="ngr40_a" name="ngr40_a"  onchange="bloquear('ngr40_a',[11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42],[ngr40otro])">
<option selected="selected" value="">
<option value=11 @if($Encuesta->ngr40_a==11) selected @endif >Acondicionamiento físico</option>
<option value=12 @if($Encuesta->ngr40_a==12) selected @endif >Ajedrez</option>
<option value=13 @if($Encuesta->ngr40_a==13) selected @endif >Atletismo</option>
<option value=14 @if($Encuesta->ngr40_a==14) selected @endif >Baloncesto</option>
<option value=15 @if($Encuesta->ngr40_a==15) selected @endif >Beisbol</option>
<option value=16 @if($Encuesta->ngr40_a==16) selected @endif >Boliche</option>
<option value=17 @if($Encuesta->ngr40_a==17) selected @endif >Boxeo</option>
<option value=18 @if($Encuesta->ngr40_a==18) selected @endif >Buceo</option>
<option value=19 @if($Encuesta->ngr40_a==19) selected @endif >Canotaje</option>
<option value=20 @if($Encuesta->ngr40_a==20) selected @endif >Esgrima</option>
<option value=21 @if($Encuesta->ngr40_a==21) selected @endif >Fisicoculturismo</option>
<option value=22 @if($Encuesta->ngr40_a==22) selected @endif >Frontón</option>
<option value=23 @if($Encuesta->ngr40_a==23) selected @endif >Futbol Americano</option>
<option value=24 @if($Encuesta->ngr40_a==24) selected @endif >Futbol Soccer</option>
<option value=25 @if($Encuesta->ngr40_a==25) selected @endif >Gimnasia</option>
<option value=26 @if($Encuesta->ngr40_a==26) selected @endif >Handball</option>
<option value=27 @if($Encuesta->ngr40_a==27) selected @endif >Hockey</option>
<option value=28 @if($Encuesta->ngr40_a==28) selected @endif >Judo</option>
<option value=29 @if($Encuesta->ngr40_a==29) selected @endif >Karate</option>
<option value=30 @if($Encuesta->ngr40_a==30) selected @endif >Levantamiento de pesas</option>
<option value=31 @if($Encuesta->ngr40_a==31) selected @endif >Lucha</option>
<option value=32 @if($Encuesta->ngr40_a==32) selected @endif >Montañismo</option>
<option value=33 @if($Encuesta->ngr40_a==33) selected @endif >Natación</option>
<option value=34 @if($Encuesta->ngr40_a==34) selected @endif >Remo</option>
<option value=35 @if($Encuesta->ngr40_a==35) selected @endif >Squash</option>
<option value=36 @if($Encuesta->ngr40_a==36) selected @endif >Taekwondo</option>
<option value=37 @if($Encuesta->ngr40_a==37) selected @endif >Tenis</option>
<option value=38 @if($Encuesta->ngr40_a==38) selected @endif >Tenis de mesa</option>
<option value=39 @if($Encuesta->ngr40_a==39) selected @endif >Triatlón</option>
<option value=40 @if($Encuesta->ngr40_a==40) selected @endif >Voleibol</option>
<option value=41 @if($Encuesta->ngr40_a==41) selected @endif >Ciclismo</option>
<option value=42 @if($Encuesta->ngr40_a==42) selected @endif >Artes marciales</option>
<option value=43 @if($Encuesta->ngr40_a==43) selected @endif >Otros</option>
<option value=0 hidden > </option>
      </select>

    </td>
  <td>b).- Especifique: <INPUT type="text" class="texto " id="ngr40otro" name="ngr40otro" value="{{$Encuesta->ngr40otro}}" style="width:60%"  maxlength="110"  >
 </td>
    <td>
<h2 class="reactivo">
b).- ¿Con qué frecuencia lo practicó?</h2>
<select class="select" id="ngr40a" name="ngr40a" >
<option selected="selected" value="">
<option value=11 @if($Encuesta->ngr40a==11) selected @endif >Diario</option>
<option value=12 @if($Encuesta->ngr40a==12) selected @endif >2 o 3 veces por semana</option>
<option value=13 @if($Encuesta->ngr40a==13) selected @endif >1 vez a la semana</option>
<option value=14 @if($Encuesta->ngr40a==14) selected @endif >Esporadicamente</option>
<option value=0 hidden > </option>
      </select>
</td>
</tr>

<tr>
 <td>
<h2 class="reactivo" >  
c).- Motivo por el que no lo practicó </h2>
<select class="select" id="ngr40_b" name="ngr40_b"  >
<option selected="selected" value="">
<option value=1 @if($Encuesta->ngr40_b==1) selected @endif >Desinterés</option>
<option value=2 @if($Encuesta->ngr40_b==2) selected @endif >Falta de tiempo</option>
<option value=3 @if($Encuesta->ngr40_b==3) selected @endif >Falta de instalaciones</option>
<option value=4 @if($Encuesta->ngr40_b==4) selected @endif >Falta de promoción</option>
<option value=5 @if($Encuesta->ngr40_b==5) selected @endif >Ya contaba con el</option>
<option value=6 >Otro</option>
<option value=0 hidden > </option>
      </select>
</td>
<td >
<h2 class="reactivo"> 
131.- ¿Actualmente es miembro de alguna organización o asociación? - </h2>
<select class="select" id="ngr45"  name="ngr45" onchange="bloquear('ngr45',[2],[ngr45_a,ngr45otra])">
<option selected="selected" value="">
  <option value=1 @if($Encuesta->ngr45==1) selected @endif >Sí</option>
<option value=2 @if($Encuesta->ngr45==2) selected @endif >No</option>
</select>
    </td>
    <td>

    <h2 class="reactivo">
131a).-¿Cuál?</h2>
<select class="select" id="ngr45_a" name="ngr45_a" onchange="bloquear('ngr45_a',[1,2,3,4,5,6],[ngr45otra])">
<option  value="">
<option value=4 @if($Encuesta->ngr45_a==4) selected @endif >Afiliado a un grupo religioso</option>
<option value=3 @if($Encuesta->ngr45_a==3) selected @endif >Cultural, educativa, recreativa o deportiva</option>
<option value=5 @if($Encuesta->ngr45_a==5) selected @endif >Comunitaria o cívica</option>
<option value=6 @if($Encuesta->ngr45_a==6) selected @endif >Científica o Investigación</option>
<option value=1 @if($Encuesta->ngr45_a==1) selected @endif >Profesional</option>
<option value=2 @if($Encuesta->ngr45_a==2) selected @endif >Política</option>
<option value=7 @if($Encuesta->ngr45_a==7) selected @endif >OTRA</option>
<option value=0 hidden > </option>
      </select>
    </td>
    <td>

   
<h2 class="reactivo">131b).-Otra:  </h2>

<INPUT  id="ngr45otra" name="ngr45otra" TYPE=TEXT  class="texto"  SIZE=60 MAXLENGTH=60 value="{{$Encuesta->ngr45otra}}">

    </td>
</tr>

<tr>

<td>
<h2 class="reactivo"> 
132.-¿Conoce usted la Credencial de Egresados y sus beneficios? </h2>
<select class="select" id="conoce"  name="conoce"  >
<option selected="selected" value="">
  <option value=1 @if($Encuesta->conoce==1) selected @endif >Sí</option>
<option value=2 @if($Encuesta->conoce==2) selected @endif >No</option>
</select>
    </td>
<td>
<h2 class="reactivo">
133.-¿Ya cuenta con su credencial de Exalumnos?</h2>
<select class="select" id="cue_cre"  name="cue_cre"  onchange="bloquear('cue_cre',[2],[utiliza])">
<option selected="selected" value="">
  <option value=1 @if($Encuesta->cue_cre==1) selected @endif >Sí</option>
<option value=2 @if($Encuesta->cue_cre==2) selected @endif >No</option>
<option value=0 hidden > </option>
      </select>

    </td>
    <td colspan="2">
<h2 class="reactivo">134.-¿Ha utilizado los Beneficios que le otorga el Programa de Vinculación con los Egresados de la UNAM?  </h2>
<select class="select" id="utiliza"  name="utiliza" >
    <option selected="selected" value="">
    <option value=1 @if($Encuesta->utiliza==1) selected @endif >Sí</option>
    <option value=2 @if($Encuesta->utiliza==2) selected @endif >No</option>
    <option value=0 hidden > </option>
  </select>


    </td>
</tr>
<tr>
  <td colspan="4">
 
<h2 class="reactivo"> ¿Desea hacer algun comentario? </h2>
<select class="select" id="comen" name="ncro2" onchange="bloquear('comen',[2],[comentario])"  >
<option value="" selected></option>
    <option value='1' @if(strlen($Comentario)>2) selected @endif >Sí</option>
    <option value='2' @if(strlen($Comentario)<=1) selected @endif >No</option> 
</select>
<br>
<h2 class="reactivo"> ¿Comentario? </h2>
<br>
<textarea type="text" class="texto"   name="comentario" size="140"  id="comentario" rows="5" cols="50">
{{$Comentario}}
</textarea>
  </td>
</tr>
  </table>

  <button class="btn fixed" name='boton1'  value=0 type="summit" onclick="post_data()" style="background-color:{{Auth::user()->color}} ; color:white; display: flex;">
<i class="fas fa-save"></i> &nbsp; GUARDAR <br> SECCION
  </button>
  </form>
</div>

@endsection


@push('js')
<script>
  unhide('G');
  reactivos=document.getElementById("forma_sagrada").elements
  for (var i=0, item; item = reactivos[i]; i++) {
  // Look no need to do list[i] in the body of the loop
  console.log("'"+item.name+"' => 'required',");
}
</script>
<script>
console.log('marcandooo rojo');
 @foreach ($errors->all() as $error)
                document.getElementById( "{{str_replace(' ', '_',str_replace('The ','',str_replace(' field is required.', '', $error))) }}").style="border: 0.3vw  solid red";
                console.log( "{{str_replace(' ', '_',str_replace('The ','',str_replace(' field is required.', '', $error))) }}");
  @endforeach

</script>
@if($errors->any())
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript">
  Swal.fire({
  title: "Sección Incompleta",
  text: "faltan algunas respuestas, se marcaran en rojo",
  icon: "warning",
});
</script>

@endif


<script>
  function artisticos(){
  bloquear('ngr37',[12],[ngr37a]);
  bloquear('ngr37',[11,13],[ngr37m]);
}
function deportes(){
  bloquear('ngr40',[12],[ngr40_a,ngr40a]);
  bloquear('ngr40',[11,13],[ngr40_b]);
  bloquear('ngr40_a',[11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,0],[ngr40otro]);
}
  bloquear('ngr6',[1,5],[ngr6a,ngr6b,ngr6c,ngr6d,ngr6e,ngr6f,ngr6g]);
  bloquear('ngr8',[1,5],[ngr9a,ngr9b,ngr9c,ngr9d]);
  bloquear('ngr11a',[11],[ngr11f,ngr11,ngr11b,ngr11c,ngr11d]);
  bloquear('ngr40',[12],[ngr40_a,ngr40a]);
  
  bloquear('ngr37',[12],[ngr37a]);
  artisticos();
  deportes();
  bloquear('comen',[2],[comentario]);

  bloquear('ngr45',[2],[ngr45otra,ngr45_a]);
  bloquear('ngr45_a',[1,2,3,4,5,6,0],[ngr45otra]);
  @if($Encuesta->ncr1>=3 && $Encuesta->ncr1<=5)
  ocultar(ngr5);
  @endif

  @if($Encuesta->ncr1==6|$Encuesta->ncr1==8)
  [ngr5,ngr7a,ngr7b,ngr7c,ngr7d,ngr7e,ngr7f,ngr7g,ngr13,ngr13b,ngr13c,ngr13d,ngr15,ngr17,ngr19,ngr21,ngr23,ngr25,ngr27,ngr29,ngr31,ngr33,ngr35].forEach(ocultar);
  @endif

  bloquear('cue_cre',[2],[utiliza]);
  var warning = false;
</script>
@endpush