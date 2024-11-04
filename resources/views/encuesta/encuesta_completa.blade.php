@extends('layouts.blank_app')

@section('content')
<h1 >
                 @if(!is_null($Encuesta->cuenta))
                 COMPLETAR ENCUESTA @else
                 HACER NUEVA ENCUESTA @endif </h1>

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
<td>  <h2 class="reactivo">1.- Estado civil:</h2>
           
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
         
         <select class="select" @if($errors->first('nar9')) style="border: 0.3vw  solid red;" @endif id="nar9" name="nar9"  onchange="bloquear('nar9',[2],[nar10])" >
         <option value="" selected></option>
        <option value='1' @if($Encuesta->nar9==1) selected @endif>Sí</option>
        <option value='2'@if($Encuesta->nar9==2) selected @endif>No</option> 
</select> </td>
<td>
<h2 class="reactivo">a).- ¿Cuántos?: </h2></div>
<input class="texto" type="text" id="nar10" name="nar10" size="2" maxlength="2" @if(strlen($Encuesta->nar10)>1) value="{{$Encuesta->nar10}}" @else value="0" hidden @endif> 
</center>
</td>
</tr>
<!-- segunda fila  -->
<tr>
<td colspan="2">
    <h2 class="reactivo"> 3.- Nivel de estudios de su esposo(a)</h2>
 
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
<option value=34 @if($Encuesta->nar14==34) selected @endif > Jubilado  </option>
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
    <td colspan="4"><h2 class="reactivo"> Cuál es o era en caso de haber fallecido el: </h2>
</td>
</tr>
<tr>
<td colspan="2">
<h2 class="reactivo"> 5.- Nivel de estudios de su madre  </h2>
        
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
5a).-¿Si su madre es profesionista 
cursó sus estudios en la UNAM? </h2>
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
<h2 class="reactivo">6.- La ocupación de su madre (cuando cursaba la carrera )</h2>   

<select class="select" id="nar15" name="nar15"  onchange="bloquear('nar15',[33,34,35,36,37,45,46,47,48,49,50,51,52,53,54,55,56,57,58],[nar15otra])" >
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
<option value=34 @if($Encuesta->nar15==34) selected @endif > Jubilado  </option>
<option value=35 @if($Encuesta->nar15==35) selected @endif >Finado  </option>
<option value=36 @if($Encuesta->nar15==36) selected @endif >No trabaja  </option>
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

    <h2 class="reactivo">7.- Nivel de estudios de su padre</h2>
        
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
7a).-¿Si su padre es profesionista 
cursó sus estudios en la UNAM? </h2>
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
    <h2 class="reactivo">8.- La ocupación de su padre (cuando cursaba la carrera )</h2> 
    

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
    <option value=34 @if($Encuesta->nar16==34) selected @endif > Jubilado  </option>
    <option value=35 @if($Encuesta->nar16==35) selected @endif >Finado  </option>
    <option value=36 @if($Encuesta->nar16==36) selected @endif >No trabaja  </option>
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
 </select>
</td>
<td>
<h2 class="reactivo">10a).- ¿Cuál? </h2>
 <INPUT class="texto" ID="ner20txt" NAME="ner20txt" TYPE=TEXT value="{{$Encuesta->ner20txt}}" MAXLENGTH=40 >
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
<h2 class="reactivo">12).-¿Durante sus estudios de bachillerato fue becario?    </h2>
  
  <select class="select" id="nar2a" name="nar2a"  onchange=check_beca()   >
  <option value="" selected></option>
  
  <option value=1 @if($Encuesta->nar2a==1) selected @endif >No</option>
    <option value=2 @if($Encuesta->nar2a==2) selected @endif >Sí, del Programa de Fundación UNAM</option>
    <option value=3 @if($Encuesta->nar2a==3) selected @endif>Sí, del Programa de Alta Exigencia Académica</option >
    <option value=4 @if($Encuesta->nar2a==4) selected @endif>Sí, de otro programa</option>
               </select>  
</td>
<td>
 
<h2 class="reactivo">13).- ¿Durante sus estudios de licenciatura fue becario?   </h2>
 
 <select class="select" id="nar3a" name="nar3a"  onchange=check_beca() >
 
 <option value="" selected></option>
 <option value=1 @if($Encuesta->nar3a==1) selected @endif >No</option>
  <option value=2 @if($Encuesta->nar3a==2) selected @endif >Sí, del Programa de Fundación UNAM</option>
  <option value=6 @if($Encuesta->nar3a==6) selected @endif > Beca de Excelencia Bécalos</option>
  <option value=7 @if($Encuesta->nar3a==7) selected @endif > Beca para Alumnos Deportistas de Equipos Representativos de la UNAM</option>
  <option value=8 @if($Encuesta->nar3a==8) selected @endif > Programa de Apoyo Nutricional </option>
  <option value=9 @if($Encuesta->nar3a==9) selected @endif >Beca de Apoyo a Grupos Vulnerables Provenientes de Zonas Marginadas del País 2020 </option>
  <option value=10 @if($Encuesta->nar3a==10) selected @endif > Beca para Disminuir el Bajo Rendimiento Académico</option>
  <option value=11 @if($Encuesta->nar3a==11) selected @endif > Beca de Fortalecimiento y Beca de Alta Exigencia Académica</option>
  <option value=12 @if($Encuesta->nar3a==12) selected @endif > Beca de Fortalecimiento Académico para las Mujeres Universitarias</option>
  <option value=13 @if($Encuesta->nar3a==13) selected @endif >Beca Egresados Alto Rendimiento (TITULACION) </option>
  <option value=14 @if($Encuesta->nar3a==14) selected @endif >Beca Especialidad (TITULACION) </option>
  <option value=3 @if($Encuesta->nar3a==3) selected @endif >Sí, de otro programa</option>
  </select>   
</td>
<td></td>
<tr >
<td colspan="4"> 
    <h2 class="reactivo"> En qué medida la beca o becas que recibió contribuyeron a apoyar: </h2>
 </td>
</tr>
<tr>
<td  colspan="2">
<h2 class="reactivo">14).- Su desempeño académico </h2>
 
 
 
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
<h2 class="reactivo">15).- La conclusión de sus estudios </h2>
 
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

<table class="encuesta_table">
        <!-- primera fila  -->
<tr>
<td>
<h2 class="reactivo">61.- ¿Actualmente está trabajando? </h2> 
 
    
 <select class="select" id="ncr1" name="ncr1"  onchange='seccionc2()'>
<option selected  value="">Seleccione...</option>
<option value=1 @if($Encuesta->ncr1==1) selected @endif>Sí (permanente)</option>
<option value=2 @if($Encuesta->ncr1==2) selected @endif>Sí (eventual)</option>
<option value=3 @if($Encuesta->ncr1==3) selected @endif>No (Sin buscar trabajo), (pase a la 42)</option>
<option value=4 @if($Encuesta->ncr1==4) selected @endif>No (En búsqueda de trabajo), (pase a la 42)</option>
<option value=5 @if($Encuesta->ncr1==5) selected @endif>Residente (Médico) (conteste  la 2)</option>
<option value=6 @if($Encuesta->ncr1==6) selected @endif>Nunca ha trabajado, (pase a la 42 y despues a la 63)</option>
<option value=7 @if($Encuesta->ncr1==7) selected @endif>Becario</option>
</select>
</td>
 <td colspan="2">
 <h2 class="reactivo"> 62.- Nombre de la empresa o institución donde trabaja </h2>
 <INPUT type="text" class="texto" id="ncr2" name="ncr2" value="{{$Encuesta->ncr2}}" maxlength="220"  >

 </td>
 <td>
  <h2 class="reactivo"> 63.-Estado donde se ubica </h2> 


<select class="select" id="ncr2a"  name="ncr2a" onchange="bloquear('ncr2a',[0,1,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33],[ncr2ext])"> 
<option selected  value=""></option>
<option value=1 @if($Encuesta->ncr2a==1) selected @endif>CDMX</option>
<option value=2 @if($Encuesta->ncr2a==2) selected @endif>EXTRANJERO</option>
<option value=3 @if($Encuesta->ncr2a==3) selected @endif>Aguascalientes</option>
<option value=4 @if($Encuesta->ncr2a==4) selected @endif>Baja California</option>
<option value=5 @if($Encuesta->ncr2a==5) selected @endif>Baja California Sur</option>
<option value=6 @if($Encuesta->ncr2a==6) selected @endif>Campeche</option>
<option value=7 @if($Encuesta->ncr2a==7) selected @endif>Chiapas</option>
<option value=8 @if($Encuesta->ncr2a==8) selected @endif>Chihuahua</option>
<option value=9 @if($Encuesta->ncr2a==9) selected @endif>Coahuila</option>
<option value=10 @if($Encuesta->ncr2a==10) selected @endif>Colima</option>
<option value=11 @if($Encuesta->ncr2a==11) selected @endif>Durango</option>
<option value=12 @if($Encuesta->ncr2a==12) selected @endif>Guanajuato</option>
<option value=13 @if($Encuesta->ncr2a==13) selected @endif>Guerrero</option>
<option value=14 @if($Encuesta->ncr2a==14) selected @endif>Hidalgo</option>
<option value=15 @if($Encuesta->ncr2a==15) selected @endif>Jalisco</option>
<option value=16 @if($Encuesta->ncr2a==16) selected @endif>Estado de México</option>
<option value=17 @if($Encuesta->ncr2a==17) selected @endif>Michoacán</option>
<option value=18 @if($Encuesta->ncr2a==18) selected @endif>Morelos</option>
<option value=19 @if($Encuesta->ncr2a==19) selected @endif>Nayarit</option>
<option value=20 @if($Encuesta->ncr2a==20) selected @endif>Nuevo León</option>
<option value=21 @if($Encuesta->ncr2a==21) selected @endif>Oaxaca</option>
<option value=22 @if($Encuesta->ncr2a==22) selected @endif>Puebla</option>
<option value=23 @if($Encuesta->ncr2a==23) selected @endif>Querétaro</option>
<option value=24 @if($Encuesta->ncr2a==24) selected @endif>Quintana Roo</option>
<option value=25 @if($Encuesta->ncr2a==25) selected @endif>San Luis Potosí</option>
<option value=26 @if($Encuesta->ncr2a==26) selected @endif>Sinaloa</option>
<option value=27 @if($Encuesta->ncr2a==27) selected @endif>Sonora</option>
<option value=28 @if($Encuesta->ncr2a==28) selected @endif>Tabasco</option>
<option value=29 @if($Encuesta->ncr2a==29) selected @endif>Tamaulipas</option>
<option value=30 @if($Encuesta->ncr2a==30) selected @endif>Tlaxcala</option>
<option value=31 @if($Encuesta->ncr2a==31) selected @endif>Veracruz</option>
<option value=32 @if($Encuesta->ncr2a==32) selected @endif>Yucatán</option>
<option value=33 @if($Encuesta->ncr2a==33) selected @endif>Zacatecas</option>
<option value=0  hidden></option>   
</select>

<h2 class="reactivo">63a.- Extranjero Especifique: </h2>


 <INPUT type="text" class="texto " id="ncr2ext" name="ncr2ext" value="{{$Encuesta->ncr2text}}" style="width:60%"  maxlength="110"  >


