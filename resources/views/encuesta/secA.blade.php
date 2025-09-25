
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

<select class="select" id="nar14" name="nar14"  onchange="bloquear('nar14',[0,33,34,35,36,37,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59],[nar14otra])" >
<option value="" ></option>

<option value=45 @if($Encuesta->nar16==45) selected @endif >Funcionarios Directores y Jefes   </option>
<option value=46 @if($Encuesta->nar14==46) selected @endif >Profesionistas</option>
<option value=59 @if($Encuesta->nar14==59) selected @endif >Técnicos </option>
<option value=47 @if($Encuesta->nar16==47) selected @endif >Trabajadores Auxiliares en actividades administrativas  </option>
<option value=48 @if($Encuesta->nar16==48) selected @endif >Comerciantes, empleados en ventas y agentes de ventas  </option>
<option value=49 @if($Encuesta->nar16==49) selected @endif >Trabajadores en servicios personales y de vigilancia  </option>
<option value=50 @if($Encuesta->nar16==50) selected @endif >Trabajadores en actividades agrícolas, ganaderas, forestales, caza y pesca  </option>
<option value=51 @if($Encuesta->nar16==51) selected @endif >Trabajadores artesanales, en la construcción y otros oficios  </option>
<option value=52 @if($Encuesta->nar16==52) selected @endif >Operadores de maquinaria industrial, ensambladores, choferes y conductores de transporte  </option>
<option value=53 @if($Encuesta->nar16==53) selected @endif >Trabajadores en actividades elementales y de apoyo  </option>
<option value=54 @if($Encuesta->nar16==54) selected @endif >Profesor Enseñanza Superior  </option>
<option value=56 @if($Encuesta->nar16==56) selected @endif >Profesor Enseñanza Media </option>
<option value=57 @if($Encuesta->nar16==57) selected @endif >Profesor Enseñanza Básica</option>
<option value=58 @if($Encuesta->nar16==58) selected @endif >Otros profesores (Artísticos, deportes, etc.)  </option>
<option value=33 @if($Encuesta->nar16==33) selected @endif >Labores del hogar </option>
<option value=34 @if($Encuesta->nar16==34) selected @endif >Jubilado  </option>
<option value=35 @if($Encuesta->nar16==35) selected @endif >Finado  </option>
<option value=36 @if($Encuesta->nar16==36) selected @endif >No trabaja  </option>
<option value=37 @if($Encuesta->nar16==37) selected @endif >No lo sabe  </option>
<option value=38 @if($Encuesta->nar16==38) selected @endif >Otra(Especifíque)</option>
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

<select class="select" id="nar15" name="nar15"  onchange="bloquear('nar15',[33,34,35,36,37,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59],[nar15otra])" >
<option value="" ></option>

<option value=45 @if($Encuesta->nar16==45) selected @endif >Funcionarios Directores y Jefes   </option>
<option value=46 @if($Encuesta->nar14==46) selected @endif >Profesionistas</option>
<option value=59 @if($Encuesta->nar14==59) selected @endif >Técnicos </option>
<option value=47 @if($Encuesta->nar16==47) selected @endif >Trabajadores Auxiliares en actividades administrativas  </option>
<option value=48 @if($Encuesta->nar16==48) selected @endif >Comerciantes, empleados en ventas y agentes de ventas  </option>
<option value=49 @if($Encuesta->nar16==49) selected @endif >Trabajadores en servicios personales y de vigilancia  </option>
<option value=50 @if($Encuesta->nar16==50) selected @endif >Trabajadores en actividades agrícolas, ganaderas, forestales, caza y pesca  </option>
<option value=51 @if($Encuesta->nar16==51) selected @endif >Trabajadores artesanales, en la construcción y otros oficios  </option>
<option value=52 @if($Encuesta->nar16==52) selected @endif >Operadores de maquinaria industrial, ensambladores, choferes y conductores de transporte  </option>
<option value=53 @if($Encuesta->nar16==53) selected @endif >Trabajadores en actividades elementales y de apoyo  </option>
<option value=54 @if($Encuesta->nar16==54) selected @endif >Profesor Enseñanza Superior  </option>
<option value=56 @if($Encuesta->nar16==56) selected @endif >Profesor Enseñanza Media </option>
<option value=57 @if($Encuesta->nar16==57) selected @endif >Profesor Enseñanza Básica</option>
<option value=58 @if($Encuesta->nar16==58) selected @endif >Otros profesores (Artísticos, deportes, etc.)  </option>
<option value=33 @if($Encuesta->nar16==33) selected @endif >Labores del hogar </option>
<option value=34 @if($Encuesta->nar16==34) selected @endif >Jubilado  </option>
<option value=35 @if($Encuesta->nar16==35) selected @endif >Finado  </option>
<option value=36 @if($Encuesta->nar16==36) selected @endif >No trabaja  </option>
<option value=37 @if($Encuesta->nar16==37) selected @endif >No lo sabe  </option>
<option value=38 @if($Encuesta->nar16==38) selected @endif >Otra(Especifíque)</option>
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
    

    <select class="select" id="nar16" name="nar16"  onchange="bloquear('nar16',[33,34,35,36,37,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59],[nar16otra])">
    <option value="" ></option>
   
   <option value=45 @if($Encuesta->nar16==45) selected @endif>Funcionarios Directores y Jefes   </option>
   <option value=46 @if($Encuesta->nar14==46) selected @endif>Profesionistas</option>
   <option value=59 @if($Encuesta->nar14==59) selected @endif>Técnicos </option>
   <option value=47 @if($Encuesta->nar16==47) selected @endif>Trabajadores Auxiliares en actividades administrativas  </option>
   <option value=48 @if($Encuesta->nar16==48) selected @endif>Comerciantes, empleados en ventas y agentes de ventas  </option>
   <option value=49 @if($Encuesta->nar16==49) selected @endif>Trabajadores en servicios personales y de vigilancia  </option>
   <option value=50 @if($Encuesta->nar16==50) selected @endif>Trabajadores en actividades agrícolas, ganaderas, forestales, caza y pesca  </option>
   <option value=51 @if($Encuesta->nar16==51) selected @endif>Trabajadores artesanales, en la construcción y otros oficios  </option>
   <option value=52 @if($Encuesta->nar16==52) selected @endif>Operadores de maquinaria industrial, ensambladores, choferes y conductores de transporte  </option>
   <option value=53 @if($Encuesta->nar16==53) selected @endif>Trabajadores en actividades elementales y de apoyo  </option>
   <option value=54 @if($Encuesta->nar16==54) selected @endif>Profesor Enseñanza Superior  </option>
   <option value=56 @if($Encuesta->nar16==56) selected @endif>Profesor Enseñanza Media </option>
   <option value=57 @if($Encuesta->nar16==57) selected @endif>Profesor Enseñanza Básica</option>
   <option value=58 @if($Encuesta->nar16==58) selected @endif>Otros profesores (Artísticos, deportes, etc.)  </option>
   <option value=33 @if($Encuesta->nar16==33) selected @endif>Labores del hogar </option>
  <option value=34 @if($Encuesta->nar16==34) selected @endif>Jubilado  </option>
  <option value=35 @if($Encuesta->nar16==35) selected @endif>Finado  </option>
  <option value=36 @if($Encuesta->nar16==36) selected @endif>No trabaja  </option>
  <option value=37 @if($Encuesta->nar16==37) selected @endif>No lo sabe  </option>
  <option value=38 @if($Encuesta->nar16==38) selected @endif>Otra(Especifíque)</option>
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


