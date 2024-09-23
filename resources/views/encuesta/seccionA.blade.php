@extends('layouts.blank_app')

@section('content')
<h1 >
                 @if(!is_null($Encuesta->cuenta))
                 COMPLETAR ENCUESTA @else
                 HACER NUEVA ENCUESTA @endif </h1>
<div  id='datos'>  @include('encuesta.personal_data') </div>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{$error}} {{str_replace('The ','',str_replace('field is required', '', $error)) }} </li>
            @endforeach
        </ul>
    </div>
@endif
<div style="padding:1.2vw;">
<form action="{{ url('encuestas/2020/A_update/'. $Encuesta->registro) }}" method="POST" enctype="multipart/form-data" id='forma_sagrada' name='forma'>
@csrf
<table class="encuesta_table">
        <!-- primera fila  -->
<tr>
<td> <h2 class="reactivo"> FECHA EN QUE SE CAPTURA </h2> 
   <center>
    <div class="btn-group" role="group" aria-label="Basic radio toggle button group" style="z-index: 0;">
        <input type="radio" class="btn-check" name="btnradio" id="btnradioa" autocomplete="off" checked onclick="automatico();">
        <label class="btn btn-outline-danger" for="btnradioa">fecha<br> actual</label>
        <input type="radio" class="btn-check" name="btnradio" id="btnradiob" autocomplete="off" onclick="manual();">
        <label class="btn btn-outline-danger" for="btnradiob">fecha <br> anterior </label>
        </div>
        </center> <br>
        <center> <div class="form-group" id="fecha-group" style="display:none;">
       
          
          <input type="date"  class="fecha" name="fec_capt" id="fec_capt"  value="{{now()->modify('-6 hours')->format('Y-m-d')}}" /> 
          </div></td>
<td>  <h2 class="reactivo">1.- ¿Cuál es su estado civil?:</h2>
           
           <select class="select"  id="nar8" name="nar8" onchange="bloquear('nar8',[1],[nar11,nar14,nar14otra])" > 
           <option value="" selected></option>
           <option value=1  @if($Encuesta->nar8==1) selected @endif>Soltero(a)</option>
           <option value=2 @if($Encuesta->nar8==2) selected @endif>Casado(a)</option>
           <option value=3 @if($Encuesta->nar8==3) selected @endif>Divorciado(a)</option>
           <option value=4 @if($Encuesta->nar8==4) selected @endif>Unión Libre</option>
           <option value=5 @if($Encuesta->nar8==5) selected @endif>Viudo(a)</option>
            </select></td>
<td>
    <center> <h2 class="reactivo"> 2.- ¿Tiene hijos?   </h2>
         
         <select class="select" id="nar9" name="nar9"  onchange="bloquear('nar9',[2],[nar10])" >
         <option value="" selected></option>
        <option value='1' @if($Encuesta->nar9==1) selected @endif>Sí</option>
        <option value='2'@if($Encuesta->nar9==2) selected @endif>No</option> 
</select> </td>
<td>
<h2 class="reactivo">a).- ¿Cuántos?: </h2></div>
<input class="texto" type="text" id="nar10" name="nar10" size="2" maxlength="2" value="{{$Encuesta->nar10}}" > 
</center>
</td>
</tr>
<!-- segunda fila  -->
<tr>
<td colspan="2">
    <h2 class="reactivo"> 3.- ¿Cuál es el último grado de estudios de su pareja?</h2>
 
 <select class="select" id="nar11" name="nar11"   onchange="bloquear('nar11',[1,2,3,4,5,6,7,8,9,10,11,12,14],[nar11a])"  >
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
 <option value=14 @if($Encuesta->nar11==14) selected @endif >Licenciatura Trunca</option>
      
 <option value=11 @if($Encuesta->nar11==11) selected @endif >Posgrado</option>
 <option value=12 @if($Encuesta->nar11==12) selected @endif >Lo desconoce</option>
 <option value=13  @if($Encuesta->nar11==13) selected @endif >Otro (Especifíque)</option>
 <option value=0  hidden></option> 
</select>

</td>
<td colspan="2">
Otra:<input type="text" class="texto"   id="nar11a" name="nar11a" size="20" maxlength="50" @if(strlen($Encuesta->nar11a)>2) value="{{$Encuesta->nar11a}}" @else value=0 hidden @endif > 
</td>

</tr>

<!-- tercera fila  -->
<tr>
    <td colspan="2" >
        