</td>
</tr>

<tr>
<td>
<h2 class="reactivo"> 64.- La empresa o institución donde trabaja es: 
</h2>


<select class="select" id="ncr3"  name="ncr3" > 
<option selected  value=""></option>
<option value=1 @if($Encuesta->ncr3==1) selected @endif>Pública</option>
<option value=2 @if($Encuesta->ncr3==2) selected @endif>Privada</option>
<option value=3 @if($Encuesta->ncr3==3) selected @endif>Social</option>
<option value=0  hidden></option>   
</select>
    </td>
<td>
<h2 class="reactivo">65.- ¿En qué sector se ubica? </h2>


<select class="select" id="ncr4" name="ncr4"   onchange="bloquear('ncr4',[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,22,23],[ncr4a])">
<option selected="selected" value="">
<option value=1 @if($Encuesta->ncr4==1) selected @endif> Agricultura, ganadería, aprovechamiento forestal, caza y pesca</option>
<option value=19 @if($Encuesta->ncr4==19) selected @endif>Asociaciones y agrupaciones</option>
<option value=20 @if($Encuesta->ncr4==20) selected @endif>Actividades de gobierno, organismos internacionales y extraterritoriales</option>
<option value=4 @if($Encuesta->ncr4==4) selected @endif>Construcción</option>
<option value=6 @if($Encuesta->ncr4==6) selected @endif>Comercio al por mayor</option>
<option value=7 @if($Encuesta->ncr4==7) selected @endif>Comercio al por menor</option> 
<option value=13 @if($Encuesta->ncr4==13) selected @endif>Dirección de corporativos y empresas</option>
<option value=23 @if($Encuesta->ncr4==23) selected @endif>Editorial</option>
<option value=3 @if($Encuesta->ncr4==3) selected @endif>Electricidad, agua y suministro de gas</option>
<option value=5 @if($Encuesta->ncr4==5) selected @endif>Industrias manufactureras o de la transformación</option>
<option value=9 @if($Encuesta->ncr4==9) selected @endif>Información en medios masivos</option>
<option value=2 @if($Encuesta->ncr4==2) selected @endif>Minería</option>
<option value=10 @if($Encuesta->ncr4==10) selected @endif>Servicios financieros y de seguros</option>
<option value=11 @if($Encuesta->ncr4==11) selected @endif>Servicio inmobiliario y de alquiler de bienes muebles e intangibles</option>
<option value=12 @if($Encuesta->ncr4==12) selected @endif>Servicios profesionales, científicos y técnicos</option>
<option value=14 @if($Encuesta->ncr4==14) selected @endif>Servicios de apoyo a los negocios, manejo de desecho y servicios de remediación</option>
<option value=15 @if($Encuesta->ncr4==15) selected @endif>Servicios de salud</option>
<option value=16 @if($Encuesta->ncr4==16) selected @endif>Servicios educativos</option>
<option value=17 @if($Encuesta->ncr4==17) selected @endif>Servicios de esparcimiento, cultural, deportivos y otros centros recreativos</option>
<option value=18 @if($Encuesta->ncr4==18) selected @endif>Servicios de alojamiento temporal, de preparación de alimentos y bebidas (hotel, restaurant, bar) </option>
<option value=8 @if($Encuesta->ncr4==8) selected @endif>Transporte, correos y almacenamiento</option>
<option value=22 @if($Encuesta->ncr4==22) selected @endif>Telecomunicaciones </option>
<option value=21 @if($Encuesta->ncr4==21) selected @endif>Otro (Especifíque)</option>
<option value=0  hidden></option>   
</select><br>

    </td>
<td>
<h2 class="reactivo">

65a).- Otra:</h2> 
<input  class="texto" id="ncr4a" name="ncr4a"  maxlength="65" value=0 > 
</td>
<td>
<h2 class="reactivo"> 66.-Aproximadamente, ¿cuántas personas laboran en la empresa?  </h2>

<select class="select" id="ncr5" name="ncr5"  >
  <option selected="selected" value="">
  <option value=1 @if($Encuesta->ncr5==1) selected @endif> Hasta 15 empleados</option>
  <option value=2 @if($Encuesta->ncr5==2) selected @endif>Entre 16 y 100 empleados </option>
  <option value=3 @if($Encuesta->ncr5==3) selected @endif>Entre 101 y 250 empleados</option>
  <option value=4 @if($Encuesta->ncr5==4) selected @endif>Más de 251 empleados</option>
  <option value=0  hidden></option>   
</select>
</tr>

<tr>
<td>
<h2 class="reactivo"> 67.- ¿Cuál es su condición en el trabajo? </h2>

<select class="select" id="ncr6a2"  name="ncr6" onchange="autoempleo()">
    <option selected="selected" value="">
    <option value=1 @if($Encuesta->ncr6<=3 && $Encuesta->ncr6>=1) selected @endif >Autoempleo</option>
    <option value=4 @if($Encuesta->ncr6==4) selected @endif>Empleado </option>
    <option value=5 @if($Encuesta->ncr6==5) selected @endif>Otro (Especifíque)</option>
    <option value=0  hidden></option>   
</select>

    
        </td>
<td>
<h2 class="reactivo"> 67a.-¿Tipo de autoempleo? </h2>
<select class="select" id="ncr6a" name="ncr6t" >
<option selected="selected" value="">
<option value=2 @if($Encuesta->ncr6==2) selected @endif>Propietario</option>
    <option value=3 @if($Encuesta->ncr6==3) selected @endif>Profesional independiente</option>
    <option value=0  hidden></option>   
</select>
<br>
    </td>
<td>
<h2 class="reactivo">
 Otra: </h2><input type="text" class="texto" id="ncr6otra" name="ncr6_a" style="width:60%" maxlength="65" value=" " > 
     </td>
<td>

<h2 class="reactivo">68.- ¿Cuál es su puesto? </h2>


 <INPUT type="text" class="texto" id="ncr7a" name="ncr7_a" value="{{$Encuesta->ncr7_a}}" style="width:60%"  maxlength="110"  >

    </td>
</tr>

<tr>
<td>
<h2 class="reactivo">69.- ¿Requiere tener título profesional para el puesto que ocupa? </h2>


<select class="select" id="ncr7b" name="ncr7b"  >
    <option selected="selected" value="">
    <option value=1 @if($Encuesta->ncr7b==1) selected @endif>Sí</option>
    <option value=2 @if($Encuesta->ncr7b==2) selected @endif>No</option> 
    <option value=0  hidden></option>   
</select>

        </td>
<td>
<h2 class="reactivo"> 70.- En su trabajo,¿tiene personal a su cargo? </h2>
<select class="select" id="ncr8" name="ncr8"  onchange="bloquear('ncr8',[2],[ncr9])" >
    <option selected="selected" value="">
    <option value=1 @if($Encuesta->ncr8==1) selected @endif>Sí</option>
    <option value=2 @if($Encuesta->ncr8==2) selected @endif>No</option>
    <option value=0  hidden></option>   
 </select>
        </td>
<td>
<h2 class="reactivo"> 71.- ¿Cuántas personas trabajan con usted? </h2>


<select class="select" id="ncr9"  name="ncr9"  >
    <option selected="selected" value="">
    <option value=1 @if($Encuesta->ncr9==1) selected @endif>1 a 5 </option>
    <option value=2 @if($Encuesta->ncr9==2) selected @endif>6 a 10</option> 
    <option value=3 @if($Encuesta->ncr9==3) selected @endif>11 a 20</option> 
    <option value=4 @if($Encuesta->ncr9==4) selected @endif>21 a 30</option> 
    <option value=5 @if($Encuesta->ncr9==5) selected @endif>31 o más</option> 
    <option value=0  hidden></option>   
</select>
    </td>
<td>
<h2 class="reactivo">72.- ¿Su trabajo es de tiempo completo?</h2> 
<select class="select" id="ncr10" name="ncr10"  >
    <option selected="selected" value="">
    <option value=1 @if($Encuesta->ncr10==1) selected @endif>Sí</option>
    <option value=2 @if($Encuesta->ncr10==2) selected @endif>No</option> 
    <option value=0  hidden></option>   
</select>
        </td>
</tr>

<tr>
<td>
<h2 class="reactivo"> 73.- ¿Qué tanto está relacionado su trabajo actual con su profesión? </h2> 

<select class="select" id="ncr11" name="ncr11"   onchange="bloquear('ncr11',[1,2],[ncr15])" >
  <option selected="selected" value="">
  <option value=1 @if($Encuesta->ncr11==1) selected @endif>Muy relacionado</option>
  <option value=2 @if($Encuesta->ncr11==2) selected @endif>Medianamente relacionado</option> 
  <option value=3 @if($Encuesta->ncr11==3) selected @endif>No está relacionado</option> 
  <option value=0  hidden></option>   

</select>
    </td>
<td>
<h2 class="reactivo">74.- ¿Que actividades realiza? 
Especifique:</h2>
<textarea type="text" class="texto" id="ncr12_a"  rows="3"  name="ncr12_a" maxlength="500"  > {{$Encuesta->ncr12_a}} </textarea>
    </td>
<td>
<h2 class="reactivo"> 75.- ¿Si su trabajo no está relacionado con su carrera
         es porque usted asílo decidió? </h2>

<select class="select" id="ncr15" name="ncr15"  >
<option selected="selected" value="">
    <option value=1 @if($Encuesta->ncr15==1) selected @endif>Sí</OPTION>
    <option value=2 @if($Encuesta->ncr15==2) selected @endif>No</OPTION> 
    <option value=0  hidden></option>   
</select>

    </td>
<td>
<h2 class="reactivo"> 76.- ¿Cómo considera qué lo preparó el estudio de la carrera para el desempeño de su trabajo actual? </h2>
    
    <select class="select" id="ncr16" name="ncr16"   > 
           <option selected="selected" value="">
          <option value=1 @if($Encuesta->ncr16==1) selected @endif>Muy Bien</option>
          <option value=2 @if($Encuesta->ncr16==2) selected @endif>Bien</option>
          <option value=3 @if($Encuesta->ncr16==3) selected @endif>Medianamente</option>
          <option value=4 @if($Encuesta->ncr16==4) selected @endif>Mal</option>
          <option value=5 @if($Encuesta->ncr16==5) selected @endif>Muy mal</option>
          <option value=0  hidden></option>   
 </select>
    
             </td>
</tr>
<tr>
<td>
<h2 class="reactivo">77.¿Cuál es su grado de satisfacción con su trabajo actual? </h2>
         <select class="select" id="ncr17" name="ncr17" >  
       <option selected="selected" value="">
       <option value=1 @if($Encuesta->ncr17==1) selected @endif>Muy satisfecho(a)</option>
       <option value=2 @if($Encuesta->ncr17==2) selected @endif>Satisfecho(a)</option>
       <option value=3 @if($Encuesta->ncr17==3) selected @endif>Medianamente satisfecho(a)</option>
       <option value=4 @if($Encuesta->ncr17==4) selected @endif>Poco satisfecho(a)</option>
       <option value=5 @if($Encuesta->ncr17==5) selected @endif>Nada satisfecho(a)</option>
       <option value=0  hidden></option>   
</select>
             </td>
