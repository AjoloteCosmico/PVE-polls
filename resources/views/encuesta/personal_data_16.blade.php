
  
        <table class="table text-lg table-personal" >
         
         <tr>
           <th>Egresad@: </th>
           <td> {{$Egresado->nombre}} {{$Egresado->paterno}} {{$Egresado->materno}}</td>
           <th>Numero C:</th><td> {{$Egresado->cuenta}}</td>
           <th> Telefonos:</th>
             @foreach($Telefonos as $t)
             <td> <a class="contact_data"  href="{{route('editar_telefono',[$t->id,$Egresado->carrera,$Encuesta->registro,Session::get('telefono_encuesta')])}}">{{$t->telefono}} </a>
             @if($loop->last)
             <a href="{{route('agregar_telefono',[$Egresado->cuenta,$Egresado->carrera,$Encuesta->registro,Session::get('telefono_encuesta')])}}">  <button class="btn boton-azul" > <i class="fas fa-plus-circle"></i>&nbsp; Nuevo telefono  </button></a>
            @endif</td>
             @endforeach
           <th>Encuesta:</th> <td>Actualización gen 2016 </td>
         </tr>

         <tr>
         <th>Carrera:</th><td > {{$Carrera}}  </td> 
         <th>Plantel:</th><td colspan="2"> {{$Plantel}}</td> 
        
         <td colspan="{{$Telefonos->count()}}" >
           @foreach($Correos as $c)
           <a class="contact_data" onclick="correos({{$c->id}},'{{$c->correo}}')"> {{$c->correo}} </a> , &nbsp;
           @endforeach
           
         <a  href="{{route('agregar_correo',[$Egresado->cuenta,$Egresado->carrera,$Encuesta->registro,Session::get('telefono_encuesta')])}}">  <button class="btn boton-azul" > <i class="fas fa-plus-circle"></i>&nbsp; Nuevo Correo  </button></a></td>
         <th>Fecha en que se encuestó:</th> <td>{{$Egresado->actualized}}</td>
         </tr>
         <tr>
         <td  colspan="{{5 + $Telefonos->count()}}">
          <div style="background-color:white; display:flex; justify-content: space-around">
            <a class="btn boton-dorado" href="{{route('posgrado_vista','pA')}}" id='Abtn'> Seccion 1</a>
            <a class="btn boton-dorado"  href="{{route('posgrado_vista','pB')}}" id='Bbtn'>Seccion 2</a>
            <a class="btn boton-dorado"  href="{{route('posgrado_vista','pD')}}"  id='Dbtn'>Seccion 3</a>
            <a class="btn boton-dorado" href="{{route('posgrado_vista','pC')}}"  id='Cbtn'>Seccion 4</a>
            <a class="btn boton-dorado" href="{{route('posgrado_vista','pE')}}"  id='Ebtn'>Seccion 5</a>
          </div>
       </td>
       <td colspan="2">
         Salir
       </td>
         </tr>
        </table>
 @push('css')
 <style>
   
   .customSwalBtn{
   padding:0.10vmax;
   margin:0.5vmax;
   background-color: #002b7a;
   }
   .customSwalBtn:hover{
      background-color: #ba800d;
     color:#FFFFFF;
      transform: translateY(-4px);
   }
 </style>
 @endpush

 @push('js')
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 
<script type="text/javascript">
 
 function correos(correo_id,correo){
   window.warning=false;
    console.log(window.warning);
   Swal.fire({
     title: correo,
     html: 
           "<br> " +
           '<button type="button" role="button" tabindex="0" class="SwalBtn1 customSwalBtn" onclick="location.href = `/direct_send/'+correo_id +'`">' + 'Enviar Aviso de Privacidad' + '</button>' +
           '<button type="button" role="button" tabindex="0" class="SwalBtn2 customSwalBtn"  onclick="location.href = `/editar_correo/'+correo_id +'/{{$Egresado->carrera}}/{{$Encuesta->registro}}`">' + 'Editar' + '</button>',
     icon: "warning",
     showConfirmButton: false,
     showCancelButton: false
   });
 }

</script>
 @endpush