<h2 class="reactivo">4.-Ocupación de su esposo(a)</h2>

<select class="select" id="nar14" name="nar14"  onchange="bloquear('nar14',[0,33,34,35,36,37,45,46,47,48,49,50,51,52,53,54,55,56,57,58],[nar14otra])" >
<option value="" ></option>

<option value=45 @if($Encuesta->nar14==45) selected @endif >1 Funcionarios Directores y Jefes   </option>
<option value=46 @if($Encuesta->nar14==46) selected @endif >2 Profesionistas y técnicos </option>
<option value=47 @if($Encuesta->nar14==47) selected @endif >3 Trabajadores Auxiliares en actividades administrativas  </option>
<option value=48 @if($Encuesta->nar14==48) selected @endif >4 Comerciantes, empleados en ventas y agentes de ventas  </option>
<option value=49 @if($Encuesta->nar14==49) selected @endif >5 Trabajadores en servicios personales y de vigilancia  </option>
<option value=50 @if($Encuesta->nar14==50) selected @endif >6 Trabajadores en actividades agrícolas, ganaderas, forestales, caza y pesca  </option>
<option value=51 @if($Encuesta->nar14==51) selected @endif >7 Trabajadores artesanales, en la construcción y otros oficios  </option>
<option value=52 @if($Encuesta->nar14==52) selected @endif >8 Operadores de maquinaria industrial, ensambladores, choferes y conductores de transporte  </option>
<option value=53 @if($Encuesta->nar14==53) selected @endif >9 Trabajadores en actividades elementales y de apoyo  </option>
<option value=54 @if($Encuesta->nar14==54) selected @endif >Profesor Enseñanza Superior  </option>
<option value=56 @if($Encuesta->nar14==56) selected @endif > Profesor Enseñanza Media </option>
<option value=57 @if($Encuesta->nar14==57) selected @endif > Profesor Enseñanza Básica</option>
<option value=58 @if($Encuesta->nar14==58) selected @endif >Otros profesores (Artísticos, deportes, etc.)  </option>
<option value=33 @if($Encuesta->nar14==33) selected @endif >Labores del hogar </option>
<option value=34 @if($Encuesta->nar14==34) selected @endif > Jubilado o Pensionado </option>
<option value=35 @if($Encuesta->nar14==35) selected @endif >Finado  </option>
<option value=36 @if($Encuesta->nar14==36) selected @endif >No trabaja  </option>
<option value=37 @if($Encuesta->nar14==37) selected @endif >No lo sabe  </option>
<option value=38 @if($Encuesta->nar14==38) selected @endif >Otra(Especifíque)</option>
<option value=0  hidden></option>     
</select>
    </td>
<td colspan="2">
(Especifíque)
Otra:<input type="text" class="texto" id="nar14otra" name="nar14otra" size="80" maxlength="80" @if(strlen($Encuesta->nar14otra)>2) value="{{$Encuesta->nar14otra}}" @else hidden value="0" @endif > 
    
</td>
</tr>
<!-- cuarta fila -->
<tr>
    <td colspan="4"><h2 class="reactivo"> En el transcurso de su carrera profesional: </h2>
</td>
</tr>
<tr>
<td colspan="2">
<h2 class="reactivo"> 5.-¿Cúal era el nivel maximo de estudios de su madre?  </h2>
        
       <select class="select" id="nar12" name="nar12"  onchange="escolaridad()" >
       <option value=""></option>
      <option value=1 @if($Encuesta->nar12==1) selected @endif >Sin instrucción</option>
      <option value=2 @if($Encuesta->nar12==2) selected @endif >Primaria</option;n>
      <option value=3 @if($Encuesta->nar12==3) selected @endif >Carrera técnica o comercial después de primaria</option>
      <option value=4 @if($Encuesta->nar12==4) selected @endif >Secundaria</option>
      <option value=5 @if($Encuesta->nar12==5) selected @endif >Escuela Normal</option>
      <option value=6 @if($Encuesta->nar12==6) selected @endif >Carrera técnica o comercial después de secundaria</option>
      <option value=7 @if($Encuesta->nar12==7) selected @endif >Bachillerato o vocacional</option>
      <option value=8 @if($Encuesta->nar12==8) selected @endif >Esc. Normal Superior</option>
      <option value=9 @if($Encuesta->nar12==9) selected @endif >Carrera técnica o com. después de bachillerato</option>
      <option value=10 @if($Encuesta->nar12==10) selected @endif >Licenciatura</option>
      <option value=14 @if($Encuesta->nar12==14) selected @endif >Licenciatura Trunca</option>
      
      <option value=11 @if($Encuesta->nar12==11) selected @endif >Posgrado</option>
      <option value=12 @if($Encuesta->nar12==12) selected @endif >Lo desconoce</option>
      <option value=13  @if($Encuesta->nar12==13) selected @endif >Otro (Especifíque)</option>
    
    </select>