<td>
<h2 class="reactivo">78.- ¿Considera que el salario que percibe en su  trabajo es congruente con su preparación?
        </h2>
    
       <select class="select" id="ncr18" name="ncr18">  
       <option selected="selected" value="">
       <option value=1 @if($Encuesta->ncr18==1) selected @endif>Totalmente de acuerdo</option>
       <option value=2 @if($Encuesta->ncr18==2) selected @endif>De acuerdo</option>
       <option value=3 @if($Encuesta->ncr18==3) selected @endif>Medianamente de acuerdo</option>
       <option value=4 @if($Encuesta->ncr18==4) selected @endif>En desacuerdo</option>
       <option value=5 @if($Encuesta->ncr18==5) selected @endif>Totalmente en desacuerdo</option>
       <option value=0  hidden></option>   
</select>
    
           </td>
<td>
<h2 class="reactivo">79.- ¿Considera que las actividades y responsabilidades que tiene 
        en su trabajo, corresponden a su nivel educativo?  </h2>
    
       <select class="select" id="ncr19" name="ncr19" > 
       <option selected="selected" value="">
       <option value=5 @if($Encuesta->ncr19==5) selected @endif>Totalmente de acuerdo</option>   
       <option value=4 @if($Encuesta->ncr19==4) selected @endif>De acuerdo</option>
       <option value=3 @if($Encuesta->ncr19==3) selected @endif>Medianamente de acuerdo</option>
       <option value=2 @if($Encuesta->ncr19==2) selected @endif>En desacuerdo</option>   
       <option value=1 @if($Encuesta->ncr19==1) selected @endif>Totalmente  en desacuerdo</option>
       <option value=0  hidden></option>   
</select>
        </td>
<td>
<h2 class="reactivo">80.- ¿Cuantos trabajos tiene actualmente?  </h2>
    
          <select class="select" id="ncr20" name="ncr20"  > 
          <option selected="selected" value="">
          <option value=1 @if($Encuesta->ncr20==1) selected @endif>Uno</option>
          <option value=2 @if($Encuesta->ncr20==2) selected @endif>Dos</option>
          <option value=3 @if($Encuesta->ncr20==3) selected @endif>Tres o más</option>
          <option value=0  hidden></option>   
</select>
    
               </td>
</tr>
<tr>
<td>
<h2 class="reactivo"> 81.- ¿Cuáles son sus ingresos mensuales promedio en su o sus trabajos?  </h2>
    
    <INPUT type="text" class="texto"  id="ncr21" name="ncr21" size="10" maxlength="6" value="{{$Encuesta->ncr21}}"  onKeyPress="return acceptNum(event)" > 
    (solo enteros, sin centavos, comas, ni puntos) 
        </td>
<td>
<h2 class="reactivo"> 82.- Desde que terminó sus estudios de licenciatura,
        ¿ha dejado de trabajar? </h2>
    
    
    <select class="select" id="ncr22" name="ncr22"  onchange="bloquear('ncr22',[2],[ncr24,ncr24a,ncr24porque,ncr23]) "> 
    <option value="" selected="selected"></option>
    <option value=1 @if($Encuesta->ncr22==1) selected @endif>Sí</option>
    <option value=2 @if($Encuesta->ncr22==2) selected @endif>No</option>
    <option value=0  hidden></option>   

    </select>
    
        </td>
<td>
<h2 class="reactivo"> 83.-¿Cuál es la razón principal por la que usted no está trabajando o 
        ha dejado de trabajar? </h2>
     <select class="select" id="ncr24" name="ncr24" onchange="porque()">
     <option value=""> </option>
     
      <option value=1 @if($Encuesta->ncr24==1) selected @endif> Estar estudiando</option>
      <option value=13 @if($Encuesta->ncr24==13) selected @endif>Embarazo </option>
      <option value=11 @if($Encuesta->ncr24==11) selected @endif>Razones de salud </option>
      <option value=4 @if($Encuesta->ncr24==4) selected @endif> Obligaciones familiares</option>
      <option value=10 @if($Encuesta->ncr24==10) selected @endif>No le interesaba trabajar </option>
      <option value=5 @if($Encuesta->ncr24==5) selected @endif>Las ofertas eran poco atractivas con relación al salario </option>
      <option value=6 @if($Encuesta->ncr24==6) selected @endif>Las ofertas eran poco atractivas con relación a las actividades profesionales </option>
      <option value=2 @if($Encuesta->ncr24==2) selected @endif>Falta de ofertas de trabajo </option>
      <option value=7 @if($Encuesta->ncr24==7) selected @endif>Falta de experiencia laboral</option>
      <option value=3 @if($Encuesta->ncr24==3) selected @endif>No tenía las competencias necesarias para el trabajo al que aspiraba </option>
      <option value=8 @if($Encuesta->ncr24==8) selected @endif> No tener el título de licenciatura</option>
      <option value=9 @if($Encuesta->ncr24==9) selected @endif>No tener estudios de posgrado </option>
      <option value=12 @if($Encuesta->ncr24==12) selected @endif> Perdió o dejó su trabajo (¿por qué?)</option>
      <option value=13 @if($Encuesta->ncr24==13) selected @endif>Embarazo</option> 
      <option value=15 @if($Encuesta->ncr24==15) selected @endif>Hacer la tesis o trámites de titulación </option> 
      <option value=16 @if($Encuesta->ncr24==16) selected @endif>Servicio social o prácticas profesionales</option> 
      <option value=17 @if($Encuesta->ncr24==17) selected @endif>Cambio de residencia</option> 
      <option value=18 @if($Encuesta->ncr24==18) selected @endif>Emprender un negocio o empresa propios</option> 
      <option value=19 @if($Encuesta->ncr24==19) selected @endif>Motivos personales</option> 
      <option value=20 @if($Encuesta->ncr24==29) selected @endif>Derivado de la pandemia</option> 
      <option value=14 @if($Encuesta->ncr24==14) selected @endif>Otra </option>
      <option value=0 @if($Encuesta->ncr24==0) selected @endif> </option>
     
</select>
</td><td>
    <br>(Especifíque)
    Otra:
    <input type="text" class="texto" id="ncr24a" name="ncr24a" value="{{$Encuesta->ncr24a}}" maxlength="55" > 
    
    
        </td>
</tr>
<tr>
<td>
<h2 class="reactivo"> 83a):-Perdió o dejó su trabajo, ¿por qué? </h2>
  
     <select class="select" id="ncr24porque" name="ncr24porque" >
              <option  value="" selected></option>
     <option value=1 @if($Encuesta->ncr24porque==1) selected @endif>Cerró la empresa</option> 
     <option value=2 @if($Encuesta->ncr24porque==2) selected @endif>Liquidación</option> 
     <option value=3 @if($Encuesta->ncr24porque==3) selected @endif>Término de contrato o proyecto</option> 
     <option value=4 @if($Encuesta->ncr24porque==4) selected @endif>Renuncia</option> 
     <option value=15 @if($Encuesta->ncr24porque==15) selected @endif>Renuncia debido a la  pandemia</option>
     <option value=16 @if($Encuesta->ncr24porque==16) selected @endif>Despido debido a la pandemia</option>
     <option value=17 @if($Encuesta->ncr24porque==17) selected @endif>Cerro la empresa debido a la pandemia</option>
     <option value=5  @if($Encuesta->ncr24porque==5) selected @endif>Otra</option> 
     <option value=9  @if($Encuesta->ncr24porque==9) selected @endif>Jubilarse o Pensionarse</option> 
     <option value=0   @if($Encuesta->ncr24!=12) selected @endif hidden></option>   
</select>
       
         </td>
<td>
<h2 class="reactivo"> 84.- ¿Cuál es el periodo más largo que ha permanecido sin laborar? </h2>
    
    
    <select class="select" id="ncr23" name="ncr23" >
        <option selected="selected" value="">
        <option value=1 @if($Encuesta->ncr23==1) selected @endif>De 1 a 3 meses</option>
        <option value=2 @if($Encuesta->ncr23==2) selected @endif>Más de 3 y hasta 6 meses</option> 
        <option value=3 @if($Encuesta->ncr23==3) selected @endif>Más de 6 y hasta un año</option> 
        <option value=4 @if($Encuesta->ncr23==4) selected @endif>Más de un año</option> 
    <option value=0  hidden></option>   
</select>
</td>
</tr>
</table>
<table class="encuesta_table">
        <!-- primera fila  -->
<tr>
<td colspan="2">
<h2 class="reactivo">85.- ¿Comó fue su transición de la universidad al mercado laboral, en terminos de encontrar un trabajo relacionado con su campo profesional?    </h2>

 
<select class="select" id="ndr1" name="ndr1" onchange="bloquear('ndr1',[6,7],[ndr2,ndr2a,ndr3,ndr8,ndr4,ndr9,ndr5,ndr10,ndr6,ndr11,ndr7,ndr12,ndr12a,ndr12b,ndr12c,ndr13a,ndr14,ndr15,ndr16,ndr17,ndr18,ndr19])" >
        <option value="" selected></option>
        <option value=1  @if($Encuesta->ndr1==1) selected @endif>Muy fácil</option>
        <option value=2  @if($Encuesta->ndr1==2) selected @endif>Fácil</option> 
        <option value=3  @if($Encuesta->ndr1==3) selected @endif>Medianamente</option> 
        <option value=4  @if($Encuesta->ndr1==4) selected @endif>Difícil</option> 
        <option value=5  @if($Encuesta->ndr1==5) selected @endif>Muy difícil</option> 
        <option value=6  @if($Encuesta->ndr1==6) selected @endif>No he buscado un trabajo relacionado con mi carrera (Pase 61)</option> 
        <option value=7  @if($Encuesta->ndr1==7) selected @endif>No he encontrado un trabajo relacionado con mi carrera (Pase 61)</option> 
        <option value=0  hidden></option>   
</select>



    </td>
<td>
<h2 class="reactivo"> 86.- ¿Cómo encontró su primer  trabajo  en  su  campo profesional?   </h2>
<select class="select" id="ndr2" name="ndr2" onchange="funcion_ndr2()">
<option selected="selected" value="">
<option value=6  @if($Encuesta->ndr2==6) selected @endif>Aviso en el periódico</option>
<option value=9  @if($Encuesta->ndr2==9) selected @endif>Autoempleo (Pase a la 57)</option>
<option value=1  @if($Encuesta->ndr2==1) selected @endif>En la bolsa de trabajo de la UNAM</option>
<option value=2  @if($Encuesta->ndr2==2) selected @endif>En otra bolsa de trabajo</option>
<option value=8  @if($Encuesta->ndr2==8) selected @endif>Por relaciones en el servicio social</option>
<option value=10 @if($Encuesta->ndr2==10) selected @endif>Integración a un negocio familiar (Pase a la 57)</option>
<option value=11 @if($Encuesta->ndr2==11) selected @endif>Iniciativa propia</option>
<option value=7  @if($Encuesta->ndr2==7) selected @endif>Relaciones laborales previas</option>
<option value=3  @if($Encuesta->ndr2==3) selected @endif>Recomendado por amigos</option>
<option value=4  @if($Encuesta->ndr2==4) selected @endif>Recomendado por parientes</option>
<option value=5  @if($Encuesta->ndr2==5) selected @endif>Recomendado por un profesor</option>
<option value=12  @if($Encuesta->ndr2==12) selected @endif>Internet (especifíque)</option>
<option value=13  @if($Encuesta->ndr2==13) selected @endif>Prácticas profesionales (especifíque)</option>
<option value=14  @if($Encuesta->ndr2==14) selected @endif>Ofrecimiento directo (especifíque)</option>
<option value=16  @if($Encuesta->ndr2==16) selected @endif>Anuncio</option>
<option value=17  @if($Encuesta->ndr2==17) selected @endif>Convocatoria o Examen de selecci&oacuten</option>
<option value=15  @if($Encuesta->ndr2==15) selected @endif>Otra forma (especifíque)</option>
<option value=0  hidden></option>   
</select>
</td>
<td>
<br>Especifíque:
<INPUT id="ndr2a" class="texto"  NAME="ndr2a"  TYPE=TEXT SIZE="60" MAXLENGTH="60" value="{{$Encuesta->ndr2_a}}">

    </td>
</tr>

<tr>
<td colspan="4">
<h2 class="reactivo"> <b>¿Qué tan importantes fueron cada uno de los siguientes factores para su contratación, en su primer trabajo?  </b> </h2>
    </td>
</tr>
<tr>
<td>
<h2 class="reactivo">  87).- El prestigio de la UNAM </h2>
  

	<select class="select" id="ndr3" name="ndr3" >
        <option value="">
        <option value=1  @if($Encuesta->ndr3==1) selected @endif>Muy importante</option>
        <option value=2  @if($Encuesta->ndr3==2) selected @endif>Importante</option> 
        <option value=3  @if($Encuesta->ndr3==3) selected @endif>Medianamente importante</option> 
        <option value=4  @if($Encuesta->ndr3==4) selected @endif>Poco importante</option> 
        <option value=5  @if($Encuesta->ndr3==5) selected @endif>Nada importante </option> 
        <option value=0  hidden></option>   
</select>
</td>
<td>
<h2 class="reactivo">88).- Su comportamiento en la entrevista y/o en los exámenes de selección  </h2>
	<select class="select" id="ndr8" name="ndr8" >
        <option selected="selected" value="">
        <option value=1   @if($Encuesta->ndr8==1) selected @endif>Muy importante</option>
        <option value=2  @if($Encuesta->ndr8==2) selected @endif>Importante</option> 
        <option value=3  @if($Encuesta->ndr8==3) selected @endif>Medianamente importante</option> 
        <option value=4  @if($Encuesta->ndr8==4) selected @endif>Poco importante</option> 
        <option value=5  @if($Encuesta->ndr8==5) selected @endif>Nada importante </option> 
  <option value=0  hidden></option>   
</select>
</td>
<td>
<h2 class="reactivo"> 	89.- Sus conocimientos sobre la carrera </h2>

	<select class="select" id="ndr4" name="ndr4" >
        <option selected="selected" value="">
        <option value=1  @if($Encuesta->ndr4==1) selected @endif>Muy importante</option>
        <option value=2  @if($Encuesta->ndr4==2) selected @endif>Importante</option> 
        <option value=3  @if($Encuesta->ndr4==3) selected @endif>Medianamente importante</option> 
        <option value=4  @if($Encuesta->ndr4==4) selected @endif>Poco importante</option> 
        <option value=5  @if($Encuesta->ndr4==5) selected @endif>Nada importante </option> 
        <option value=0  hidden></option>   
</select>

 </td>
<td>
<h2 class="reactivo">  90.- Recomendaciones</h2>


	<select class="select" id="ndr9" name="ndr9" >
        <option selected="selected" value="">
        <option value=1  @if($Encuesta->ndr9==1) selected @endif>Muy importante</option>
        <option value=2  @if($Encuesta->ndr9==2) selected @endif>Importante</option> 
        <option value=3  @if($Encuesta->ndr9==3) selected @endif>Medianamente importante</option> 
        <option value=4  @if($Encuesta->ndr9==4) selected @endif>Poco importante</option> 
        <option value=5  @if($Encuesta->ndr9==5) selected @endif>Nada importante </option> 
        <option value=0  hidden></option>   
</select>

      </td>
</tr>

<tr>
<td>
<h2 class="reactivo"> 91.- Sus conocimientos sobre computación   </h2>
	<select class="select" id="ndr5" name="ndr5" >
        <option selected="selected" value="">
        <option value=1  @if($Encuesta->ndr5==1) selected @endif>Muy importante</option>
        <option value=2  @if($Encuesta->ndr5==2) selected @endif>Importante</option> 
        <option value=3  @if($Encuesta->ndr5==3) selected @endif>Medianamente importante</option> 
        <option value=4  @if($Encuesta->ndr5==4) selected @endif>Poco importante</option> 
        <option value=5  @if($Encuesta->ndr5==5) selected @endif>Nada importante </option> 
        <option value=0  hidden></option>   
</select>

</td>
<td>
<h2 class="reactivo">92.- Su género (sexo)  </h2>
	<select class="select" id="ndr10" name="ndr10" >
        <option selected="selected" value="">
        <option value=1  @if($Encuesta->ndr10==1) selected @endif>Muy importante</option>
        <option value=2  @if($Encuesta->ndr10==2) selected @endif>Importante</option> 
        <option value=3  @if($Encuesta->ndr10==3) selected @endif>Medianamente importante</option> 
        <option value=4  @if($Encuesta->ndr10==4) selected @endif>Poco importante</option> 
        <option value=5  @if($Encuesta->ndr10==5) selected @endif>Nada importante </option> 
        <option value=0  hidden></option>   
</select>

            </td>
<td>
<h2 class="reactivo"> 93.- Su  dominio  del inglés   </h2>
	<select class="select" id="ndr6" name="ndr6" >
        <option selected="selected" value="">
        <option value=1  @if($Encuesta->ndr6==1) selected @endif>Muy importante</option>
        <option value=2  @if($Encuesta->ndr6==2) selected @endif>Importante</option> 
        <option value=3  @if($Encuesta->ndr6==3) selected @endif>Medianamente importante</option> 
        <option value=4  @if($Encuesta->ndr6==4) selected @endif>Poco importante</option> 
        <option value=5  @if($Encuesta->ndr6==5) selected @endif>Nada importante </option> 
        <option value=0  hidden></option>   
</select>
 

            </td>
<td>
<h2 class="reactivo"> 94.- Su edad  </h2>
	<select class="select" id="ndr11" name="ndr11" >
        <option selected="selected" value="">
        <option value=1  @if($Encuesta->ndr11==1) selected @endif>Muy importante</option>
        <option value=2  @if($Encuesta->ndr11==2) selected @endif>Importante</option> 
        <option value=3  @if($Encuesta->ndr11==3) selected @endif>Medianamente importante</option> 
        <option value=4  @if($Encuesta->ndr11==4) selected @endif>Poco importante</option> 
        <option value=5  @if($Encuesta->ndr11==5) selected @endif>Nada importante </option> 
        <option value=0  hidden></option>   
</select>

            </td>
</tr>

<tr>
<td>
<h2 class="reactivo">	95.- Su dominio de otro idioma  </h2>
	<select class="select" id="ndr7" name="ndr7" >
        <option selected="selected" value="">
        <option value=1  @if($Encuesta->ndr7==1) selected @endif>Muy importante</option>
        <option value=2  @if($Encuesta->ndr7==2) selected @endif>Importante</option> 
        <option value=3  @if($Encuesta->ndr7==3) selected @endif>Medianamente importante</option> 
        <option value=4  @if($Encuesta->ndr7==4) selected @endif>Poco importante</option> 
        <option value=5  @if($Encuesta->ndr7==5) selected @endif>Nada importante </option> 
        <option value=0  hidden></option>   
</select>
</td>
<td>
<h2 class="reactivo"> 96.- Su estado civil       </h2>
	<select class="select" id="ndr12" name="ndr12" >
        <option selected="selected" value="">
        <option value=1  @if($Encuesta->ndr12==1) selected @endif>Muy importante</option>
        <option value=2  @if($Encuesta->ndr12==2) selected @endif>Importante</option> 
        <option value=3  @if($Encuesta->ndr12==3) selected @endif>Medianamente importante</option> 
        <option value=4  @if($Encuesta->ndr12==4) selected @endif>Poco importante</option> 
        <option value=5  @if($Encuesta->ndr12==5) selected @endif>Nada importante </option> 
        <option value=0  hidden></option>   
 </select>
            </td>
<td>
<h2 class="reactivo">96.1 - Cercania al domicilio.  </h2>
	      <select class="select" id="ndr12a" name="ndr12a" >
        <option selected="selected" value="">
        <option value=1  @if($Encuesta->ndr12a==1) selected @endif>Muy importante</option>
        <option value=2  @if($Encuesta->ndr12a==2) selected @endif>Importante</option> 
        <option value=3  @if($Encuesta->ndr12a==3) selected @endif>Medianamente importante</option> 
        <option value=4  @if($Encuesta->ndr12a==4) selected @endif>Poco importante</option> 
        <option value=5  @if($Encuesta->ndr12a==5) selected @endif>Nada importante </option> 
        <option value=0  hidden></option>   
</select>

            </td>
<td>
<h2 class="reactivo">96.2 - Experiencia profesional    </h2>
	<select class="select" id="ndr12b" name="ndr12b" >
        <option selected="selected" value="">
        <option value=1  @if($Encuesta->ndr12b==1) selected @endif>Muy importante</option>
        <option value=2  @if($Encuesta->ndr12b==2) selected @endif>Importante</option> 
        <option value=3  @if($Encuesta->ndr12b==3) selected @endif>Medianamente importante</option> 
        <option value=4  @if($Encuesta->ndr12b==4) selected @endif>Poco importante</option> 
        <option value=5  @if($Encuesta->ndr12b==5) selected @endif>Nada importante </option> 
        <option value=0  hidden></option>   
</select>

            </td>
</tr>
<tr>
<td>
<h2 class="reactivo"> 96.3 - Título profesional.   </h2>
	      <select class="select" id="ndr12c" name="ndr12c" >
          <option selected="selected" value="">
          <option value=1  @if($Encuesta->ndr12c==1) selected @endif>Muy importante</option>
          <option value=2  @if($Encuesta->ndr12c==2) selected @endif>Importante</option> 
          <option value=3  @if($Encuesta->ndr12c==3) selected @endif>Medianamente importante</option> 
          <option value=4  @if($Encuesta->ndr12c==4) selected @endif>Poco importante</option> 
          <option value=5  @if($Encuesta->ndr12c==5) selected @endif>Nada importante </option> 
          <option value=0  hidden></option>   
</select>
    </td>
<td>
<h2 class="reactivo">97.- Otro factor para su contratación, ¿Cuál?(opcional) </h2>

<INPUT id="ndr13a" class="texto"  NAME="ndr13a" value=" {{$Encuesta->ndr13a}}" TYPE=TEXT SIZE="60" MAXLENGTH="60" >

      </td>
      <td>
<h2 class="reactivo">98.- ¿Cuándo encontró su primer trabajo relacionado con su campo profesional?  </h2>
<select class="select" id="ndr14" name="ndr14"  onchange="bloquear('ndr14',[1,3],[ndr15])">
   <option selected="selected" value="">
   <option value=1  @if($Encuesta->ndr14==1) selected @endif>Desde que estaba estudiando (Pase a la 58)</option>
   <option value=2  @if($Encuesta->ndr14==2) selected @endif>Después de egresar de la carrera </option>
   <option value=3  @if($Encuesta->ndr14==3) selected @endif>En el momento que terminó </option>
   <option value=0  hidden></option>   