</td>
<td >
(Especifíque)
Otra:<input type="text" class="texto" id="nar12otra" name="nar12otra"  maxlength="80" @if(strlen($Encuesta->nar14otra)>2) value="{{$Encuesta->nar14otra}}" @else hidden value=" " @endif > 
</td>
<td>
<h2 class="reactivo">
5a).-Si su madre es profesionista 
¿Cursó sus estudios en la UNAM? </h2>
      <select class="select" id="nrx" name="nrx"  >
       <option value=""></option>
       <option value=1 @if($Encuesta->nrx==1) selected @endif >SI</option>
       <option value=2  @if($Encuesta->nrx==2) selected @endif >No</option;n>
       <option value=0  hidden></option>  
      </select>
</td>
</tr>
<!-- quinta fila -->
<tr>
<td colspan="2">
<h2 class="reactivo">6.- ¿Cúal era la ocupación de su madre? </h2>   

<select class="select" id="nar15" name="nar15"  onchange="bloquear('nar15',[33,34,35,40,36,37,45,46,47,48,49,50,51,52,53,54,55,56,57,58],[nar15otra])" >
<option value="" ></option>

<option value=45 @if($Encuesta->nar15==45) selected @endif >1 Funcionarios Directores y Jefes   </option>
<option value=46 @if($Encuesta->nar15==46) selected @endif >2 Profesionistas y técnicos </option>
<option value=47 @if($Encuesta->nar15==47) selected @endif >3 Trabajadores Auxiliares en actividades administrativas  </option>
<option value=48 @if($Encuesta->nar15==48) selected @endif >4 Comerciantes, empleados en ventas y agentes de ventas  </option>
<option value=49 @if($Encuesta->nar15==49) selected @endif >5 Trabajadores en servicios personales y de vigilancia  </option>
<option value=50 @if($Encuesta->nar15==50) selected @endif >6 Trabajadores en actividades agrícolas, ganaderas, forestales, caza y pesca  </option>
<option value=51 @if($Encuesta->nar15==51) selected @endif >7 Trabajadores artesanales, en la construcción y otros oficios  </option>
<option value=52 @if($Encuesta->nar15==52) selected @endif >8 Operadores de maquinaria industrial, ensambladores, choferes y conductores de transporte  </option>
<option value=53 @if($Encuesta->nar15==53) selected @endif >9 Trabajadores en actividades elementales y de apoyo  </option>
<option value=54 @if($Encuesta->nar15==54) selected @endif >Profesor Enseñanza Superior  </option>

<option value=56 @if($Encuesta->nar15==56) selected @endif > Profesor Enseñanza Media </option>
<option value=57 @if($Encuesta->nar15==57) selected @endif > Profesor Enseñanza Básica</option>
<option value=58 @if($Encuesta->nar15==58) selected @endif >Otros profesores (Artísticos, deportes, etc.)  </option>
<option value=33 @if($Encuesta->nar15==33) selected @endif >Labores del hogar </option>
<option value=34 @if($Encuesta->nar15==34) selected @endif > Jubilado o Pensionado </option>
<option value=40 @if($Encuesta->nar15==40) selected @endif > Estudiante</option>
<option value=35 @if($Encuesta->nar15==35) selected @endif >Finado  </option>
<option value=36 @if($Encuesta->nar15==36) selected @endif >No trabajaba  </option>
<option value=37 @if($Encuesta->nar15==37) selected @endif >No lo sabe  </option>
<option value=38 @if($Encuesta->nar15==38) selected @endif >Otra(Especifíque)</option>
<option value=0  hidden></option>  
</select>
</td>
<td colspan="2">
Otra:
<input type="text" class="texto"id="nar15otra" name="nar15otra" size="10" maxlength="80"  value="{{$Encuesta->nar15otra}}" > 

</td>

</tr>