</select>

      </td>
      <td></td>
</tr>

<tr>
<td colspan="2">
<h2 class="reactivo"> 99.- ¿Cuánto tiempo después  de  egresar  de  la licenciatura obtuvo su primer trabajo? {{$Encuesta->ndr15==1}}</h2>
<select class="select" id="ndr15" name="ndr15" >
<option selected="selected" value=0></option>
   <option value=1  @if($Encuesta->ndr15==1) selected @endif>6 meses o menos</option>
   <option value=2  @if($Encuesta->ndr15==2) selected @endif>de 6 meses a un año </option>
   <option value=3  @if($Encuesta->ndr15==3) selected @endif> más de un año</option>
   <option value=0  hidden></option>   
</select>

      </td>
<td>
<h2 class="reactivo"> 100.- ¿Actualmente sigue laborando en el mismo trabajo?</h2>
<select class="select" id="ndr16" name="ndr16" >
<option selected="selected" value="">
   <option value=1  @if($Encuesta->ndr16==1) selected @endif>Sí</option>
   <option value=2  @if($Encuesta->ndr16==2) selected @endif>No</option>
   <option value=0  hidden></option>   
</select>

      </td>
<td>
<h2 class="reactivo"> 101.- ¿Cuántos trabajos ha tenido desde que egresó de la licenciatura? </h2>
<select class="select" id="ndr17" name="ndr17" >
<option selected="selected" value="">
   <option value=1  @if($Encuesta->ndr17==1) selected @endif>Uno</option>
   <option value=2  @if($Encuesta->ndr17==2) selected @endif>Dos </option>
   <option value=3  @if($Encuesta->ndr17==3) selected @endif>De tres a seis</option>
 <option value=4  @if($Encuesta->ndr17==4) selected @endif>Más de seis</option>
 <option value=5  @if($Encuesta->ndr17==5) selected @endif>Ninguno</option>
 <option value=0  hidden></option>   
</select>

     </td>

</tr>
<tr><td colspan="4">
<h2 class="reactivo">Desde su inserción al campo laboral a la fecha, considera que su situación ha mejorado, con relación a el:</h2>

     </td></tr>
<tr>

<td>
<h2 class="reactivo">102).- Puesto que ocupa    </h2>
<select class="select" id="ndr18" name="ndr18">
        <option selected="selected" value="">
<option value=1  @if($Encuesta->ndr18==1) selected @endif>Mejoró</option>
<option value=2  @if($Encuesta->ndr18==2) selected @endif>Es la misma</option>
<option value=3  @if($Encuesta->ndr18==3) selected @endif>Empeoró</option>
<option value=0  hidden></option>   
</select>

        </td>
<td>
<h2 class="reactivo">103).- Salario    </h2> 
<select class="select" id="ndr19" name="ndr19" >
        <option selected="selected" value="">
<option value=1  @if($Encuesta->ndr19==1) selected @endif>Mejoró</option>
<option value=2  @if($Encuesta->ndr19==2) selected @endif>Es la misma</option>
<option value=3  @if($Encuesta->ndr19==3) selected @endif>Empeoró</option>
<option value=0  hidden></option>   
</select>
</td> <td></td> <td></td>
</tr>
</table>
<table class="encuesta_table">
        <!-- primera fila  -->
<tr>
<td colspan="2">
<h2 class="reactivo">  
    16.- ¿Desde que egresó de la licenciatura ha realizado actividades formales de actualización en su campo profesional?
    (cursos, diplomados,seminarios, etc.)</h2>
         <select class="select" id="ner1" name="ner1"  onchange="bloquear('ner1',[2],[ner2,ner1a,ner3,ner4,ner5,ner6,ner7,ner7int,ner7_a])" > 
        <option  value="" selected></option>
       <option value=1  @if($Encuesta->ner1==1) selected @endif>Sí</option>
       <option value=2  @if($Encuesta->ner1==2) selected @endif>No (pase a la 72)</option>
       <option value=0  hidden></option>   
</select>
</td>
<td>
<h2 class="reactivo">  
    17.- ¿Cada cuando lo realiza?</h2>
          <select class="select" id="ner2" name="ner2"  >
          <option value=""></option>
       <option value=1  @if($Encuesta->ner2==1) selected @endif>Cada seis meses</option>
       <option value=2  @if($Encuesta->ner2==2) selected @endif>Cada año</option>
       <option value=3  @if($Encuesta->ner2==3) selected @endif>Cada dos o tres años</option>
       <option value=4  @if($Encuesta->ner2==4) selected @endif>Continuamente</option>
       <option value=0  hidden></option>   
 </select>
</td>
<td>
<h2 class="reactivo">  
    a).-¿Para su actualización ha requerido el idioma Inglés o algún otro idioma?</h2>
         <select class="select" id="ner1a" name="ner1a"  > 
        <option  value="" selected></option>
       <option value=1  @if($Encuesta->ner1a==1) selected @endif>Sí</option>
       <option value=2  @if($Encuesta->ner1a==2) selected @endif>No </option>
       <option value=0  hidden></option>   
</select>
</td>

</tr>
<tr>
<td colspan="4">
<h2 class="reactivo">  
    <b>¿Dónde las ha realizado?</b></h2>
    
</td>
</tr>
<tr>
    <td>
    <h2 class="reactivo">  
    18.- En la UNAM</h2>
    <select class="select" id="ner3"  name="ner3" >
    <option value="" selected="selected"></option>
        <option value=1  @if($Encuesta->ner3==1) selected @endif>Sí</option>
       <option value=2  @if($Encuesta->ner3==2) selected @endif>No</option>
       <option value=0  hidden></option>   
</select>
    </td>
<td>
   
<h2 class="reactivo">  
    19.- En otra institución pública</h2>
    <select class="select" id="ner4" name="ner4" >
    <option value="" selected="selected"></option>
        <option value=1  @if($Encuesta->ner4==1) selected @endif>Sí</option>
       <option value=2  @if($Encuesta->ner4==2) selected @endif>No</option>
       <option value=0  hidden></option>   
</select> 
</td>
<td>
<h2 class="reactivo">  
20.- En otra institución privada</h2>
    <select class="select" id="ner5" name="ner5" >
      <option value="" selected="selected"></option>
      <option value=1  @if($Encuesta->ner5==1) selected @endif>Sí</option>
      <option value=2  @if($Encuesta->ner5==2) selected @endif>No</option>
      <option value=0  hidden></option>   
</select>  
</td>
<td>
    
<h2 class="reactivo">  
    21.-En la empresa o institución en la que trabaja</h2>
    <select class="select" id="ner6" name="ner6" >
    <option value="" selected="selected"></option>
    <option value=1  @if($Encuesta->ner6==1) selected @endif>Sí</option>
    <option value=2  @if($Encuesta->ner6==2) selected @endif>No</option>
    <option value=0  hidden></option>   
</select>
</td>
</tr>
<tr>
<td>
<h2 class="reactivo">  
    22.-En una asociación</h2>
    <select class="select" id="ner7" name="ner7" >
    <option value="" selected="selected"></option>
    <option value=1  @if($Encuesta->ner7==1) selected @endif>Sí</option>
    <option value=2  @if($Encuesta->ner7==2) selected @endif>No</option>
    <option value=0  hidden></option>  
    <option value=0  hidden></option>   
</select>
</td>
<td>
      
<h2 class="reactivo">  
    23.-En Internet</h2>
    <select class="select" id="ner7int" name="ner7int" >
      <option value="" selected="selected"></option>
      <option value=1  @if($Encuesta->ner7int==1) selected @endif>Sí</option>
      <option value=2  @if($Encuesta->ner7int==2) selected @endif>No</option>
      <option value=0  hidden></option>   
</select>
</td>
<td colspan="2">
<h2 class="reactivo">  24.-Otro lugar ¿Cúal?</h2>
 <INPUT id="ner7_a" NAME="ner7_a" TYPE=TEXT class="texto"  value="{{$Encuesta->ner7_a}} " MAXLENGTH=60 >
      
</td>
</tr>
<tr>
    <td colspan= "4"><h2 class="reactivo">  
    <B>Ha realizado estudios de:</B> <BR></h2>
   </td>
</tr>
<tr>
<td>
<h2 class="reactivo">  
    25.- <B>¿Posgrado?</B></h2>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <select class="select" id="ner8" name="ner8"  onchange="bloquear('ner8',[2],[ner9,ner10,ner10a,ner11,ner12,ner13,ner14,ner15,ner12a,ner12b,ner16,ner17,ner18,ner19])" >
       <option selected="selected" value="">
       <option value=1  @if($Encuesta->ner8==1) selected @endif>Sí</option>
       <option value=2  @if($Encuesta->ner8==2) selected @endif>No (pase a 82 o 77)</option >
       <option value=0  hidden></option>   
</select> 
</td>
<td colspan="2">
<h2 class="reactivo">  
    25a).-¿Qué tan relacionados están los estudios de posgrado que realiza y su carrera?</h2>
    <select class="select" id="ner9" name="ner9" >
       <option selected="selected" value="">
       <option value=1  @if($Encuesta->ner9==1) selected @endif>Muy relacionados</option>
       <option value=2  @if($Encuesta->ner9==2) selected @endif>Medianamente relacionados</option>
     <option value=3  @if($Encuesta->ner9==3) selected @endif>Poco o nada relacionados</option>
     <option value=0  hidden></option>   
</select>
 
</td>
</tr>

<tr>
<td> <h2 class="reactivo"> 
    26.- <B>¿Especialización?</B> </h2>
    <select class="select" id="ner10" name="ner10"  onchange="bloquear('ner10',[2],[ner10a,ner11,ner12,ner12ext]);" >
      <option selected="selected" value="">
      <option value=1  @if($Encuesta->ner10==1) selected @endif>Sí</option>
      <option value=2  @if($Encuesta->ner10==2) selected @endif>No</option>
      <option value=0  hidden></option>   
</select>
</td>
<td>
<h2 class="reactivo">  
    ¿Cuál? </h2>
    <INPUT   id="ner10a" name="ner10a" TYPE=TEXT class="texto"  value=" {{str_replace('0','',$Encuesta->ner10a)}}" MAXLENGTH=60 >
</td>

<td>
<h2 class="reactivo"> 
 26a).- ¿Ya se graduó? </h2>
    <select class="select" id="ner11" name="ner11" >
      <option selected="selected" value="">
      <option value=1  @if($Encuesta->ner11==1) selected @endif>Sí</option>
      <option value=2  @if($Encuesta->ner11==2) selected @endif>No</option>
      <option value=0  hidden></option>   
</select>
</td>
<td>
<h2 class="reactivo"> 
    27.- ¿En dónde los hizo? </h2>
     <select class="select" id="ner12" name="ner12"  onchange="bloquear('ner12',[0,1,2,3],[ner12ext])">
       <option selected="selected" value="">
       <option value=1  @if($Encuesta->ner12==1) selected @endif>En la UNAM</option>
       <option value=2  @if($Encuesta->ner12==2) selected @endif>En otra institución pública</option>
       <option value=3  @if($Encuesta->ner12==3) selected @endif>En otra institución privada</option>
       <option value=4  @if($Encuesta->ner12==4) selected @endif>En el extranjero</option>
       <option value=0  hidden></option>   
</select>

<h2 class="reactivo">27a.- Extranjero Especifique: </h2>

 <INPUT type="text" class="texto " id="ner12ext" name="ner12ext" value="{{$Encuesta->ner12text}}" style="width:60%"  maxlength="100"  >

</td>
</tr>

<tr>
    <td>
    <h2 class="reactivo">  
    28.- <b>¿Maestría?</b></h2>
    <select class="select" id="ner13" name="ner13"  onchange="bloquear('ner13',[2],[ner14,ner15,ner15ext])" >
        <option selected="selected" value="">
        <option value=1  @if($Encuesta->ner13==1) selected @endif>Sí</option>
        <option value=2  @if($Encuesta->ner13==2) selected @endif>No</option>
        <option value=0  hidden></option>   
</select>
    </td>

    <td>
    <h2 class="reactivo">  
    28a).- ¿Ya se graduó?</h2>
    <select class="select" id="ner14" name="ner14" >
       <option selected="selected" value="">
       <option value=1  @if($Encuesta->ner14==1) selected @endif>Sí</option>
       <option value=2  @if($Encuesta->ner14==2) selected @endif>No</option>
       <option value=0  hidden></option>   
</select>
    </td>

    <td>
    <h2 class="reactivo"> 
    29.- ¿En dónde los hizo? </h2>
    <select class="select" id="ner15"  name="ner15"  onchange="bloquear('ner15',[0,1,2,3],[ner15ext])" >
       <option selected="selected" value="">
       <option value=1  @if($Encuesta->ner15==1) selected @endif>En la UNAM</option>
       <option value=2  @if($Encuesta->ner15==2) selected @endif>En otra institución pública</option>
       <option value=3  @if($Encuesta->ner15==3) selected @endif>En otra institución privada</option>
       <option value=4  @if($Encuesta->ner15==4) selected @endif>En el extranjero</option>
       <option value=0  hidden></option>   
</select>
<h2 class="reactivo">29a.- Extranjero Especifique: </h2>

 <INPUT type="text" class="texto " id="ner15ext" name="ner15ext" value="{{$Encuesta->ner15text}}" style="width:60%"  maxlength="100"  >

    </td>

    <td>

    </td>
</tr>
<tr>
<td>   <h2 class="reactivo">
    30.-¿Subespecialización? (solo médicos)  </h2>
    <select class="select" id="ner12a" name="ner12a" onchange="bloquear('ner12a',[2],[ner12b])" @if(($Egresado->carrera!=208) && ($Egresado->carrera !=202)) hidden value=0 @endif>
      <option value=0 >-</option>
      <option value=1  @if($Encuesta->ner12a==1) selected @endif>Sí</option>
      <option value=2  @if($Encuesta->ner12a==2) selected @endif>No</option>
      <option value=0  hidden></option>   
</select></td>

    <td clospan="2">
    <h2 class="reactivo">  
    30a).-¿En qué área? </h2>
    <INPUT   id="ner12b" name="ner12b" TYPE=TEXT  class="texto" value=" "  MAXLENGTH=60 @if(($Egresado->carrera!=208) && ($Egresado->carrera !=202)) hidden value=0 @endif>
    </td>

    <td></td> <td></td>
</tr>

<tr>
<td colspan="2">
<h2 class="reactivo">  
    31.-¿Ha realizado estudios de Doctorado?</h2>
    <select class="select" id="ner16" name="ner16"  onchange="bloquear('ner16',[2],[ner17,ner18,ner18ext])" >
      <option selected="selected" value="">
      <option value=1  @if($Encuesta->ner16==1) selected @endif>Sí</option>
      <option value=2  @if($Encuesta->ner16==2) selected @endif>No (Pase a la 81)</option>
      <option value=0  hidden></option>   
</select>
</td>
<td>
<h2 class="reactivo">  
   32.- ¿Ya se graduó?</h2>
    <select class="select" id="ner17" name="ner17" @if($Encuesta->ner16==2) hidden value=0 @endif>
    <option selected="selected" value="">
      <option value=1  @if($Encuesta->ner17==1) selected @endif>Sí</option>
       <option value=2  @if($Encuesta->ner17==2) selected @endif>No</option>
       <option value=0  hidden></option>   
</select>  
</td>
<td>
<h2 class="reactivo">  
    33).- ¿En dónde los hizo?-</h2>
    <select class="select" id="ner18" name="ner18" onchange="bloquear('ner18',[0,1,2,3],[ner18ext])">
       <option selected="selected" value="">
       <option value=1  @if($Encuesta->ner18==1) selected @endif>En la UNAM</option>
       <option value=2  @if($Encuesta->ner18==2) selected @endif>En otra institución pública</option>
       <option value=3  @if($Encuesta->ner18==3) selected @endif>En otra institución privada</option>
       <option value=4  @if($Encuesta->ner18==4) selected @endif>En el extranjero</option>
       <option value=0  hidden></option>   
 </select>
 <h2 class="reactivo">33a.- Extranjero Especifique: </h2>

<INPUT type="text" class="texto " id="ner18ext" name="ner18ext" value="{{$Encuesta->ner18text}}" style="width:60%"  maxlength="100"  >
 
</td>
</tr>
<tr>
<td colspan="4">
<h2 class="reactivo">  
    <BR>34.-¿Cuál es la razón más importante por la que realiza(ó) estos estudios (posgrado y/o especialidad y/o doctorado)?
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
</td>
</tr>

</table>

<table class="encuesta_table">
        <!-- primera fila  -->

        <tr>
        <td>
<h2 class="reactivo">
35.-La carrera que estudió: </h2>
<select class="select" id="nfr0"  name="nfr0"  onchange="bloquear('nfr0',[2],[nfr1,nfr1a_label,nfr1a]);">
 <option selected="selected" value=""></option>
   <option value=1 @if($Encuesta->nfr0==1) selected @endif>La eligió </option>
  <option value=2 @if($Encuesta->nfr0==2) selected @endif>Se la asignaron (Pase a la 84)</option>
  </select>
      </td>
<td>
<h2 class="reactivo">
36. ¿Cuál  fue la razón más importante por la que usted eligió su carrera?</h2>
<select class="select" id="nfr1"  name="nfr1"  onchange="bloquear('nfr1',[1,2,3,4,5,6,7,8,9,10],[nfr1a_label,nfr1a])">
<option value=" " selected="selected"></option>
<option value=1 @if($Encuesta->nfr1==1) selected @endif>El prestigio de la profesión</option>
<option value=2 @if($Encuesta->nfr1==2) selected @endif>Sus  habilidades  y  fortalezas   académicas</option>
<option value=3 @if($Encuesta->nfr1==3) selected @endif>Opinión de amistades y/o familiares</option>
<option value=4 @if($Encuesta->nfr1==4) selected @endif>Perspectivas de trabajo</option>
<option value=5 @if($Encuesta->nfr1==5) selected @endif>Perspectivas de ingresos altos</option>
<option value=6 @if($Encuesta->nfr1==6) selected @endif>Su género (sexo)</option>
<option value=7 @if($Encuesta->nfr1==7) selected @endif>Facilidad para ingresar a esa carrera</option>
<option value=8 @if($Encuesta->nfr1==8) selected @endif>El tipo de actividades profesionales</option>
<option value=9 @if($Encuesta->nfr1==9) selected @endif>Contribuir al desarrollo del país</option>
<option value=10 @if($Encuesta->nfr1==10) selected @endif>Contribuir al  desarrollo de la ciencia o cultura</option>
<option value=12 @if($Encuesta->nfr1==12) selected @endif>Plan de Estudios</option>
<option value=11 @if($Encuesta->nfr1==11) selected @endif>Otro</option>
<option value=0 ></option>
  </select>
  <p id='nfr1a_label'>Otra:</p><input type="text" class="texto"   id="nfr1a" name="nfr1a"  maxlength="50"  value="{{$Encuesta->nfr1a}}"> 

      </td>
<td>
<h2 class="reactivo">
<BR>37.- ¿Durante sus estudios de bachillerato  se le proporcionó orientación vocacional?</h2>
<select class="select" id="nfr2" name="nfr2" >
<option selected="selected" value="">
 <option value=1 @if($Encuesta->nfr2==1) selected @endif>Sí, y me fue útil</option>
 <option value=2 @if($Encuesta->nfr2==2) selected @endif>Sí, y me fue medio útil</option>
 <option value=3 @if($Encuesta->nfr2==3) selected @endif>Sí, pero no fue  útil</option>
<option value=4 @if($Encuesta->nfr2==4) selected @endif>No </option>
 </select>

     </td>
<td>
<h2 class="reactivo">
38.- Tomando en cuenta sus experiencias posteriores a la conclusión de la licenciatura
¿volvería   a elegir la misma carrera?</h2>
<select class="select" id="nfr3" name="nfr3"  onchange="bloquear('nfr3',[1],[nfr4])" >
<option selected="selected" value="">
  <option value=1 @if($Encuesta->nfr3==1) selected @endif>Sí (pase a la 86)</option>
  <option value=2 @if($Encuesta->nfr3==2) selected @endif>No, una relacionada</option>
  <option value=3 @if($Encuesta->nfr3==3) selected @endif>No, una totalmente diferente</option>
   </select>
<br>
<h2 class="reactivo">
39a).- ¿Por qué no la elegiría? </h2>
  <select class="select" id="nfr4"  name="nfr4" @if($Encuesta->nfr3==1) hidden value=0 @endif > 
  <option selected="selected" value="">
  <option value=1 @if($Encuesta->nfr4==1) selected @endif>Esta carrera no fue mi primera opción</option>
  <option value=2 @if($Encuesta->nfr4==2) selected @endif>No ha podido encontrar trabajo en este campo</option>
  <option value=3 @if($Encuesta->nfr4==3) selected @endif>No está satisfecho(a) con su trabajo</option>
  <option value=4 @if($Encuesta->nfr4==4) selected @endif>No está satisfecho(a) con el salario que percibe en su  actual trabajo</option>
  <option value=5 @if($Encuesta->nfr4==5) selected @endif>Un cambio en sus intereses</option>
  <option value=6 @if($Encuesta->nfr4==6) selected @endif>En la carrera no adquirió las habilidades prácticas  necesarias para el trabajo</option>
  <option value=7 @if($Encuesta->nfr4==7) selected @endif>Otra</option>
  <option value=0 @if($Encuesta->nfr3==1)selected  @endif hidden></option>  
</select>
  
    </td>
</tr>
<tr>
<td>
<h2 class="reactivo">40.- ¿Volvería a estudiar en la UNAM?</h2>
    <select class="select" id="nfr5" name="nfr5"  onchange="bloquear('nfr5',[1],[nfr5_a])">
    <option selected="selected" value="">
    <option value=1 @if($Encuesta->nfr5==1) selected @endif>Sí (pasa a la 87)</option>
    <option value=2 @if($Encuesta->nfr5==2) selected @endif>No</option>
   </select> 
   
       </td>