<!-- sexta columna  -->
<tr>
    <td colspan="2">

    <h2 class="reactivo">7.- ¿Cúal era el nivel maximo de estudios de su padre? </h2>
        
        <select class="select" id="nar13" name="nar13"   onchange="escolaridadp()" >
        <option value=""></option>
       <option value=1 @if($Encuesta->nar13==1) selected @endif >Sin instrucción</option>
       <option value=2 @if($Encuesta->nar13==2) selected @endif >Primaria</option;n>
       <option value=3 @if($Encuesta->nar13==3) selected @endif >Carrera técnica o comercial después de primaria</option>
       <option value=4 @if($Encuesta->nar13==4) selected @endif >Secundaria</option>
       <option value=5 @if($Encuesta->nar13==5) selected @endif >Escuela Normal</option>
       <option value=6 @if($Encuesta->nar13==6) selected @endif >Carrera técnica o comercial después de secundaria</option>
       <option value=7 @if($Encuesta->nar13==7) selected @endif >Bachillerato o vocacional</option>
       <option value=8 @if($Encuesta->nar13==8) selected @endif >Esc. Normal Superior</option>
       <option value=9 @if($Encuesta->nar13==9) selected @endif >Carrera técnica o com. después de bachillerato</option>
       <option value=10 @if($Encuesta->nar13==10) selected @endif >Licenciatura</option>
       <option value=14 @if($Encuesta->nar13==14) selected @endif >Licenciatura Trunca</option>
       <option value=11 @if($Encuesta->nar13==11) selected @endif >Posgrado</option>
       <option value=12 @if($Encuesta->nar13==12) selected @endif >Lo desconoce</option>
       <option value=13  @if($Encuesta->nar13==13) selected @endif >Otro (Especifíque)</option>
 </select>
    </td>
    <td >
(Especifíque)
Otra:<input type="text" class="texto" id="nar13otra" name="nar13otra" maxlength="80" @if(strlen($Encuesta->nar14otra)>2) value="{{$Encuesta->nar14otra}}" @else hidden value=" " @endif > 
</td>
    <td >
    <h2 class="reactivo">
7a).-Si su padre es profesionista 
¿Cursó sus estudios en la UNAM? </h2>
      <select class="select" id="nrxx" name="nrxx"  >
       <option value=""></option>
       <option value=1 @if($Encuesta->nrxx==1) selected @endif >SI</option>
       <option value=2  @if($Encuesta->nrxx==2) selected @endif >No</option;n>
       <option value=0  hidden></option>  
      </select>
    </td>  

</tr>
<tr>
    <td colspan="2">
    <h2 class="reactivo">8.-¿Cúal era la ocupación de su padre? </h2> 
    

    <select class="select" id="nar16" name="nar16"  onchange="bloquear('nar16',[33,34,35,36,37,45,46,47,48,49,50,51,52,53,54,55,56,57,58],[nar16otra])">
    <option value="" ></option>
   
   <option value=45 @if($Encuesta->nar16==45) selected @endif >1 Funcionarios Directores y Jefes   </option>
   <option value=46 @if($Encuesta->nar16==46) selected @endif >2 Profesionistas y técnicos </option>
   <option value=47 @if($Encuesta->nar16==47) selected @endif >3 Trabajadores Auxiliares en actividades administrativas  </option>
   <option value=48 @if($Encuesta->nar16==48) selected @endif >4 Comerciantes, empleados en ventas y agentes de ventas  </option>
   <option value=49 @if($Encuesta->nar16==49) selected @endif >5 Trabajadores en servicios personales y de vigilancia  </option>
   <option value=50 @if($Encuesta->nar16==50) selected @endif >6 Trabajadores en actividades agrícolas, ganaderas, forestales, caza y pesca  </option>
   <option value=51 @if($Encuesta->nar16==51) selected @endif >7 Trabajadores artesanales, en la construcción y otros oficios  </option>
   <option value=52 @if($Encuesta->nar16==52) selected @endif >8 Operadores de maquinaria industrial, ensambladores, choferes y conductores de transporte  </option>
   <option value=53 @if($Encuesta->nar16==53) selected @endif >9 Trabajadores en actividades elementales y de apoyo  </option>
   <option value=54 @if($Encuesta->nar16==54) selected @endif >Profesor Enseñanza Superior  </option>
   <option value=56 @if($Encuesta->nar16==56) selected @endif > Profesor Enseñanza Media </option>
   <option value=57 @if($Encuesta->nar16==57) selected @endif > Profesor Enseñanza Básica</option>
   <option value=58 @if($Encuesta->nar16==58) selected @endif >Otros profesores (Artísticos, deportes, etc.)  </option>
   <option value=33 @if($Encuesta->nar16==33) selected @endif >Labores del hogar </option>
    <option value=34 @if($Encuesta->nar16==34) selected @endif > Jubilado o Pensionado</option>
    