<td>
<h2 class="reactivo"><br> <br>
  40a).- ¿Por qué?
  <br> <br></h2>
<INPUT  name="nfr5_a" id="nfr5_a" style="width:50%" value="{{str_replace('0','',$Encuesta->nfr5_a )}}"  maxlength="99" type="text" class="texto">

      </td>
<td>
<h2 class="reactivo"> 
 41).- ¿Recomendaría su escuela o facultad?</h2>
   <select class="select" id="nfr6" name="nfr6"  onchange="bloquear('nfr6',[1],[nfr6_a])">
     <option value="" selected="selected"></option>
     <option value=1 @if($Encuesta->nfr6==1) selected @endif>Sí (pasa a la 88)</option>
     <option value=2 @if($Encuesta->nfr6==2) selected @endif>No</option>
    </select>

        </td>
<td>
<h2 class="reactivo"><br> <br>
41a).- ¿Por qué? 
<br> <br></h2>
<INPUT id="nfr6_a" class="texto" Type='text' name="nfr6_a" value="{{str_replace('0','',$Encuesta->nfr6_a )}}" maxlength='99' style="width:50%" >

      </td>
</tr>
<tr>
<td>
<h2 class="reactivo">
42).-¿En qué porcentaje los programas de las asignaturas que curs&oacute estaban actualizados?</h2>
<select class="select" id="Pregunta 88"  name="nfr7" >
<option value="" selected="selected"></option>
  <option value=1 @if($Encuesta->nfr7==1) selected @endif>100%</option>
  <option value=2 @if($Encuesta->nfr7==2) selected @endif>75%</option>
  <option value=3 @if($Encuesta->nfr7==3) selected @endif>50%</option>
  <option value=4 @if($Encuesta->nfr7==4) selected @endif>25%</option>
  <option value=5 @if($Encuesta->nfr7==5) selected @endif>0%</option>
  </select></TD>
  
  
      </td>
<td>
<h2 class="reactivo">
43.-¿El plan de estudios que cursó debería?</h2>
<select class="select" id="nfr8" name="nfr8" >
<option value="" selected="selected"></option>
   <option value=1 @if($Encuesta->nfr8==1) selected @endif>Permanecer igual</option>
  <option value=2 @if($Encuesta->nfr8==2) selected @endif>Modificarse</option>
  <option value=3 @if($Encuesta->nfr8==3) selected @endif>Reestructurarse completamente</option>
  </select> </TD>

      </td>
<td>
<h2 class="reactivo"> 
44.- ¿Considera qué su formación teórica  fue adecuada?</h2>
<select class="select" id="Pregunta 90" name="nfr9" >
  <option selected="selected" value="">
  <option value=1 @if($Encuesta->nfr9==1) selected @endif>Totalmente de acuerdo</option>
  <option value=2 @if($Encuesta->nfr9==2) selected @endif>De acuerdo</option>
  <option value=3 @if($Encuesta->nfr9==3) selected @endif>Medianamente de acuerdo</option>
  <option value=4 @if($Encuesta->nfr9==4) selected @endif>En desacuerdo</option>
  <option value=5 @if($Encuesta->nfr9==5) selected @endif>Totalmente en desacuerdo</option>
</select>

    </td>
<td>
<h2 class="reactivo">
45.- ¿Considera qué  su   formación   práctica   fue adecuada?</h2>
<select class="select" id="Pregunta 91" name="nfr10" >
     <option selected="selected" value="">
 <option value=1 @if($Encuesta->nfr10==1) selected @endif>Totalmente de acuerdo</option>
  <option value=2 @if($Encuesta->nfr10==2) selected @endif>De acuerdo</option>
  <option value=3 @if($Encuesta->nfr10==3) selected @endif>Medianamente de acuerdo</option>
  <option value=4 @if($Encuesta->nfr10==4) selected @endif>En desacuerdo</option>
  <option value=5 @if($Encuesta->nfr10==5) selected @endif>Totalmente en desacuerdo</option>
</select>

    </td>
</tr>
<tr>
<td>
<h2 class="reactivo">
46.- ¿Considera qué faltaron temas importantes en el plan de estudios que usted cursó?  </h2>
<select class="select" id="nfr11" name="nfr11"  onchange="bloquear('nfr11',[2],[nfr11a])">
 <option value="" selected="selected"></option>
 <option value=1 @if($Encuesta->nfr11==1) selected @endif>Sí</option>
 <option value=2 @if($Encuesta->nfr11==2) selected @endif>No (Pasar a 93)</option>
 </select>


     </td>
<td>
<h2 class="reactivo">
46a).- ¿Cúales?</h2>
<INPUT type="text" class="texto" id="nfr11a" name="nfr11a" maxlength="99" value="{{$Encuesta->nfr11a}}">

      </td>
<td>
<h2 class="reactivo"> 
47.- ¿Con qué calidad se impartía la enseñanza?</h2>
<select class="select" id="Pregunta 93" name="nfr12" >
<option selected="selected" value="">
 <option value=1 @if($Encuesta->nfr12==1) selected @endif>Excelente</option>
  <option value=2 @if($Encuesta->nfr12==2) selected @endif>Buena</option>
  <option value=3 @if($Encuesta->nfr12==3) selected @endif>Regular</option>
  <option value=4 @if($Encuesta->nfr12==4) selected @endif>Mala</option>
  <option value=5 @if($Encuesta->nfr12==5) selected @endif>Deficiente</option>
 </select>


     </td>
<td>
<h2 class="reactivo">
48.-¿Con qué frecuencia interactuó con sus profesores  dentro  del aula? </h2>

<select class="select" id="nfr13" name="nfr13" >
<option selected="selected" value="">
 <option value=1 @if($Encuesta->nfr13==1) selected @endif>Muy frecuentemente</option>
 <option value=2 @if($Encuesta->nfr13==2) selected @endif>Frecuentemente</option>
 <option value=3 @if($Encuesta->nfr13==3) selected @endif>Esporádicamente</option>
 <option value=4 @if($Encuesta->nfr13==4) selected @endif>Casi nunca</option>
 <option value=5 @if($Encuesta->nfr13==5) selected @endif>Nunca</option>
 </select>


    </td>
</tr>

<tr>
<td>
<h2 class="reactivo">
49.-¿Con qué frecuencia interactuó con sus profesores  fuera del aula?</h2>
<select class="select" id="Pregunta 95" name="nfr22" >
 <option selected="selected" value="">
 <option value=1 @if($Encuesta->nfr8==1) selected @endif>Muy frecuentemente</option>
 <option value=2 @if($Encuesta->nfr8==2) selected @endif>Frecuentemente</option>
 <option value=3 @if($Encuesta->nfr8==3) selected @endif>Esporádicamente</option>
 <option value=4 @if($Encuesta->nfr8==4) selected @endif>Casi nunca</option>
 <option value=5 @if($Encuesta->nfr8==5) selected @endif>Nunca</option>
 </select>

     </td>
<td>
<h2 class="reactivo">
50.- ¿Durante sus estudios profesionales recibió o percibió que 
otros estudiantes recibieran algún tipo de 
discriminación?
</h2>
<select class="select" id="nfr23a" name="nfr23a"   onchange="bloquear('nfr23a',[2],[nfr23,nfr24])">
<option selected="selected" value="">
 <option value=1 @if($Discriminacion->count()>0) selected @endif>Sí (Especifíque)</option>
 <option value=2 @if($Discriminacion->count()==0) selected @endif>No (Pase a la 98)</option>
  </select>
    </TD>

  <TD colspan="2"> 
  <h2 class="reactivo"> 
51.-Especifíque:  </h2><div id="nfr23">
@foreach($nfr23_options  as $o)
<input type="checkbox" name="opcion{{$o->clave}}" @if($Discriminacion->where('tipo','=',$o->clave)->count()>0) checked @endif/>
    <label for="scales">{{$o->descripcion}}</label>
  
  <br>
@endforeach</div>
    <h2 class="reactivo"> 
51a) Otra (opcional):</h2>
<INPUT id="nfr24" name="nfr24" TYPE=TEXT  class="texto"  MAXLENGTH=80 value="{{$Encuesta->nfr24}}" >
</TD>
</tr>

<tr>
<TD > <h2 class="reactivo"> 
52.- ¿Cómo considera que fue la carga de trabajo durante sus estudios profesionales?
 (exámenes, tareas, proyectos,etc) </h2>
    
<select class="select" id="Pregunta 98" name="nfr25" > 
  <option selected="selected" value="">
  <option value=1 @if($Encuesta->nfr25==1) selected @endif>Muy alta</option>
  <option value=2 @if($Encuesta->nfr25==2) selected @endif>Alta</option>
  <option value=3 @if($Encuesta->nfr25==3) selected @endif>Media</option>
  <option value=4 @if($Encuesta->nfr25==4) selected @endif>Baja</option>
  <option value=5 @if($Encuesta->nfr25==5) selected @endif>Muy baja o nula</option>

  </select>
   </TD>

<TD > <h2 class="reactivo"> 
53.- ¿Cómo  fue  su  desempeño  como  estudiante durante sus estudios profesionales? </h2>
    
 <select class="select" id="Pregunta 99"  name="nfr26" >
    <option selected="selected" value="">
    <option value=1 @if($Encuesta->nfr26==1) selected @endif>Excelente</option>
    <option value=2 @if($Encuesta->nfr26==2) selected @endif>Bueno</option>
    <option value=3 @if($Encuesta->nfr26==3) selected @endif>Regular</option>
    <option value=4 @if($Encuesta->nfr26==4) selected @endif>Malo</option>
    <option value=5 @if($Encuesta->nfr26==5) selected @endif>Deficiente</option>
   </select>
    </TD>

  <TD>  <h2 class="reactivo"> 
54.- ¿Ya se tituló? </h2>
   
   <select class="select" id="nfr27"  name="nfr27"  onchange="titulado()" >
     <option value="" selected="selected"></option>
     <option value=1 @if($Encuesta->nfr27==1) selected @endif>Sí</option>
     <option value=2 @if($Encuesta->nfr27==2) selected @endif>No</option>
     <OPTION VALUE=3 @if($Encuesta->nfr27==3) selected @endif>No, estoy en trámite</OPTION>
    </select>
    
      </td>
      <td>
      <h2 class="reactivo"> 55.- ¿Cuánto tiempo después de egresar se tituló? </h2>

<select class="select" id="nfr28" name="nfr28" @if($Encuesta->nfr27!=1) hidden value=0 @else value={{$Encuesta->nfr28}} @endif>Sí>
<option value="" selected="selected"></option>
  <option value=1 @if($Encuesta->nfr28==1) selected @endif>Durante el primer año después de egresar</option>
  <option value=2 @if($Encuesta->nfr28==2) selected @endif>Dos años después de egresar</option>
  <option value=3 @if($Encuesta->nfr28==3) selected @endif>Tres años o más después de egresar</option>
  <option value=0 @if($Encuesta->nfr27!=1)selected  @endif hidden></option>  

</select>
</td>
</tr>

<tr>
<td>
<h2 class="reactivo">
56.- ¿Cuál es el motivo más importante por el que no se ha titulado? </h2>
     <select class="select" id="nfr29"  name="nfr29"  onchange="bloquear('nfr29',[1,2,3,4,5,6,7,8,10,11,12,13,14,15,16],[nfr29a])">
<option value="" selected="selected"></option>
   <option value=1 @if($Encuesta->nfr29==1) selected @endif>Trámites  engorrosos y difíciles</option>
  <option value=2 @if($Encuesta->nfr29==2) selected @endif>No he tenido tiempo por estar trabajando</option>
  <option value=3 @if($Encuesta->nfr29==3) selected @endif>No he tenido tiempo por obligaciones familiares</option>
  <option value=4 @if($Encuesta->nfr29==4) selected @endif>No he podido concluir la tesis</option>
  <option value=5 @if($Encuesta->nfr29==5) selected @endif>No he hecho la tesis</option>
  <option value=6 @if($Encuesta->nfr29==6) selected @endif>No me interesa hacerlo</option>
  <option value=7 @if($Encuesta->nfr29==7) selected @endif>No, por estar estudiando</option>
  <option value=10 @if($Encuesta->nfr29==10) selected @endif>No acreditar el o los idiomas</option>
  <option value=11 @if($Encuesta->nfr29==11) selected @endif>Economicas</option>
  <option value=12 @if($Encuesta->nfr29==12) selected @endif>Esperar la convocatoria para diplomados o examen de conocimientos</option>
  <option value=13 @if($Encuesta->nfr29==13) selected @endif>Problemas con el asesor</option>
  <option value=14 @if($Encuesta->nfr29==14) selected @endif>No ha realizado el servicio social</option>
  <option value=15 @if($Encuesta->nfr29==15) selected @endif>Cursando el diplomado o alguna otra modalidad de titulación</option>
  <option value=16 @if($Encuesta->nfr29==16) selected @endif>Motivos de salud</option>
  <option value=8 @if($Encuesta->nfr29==8) selected @endif>No deseo contestar</option>
  <option value=9 @if($Encuesta->nfr29==9) selected @endif>Otra (especifíque)</option>
  <option value=0 ></option>
    
</select> 
      </td>
<td>
<h2 class="reactivo">
56a).- Otra (especifíque):</h2>
<INPUT  id="nfr29a" name="nfr29a" TYPE=TEXT  class="texto" MAXLENGTH=47 > 

      </td>
<td>
<h2 class="reactivo">
57.- ¿Ya realizó el servicio social?</h2>
 <select class="select" id="nfr30" name="nfr30"  onchange="bloquear('nfr30',[2],[nfr31,nfr32])">
  <option selected="selected" value="">
  <option value=1 @if($Encuesta->nfr30==1) selected @endif>Sí</option>
  <option value=2 @if($Encuesta->nfr30==2) selected @endif>No</option>
</select>

    </td>
<td> </td>

</tr>
<tr>
  <td colspan="2">
  <h2 class="reactivo">
58.- ¿En  qué  grado  estaban  relacionadas  con  su carrera las actividades que llevó a cabo durante el 
servicio social? </h2>
<select class="select" id="nfr31" name="nfr31" >
     <option selected="selected" value="">
 <option value=1 @if($Encuesta->nfr31==1) selected @endif>Muy relacionadas</option>
  <option value=2 @if($Encuesta->nfr31==2) selected @endif>Relacionadas</option>
  <option value=3 @if($Encuesta->nfr31==3) selected @endif>Medianamente relacionadas</option>
  <option value=4 @if($Encuesta->nfr31==4) selected @endif>Poco relacionadas</option>
  <option value=5 @if($Encuesta->nfr31==5) selected @endif>Nada relacionadas</option>
  <option value=0>
</select>

  </td>
<td>
<h2 class="reactivo">
59.- ¿Las funciones qué realizó en su servicio social, se traducían en beneficios para la sociedad?  </h2>
<select class="select" id="nfr32" name="nfr32" >
 <option selected="selected" value="">
 <option value=1 @if($Encuesta->nfr32==1) selected @endif>Sí</option>
 <option value=2 @if($Encuesta->nfr32==2) selected @endif>No</option>
 <option value=0>
</select></TD>

     </td>
<td>
<h2 class="reactivo"> 
60.- ¿En qué medida está satisfecho con su formación profesional?  </h2>
<select class="select" id="nfr33" name="nfr33" >
    <option selected="selected" value="">
    <option value=1 @if($Encuesta->nfr33==1) selected @endif>Muy satisfecho(a)</option>
    <option value=2 @if($Encuesta->nfr33==2) selected @endif>Satisfecho(a)</option>
    <option value=3 @if($Encuesta->nfr33==3) selected @endif>Medianamente satisfecho(a)</option>
    <option value=4 @if($Encuesta->nfr33==4) selected @endif>Poco satisfecho(a)</option>
    <option value=5 @if($Encuesta->nfr33==5) selected @endif>Nada satisfecho(a)</option>
 </select>
 </td>
</tr>
</table>

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
<select class="select" id="ngr6" name="ngr6"   onchange="bloquear('ngr6',[1],[ngr6a,ngr6b,ngr6c,ngr6d,ngr6e,ngr6f,ngr6g])">
    <option selected="selected" value="">
    <option value=1 @if($Encuesta->ngr6==1) selected @endif>No</option>
    <option value=2 @if($Encuesta->ngr6==2) selected @endif>Sí, en la UNAM </option>
    <option value=3 @if($Encuesta->ngr6==3) selected @endif>Sí, en instituciones externas (distinta) a la UNAM </option>
    <option value=4 @if($Encuesta->ngr6==4) selected @endif>Sí, por autoaprendizaje </option>
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
<select class="select" id="ngr8"  name="ngr8"  onchange="bloquear('ngr8',[1],[ngr9a,ngr9b,ngr9c,ngr9d])">
<option value="" selected="selected"></option>
<option value=1 @if($Encuesta->ngr8==1) selected @endif>No</option>
<option value=2 @if($Encuesta->ngr8==2) selected @endif>Sí, en la UNAM </option>
<option value=3 @if($Encuesta->ngr8==3) selected @endif>Sí, en instituciones externas (distinta) a la UNAM </option>
<option value=4 @if($Encuesta->ngr8==4) selected @endif>Sí, por autoaprendizaje </option>
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
Cuánto las desarrolló durante su formación profesional? </h2>
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
  <option value=1 @if($Encuesta->ngr22==1) selected @endif >Muchísimo</option>
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
119).-Resolver problemasa).- </h2>
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
  <option value=1 @if($Encuesta->ngr22==1) selected @endif >Muchísimo</option>
  <option value=2 @if($Encuesta->ngr22==2) selected @endif >Mucho</option>
  <option value=3 @if($Encuesta->ngr22==3) selected @endif >Regular</option>
  <option value=4 @if($Encuesta->ngr22==4) selected @endif >Poco</option>
  <option value=5 @if($Encuesta->ngr22==5) selected @endif >Nada</option>
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
125.- Una cultura general amplia</h2>
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
126.- La capacidad para apreciar diferentes expresiones artísticas (cine, teatro, etc.)</h2>
<select class="select" id="ngr37" name="ngr37"  onchange="artisticos()">
<option selected="selected" value="">
<option value=11 @if($Encuesta->ngr37==11) selected @endif >Sí</option>
<option value=12 @if($Encuesta->ngr37==12) selected @endif >No</option>
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

<td colspan="2">
<h2 class="reactivo">
127.- ¿Interés por la práctica  de algún deporte?</h2>
<select class="select" id="ngr40" name="ngr40"  onchange="deportes()">
<option selected="selected" value="">
  <option value=11 @if($Encuesta->ngr40==11) selected @endif >Sí</option>
<option value=12 @if($Encuesta->ngr40==12) selected @endif >No</option>
</select>
    </td>
<td >
<h2 class="reactivo">
a).-¿Cuál? </h2>
<select class="select" id="ngr40_a" name="ngr40_a"  >
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
    <td>
<h2 class="reactivo">
b).- ¿Con qué frecuencia lo practicó?</h2>
<select class="select" id="ngr40a" name="ngr40a" >
<option selected="selected" value="">
<option value=11 @if($Encuesta->ngr40a==11) selected @endif >Diario</option>
<option value=12 @if($Encuesta->ngr40a==12) selected @endif >2 o 3 veces por semana</option>
<option value=13 @if($Encuesta->ngr40a==13) selected @endif >1 vez a la semana</option>
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
<option value=5 >Otro</option>
<option value=0 hidden > </option>
      </select>
</td>
<td >
<h2 class="reactivo"> 
128.- ¿Actualmente es miembro de alguna organización o asociación? - </h2>
<select class="select" id="ngr45"  name="ngr45" onchange="bloquear('ngr45',[2],[ngr45_a,ngr45otra])">
<option selected="selected" value="">
  <option value=1 @if($Encuesta->ngr45==1) selected @endif >Sí</option>
<option value=2 @if($Encuesta->ngr45==2) selected @endif >No</option>
</select>
    </td>
    <td>

    <h2 class="reactivo">
128a).-¿Cuál?</h2>
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

   
<h2 class="reactivo">128b).-Otra:  </h2>

<INPUT  id="ngr45otra" name="ngr45otra" TYPE=TEXT  class="texto"  SIZE=60 MAXLENGTH=60 value="{{$Encuesta->ngr45otra}}">

    </td>
</tr>

<tr>

<td>
<h2 class="reactivo"> 
129.-¿Conoce usted la Credencial de Egresados y sus beneficios? </h2>
<select class="select" id="conoce"  name="conoce"  >
<option selected="selected" value="">
  <option value=1 @if($Encuesta->conoce==1) selected @endif >Sí</option>
<option value=2 @if($Encuesta->conoce==2) selected @endif >No</option>
</select>
    </td>
<td>
<h2 class="reactivo">
130.-¿Ya cuenta con su credencial de Exalumnos?</h2>
<select class="select" id="cue_cre"  name="cue_cre"  onchange="bloquear('cue_cre',[2],[utiliza])">
<option selected="selected" value="">
  <option value=1 @if($Encuesta->cue_cre==1) selected @endif >Sí</option>
<option value=2 @if($Encuesta->cue_cre==2) selected @endif >No</option>
<option value=0 hidden > </option>
      </select>

    </td>
    <td colspan="2">
<h2 class="reactivo">131.-¿Ha utilizado los Beneficios que le otorga el Programa de Vinculación con los Egresados de la UNAM?  </h2>
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
<textarea type="text" class="texto"   name="comentario" size="140"  id="comentario" rows="5" cols="50" value="{{$Comentario}}">
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
    bloquear('nar12',[1,2,3,4,5,6,7,8,9,10,11,12],[nar12otra])
  }
  function escolaridadp(){
    bloquear('nar13',[1,2,3,4,5,6,7,8,9,12,13],[nrxx])
    bloquear('nar13',[1,2,3,4,5,6,7,8,9,10,11,12],[nar13otra])
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
 
   bloquear('nar8',[1],[nar11,nar14,nar14otra]);
   check_beca();
   escolaridad();
   escolaridadp();
   bloquear('nar14',[0,33,34,35,36,37,45,46,47,48,49,50,51,52,53,54,55,56,57,58],[nar14otra]);
   bloquear('ner20',[1],[ner20a,ner20txt]);
   bloquear('nar15',[33,34,35,36,37,45,46,47,48,49,50,51,52,53,54,55,56,57,58],[nar15otra])
</script>


@endpush