<option value=40 @if($Encuesta->nar16==40) selected @endif > Estudiante</option>
    <option value=35 @if($Encuesta->nar16==35) selected @endif >Finado  </option>
    <option value=36 @if($Encuesta->nar16==36) selected @endif >No trabajaba  </option>
    <option value=37 @if($Encuesta->nar16==37) selected @endif >No lo sabe  </option>
    <option value=38 @if($Encuesta->nar16==38) selected @endif >Otra(Especifíque)</option>
   <option value=0  hidden></option>  </select>
    </td>
<td colspan="2">
(Especifíque)
Otra:<input  type="text" class="texto" ID="nar16otra" name="nar16otra" size="30" maxlength="80"  @if(strlen($Encuesta->nar16otra)>2) value="{{$Encuesta->nar16otra}}" @else value=0 hidden @endif >   

</td>
</tr>

<!-- seccion B  -->
<tr>
<td>
<h2 class="reactivo">9).-¿Tipo de bachillerato que cursó?   </h2>
    
    <select class="select" id="nbr1" name="nbr1" >
 <option value="" selected></option>
            <option @if($Encuesta->nbr1==1) selected @endif  value=1>CCH</option>
            <option @if($Encuesta->nbr1==2) selected @endif value=2>ENP</option>
            <option @if($Encuesta->nbr1==3) selected @endif value=3>BACH_PUB.</option>
            <option @if($Encuesta->nbr1==4) selected @endif value=4>BACH_PRIV.</option>
            <option @if($Encuesta->nbr1==5) selected @endif value=5>Sin BACH.</option>
       </select>
</td>
<td>
<h2 class="reactivo">10).- ¿Tiene una segunda Licenciatura?</h2>
 
 <select class="select" id= "ner20"  name="ner20"  onchange="bloquear('ner20',[1],[ner20a,ner20txt])" >
   <option selected="selected" value="">
   <option value=1 @if($Encuesta->ner20==1) selected @endif >No </option>
   <option value=2 @if($Encuesta->ner20==2) selected @endif >Si, la estoy cursando</option>
   <option value=3 @if($Encuesta->ner20==3) selected @endif >Si, ya la concluí</option>
   <option value=4 @if($Encuesta->ner20==4) selected @endif >Si, Inconclusa</option>
 </select>
</td>
<td>
<h2 class="reactivo">10a).- ¿Cuál? </h2>
 <INPUT class="texto" ID="ner20txt" NAME="ner20txt" TYPE=TEXT value="{{$Encuesta->ner20txt}}" MAXLENGTH=100 >
</td>
<td>
<h2 class="reactivo">10b).¿La ejerce?  </h2>
   <select class="select" id="ner20a" name="ner20a" >
   <option  value="">
   <option value=1 @if($Encuesta->ner20a==1) selected @endif >No</option>
   <option value=2 @if($Encuesta->ner20a==2) selected @endif >Si</option>
   <option value=0  hidden></option>   
  </select>
</td>
</tr>

<!-- seccion b segunda fila -->
<td>
<h2 class="reactivo">11).-¿Bajo qué sistema de enseñanza realizó sus estudios de licenciatura? </h2>
 
 <select class="select" id="nar1" name="nar1" >
 <option value="" ></option>
 <option value=1  @if($Encuesta->nar1==1) selected @endif >Abierto</option>
 <option value=2 @if($Encuesta->nar1==2) selected @endif >A distancia</option>
 <option value=3 @if($Encuesta->nar1==3) selected @endif >Presencial</option>
 </select>  
</td>

<td>
<h2 class="reactivo">12).-¿Durante sus estudios de bachillerato tuvo alguna beca?    </h2>
  
  <select class="select" id="nar2a" name="nar2a"  onchange='check_beca()'   >
  <option value="" selected></option>
  
  <option value=1 @if($Encuesta->nar2a==1) selected @endif >No</option>
    <option value=2 @if($Encuesta->nar2a==2) selected @endif >Sí, del Programa de Fundación UNAM</option>
    <option value=4 @if($Encuesta->nar2a==4) selected @endif>Sí, de otro programa Ej. Prepa Sí</option>
               </select>  
</td>
<td>
 
<h2 class="reactivo">13).- ¿Durante sus estudios de licenciatura tuvo alguna beca?   </h2>

<select class="select" id="binbeca" name="binbeca"   onchange="check_beca()">
<option selected="selected" value="">
 <option value=1 @if($Becas->count()>0) selected @endif>Sí (Especifíque)</option>
 <option value=2 @if($Becas->count()==0) selected @endif>No (Pase a la 15)</option>
  </select>


  
</td>
<td>

</td>
<tr >
  <td ></td>
<td colspan="3"> 
<h2 class="reactivo">13a).- ¿Cúal?   </h2>
  <div id="becasdiv" >
@foreach($Becas_options  as $o)
<table>
  <tr>
    <td><input type="checkbox" name="opcion{{$o->clave}}" @if($Becas->where('clave_opcion','=',$o->clave)->count()>0) checked @endif/>
    
  </td>
    <td><label for="scales">{{$o->descripcion}}</label></td>
  </tr>
</table>

  <br>
@endforeach
</div>
 </td>
</tr>
<tr>
<td  colspan="2">
<h2 class="reactivo">14).- ¿En qué medida la beca o becas que recibió contribuyeron a apoyar su desempeño académico? </h2>
 
 
 
   <select class="select" id="nar4a" name="nar4a" >
 <option value="" selected></option>
 <option value=1 @if($Encuesta->nar4a==1) selected @endif>Muchisimo</option>
 <option value=2 @if($Encuesta->nar4a==2) selected @endif>Mucho</option>
 <option value=3 @if($Encuesta->nar4a==3) selected @endif>Regular</option>
 <option value=4 @if($Encuesta->nar4a==4) selected @endif>Poco</option>
 <option value=5 @if($Encuesta->nar4a==5) selected @endif>Nada</option>
 <option value=0  hidden></option>   
</select>
</td>
<td  colspan="2">
<h2 class="reactivo">15).- ¿En qué medida la beca o becas que recibió contribuyeron a apoyar la conclusión de sus estudios? </h2>
 
 &nbsp;   <select class="select" id="nar5a" name="nar5a" >
 <option value=""></option>
 <option value=1 @if($Encuesta->nar5a==1) selected @endif>Muchisimo</option>
 <option value=2 @if($Encuesta->nar5a==2) selected @endif>Mucho</option>
 <option value=3 @if($Encuesta->nar5a==3) selected @endif>Regular</option>
 <option value=4 @if($Encuesta->nar5a==4) selected @endif>Poco</option>
 <option value=5 @if($Encuesta->nar5a==5) selected @endif>Nada</option>
 <option value=0  hidden></option>   
</select> 
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
  unhide('A');
//   reactivos=document.getElementById("forma_sagrada").elements
//   for (var i=0, item; item = reactivos[i]; i++) {
//   // Look no need to do list[i] in the body of the loop
//   console.log("'"+item.name+"' => 'required',");
// }
</script>
<script>
 @foreach ($errors->all() as $error)
                document.getElementById( "{{str_replace('The ','',str_replace(' field is required.', '', $error)) }}").style="border: 0.3vw  solid red";
  @endforeach
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
  function escolaridad(){
    bloquear('nar12',[1,2,3,4,5,6,7,8,9,12,13],[nrx])
    bloquear('nar12',[1,2,3,4,5,6,7,8,9,10,11,12,14],[nar12otra])
  }
  function escolaridadp(){
    bloquear('nar13',[1,2,3,4,5,6,7,8,9,12,13],[nrxx])
    bloquear('nar13',[1,2,3,4,5,6,7,8,9,10,11,12,14],[nar13otra])
  }
  function check_beca(){
    bloquear('binbeca',[2],[becasdiv]);
  console.log('executing function beca');
  nar2a=document.getElementById("nar2a").value;
  nar3a=document.getElementById("binbeca").value;
  console.log(nar3a);
  if(nar2a==1 && nar3a==2){
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
 
   bloquear('nar8',[1],[nar11,nar14,nar14otra]);
   bloquear('nar9',[2],[nar10]);
   bloquear('binbeca',[2],[becasdiv]);
   check_beca();
   escolaridad();
   escolaridadp();
   bloquear('nar14',[0,33,34,35,36,37,45,46,47,48,49,50,51,52,53,54,55,56,57,58],[nar14otra]);
   bloquear('ner20',[1],[ner20a,ner20txt]);
   bloquear('nar15',[33,34,35,36,37,45,46,47,48,49,50,51,52,53,54,55,56,57,58],[nar15otra])
   var warning = false;
</script>


@endpush