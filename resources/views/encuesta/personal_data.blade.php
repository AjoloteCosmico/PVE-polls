
  
        <table class="table text-lg personal" >
         
          <tr>
            <th>Egresad@: </th>
            <td> {{$Egresado->nombre}} {{$Egresado->paterno}} {{$Egresado->materno}} </td>
            <th>Numero C:</th><td> {{$Egresado->cuenta}}</td>
            <th> Telefonos: <a href="{{route('agregar_telefono',[$Egresado->cuenta,$Egresado->carrera,$Encuesta->registro,Session::get('telefono_encuesta')])}}">  <button class="btn btn-mb2" style="background-color:{{Auth::user()->color}} ; color:white; font-size:0.9vw"> <i class="fas fa-plus-circle"></i>&nbsp; Nuevo  </button></a></th>
              @foreach($Telefonos as $t)
              <td> <a class="contact_data"  href="{{route('editar_telefono',[$t->id,$Egresado->carrera,$Encuesta->registro,Session::get('telefono_encuesta')])}}">{{$t->telefono}} </a></td>
              @endforeach
            <th>Promedio:</th> <td> @if($Egresado->promedio>10) {{$Egresado->promedio /100}} @else {{$Egresado->promedio}} @endif</td>
            <th>fec. nac.:</th> <td>{{$Egresado->fec_nac}}</td>
          </tr>
          <tr>
          <th>Carrera:</th><td > {{$Carrera}}  </td> 
          <th>Plantel:</th><td colspan="2"> {{$Plantel}}</td> 
         
          <td colspan="{{$Telefonos->count()}}" >
            @foreach($Correos as $c)
            <a class="contact_data" onclick="correos({{$c->id}},'{{$c->correo}}')"> {{$c->correo}} </a> , &nbsp;
            @endforeach
            
          <a  href="{{route('agregar_correo',[$Egresado->cuenta,$Egresado->carrera,$Encuesta->registro,Session::get('telefono_encuesta')])}}">  <button class="btn btn-mb2" style="background-color:{{Auth::user()->color}} ; color:white; font-size:0.9vw"> <i class="fas fa-plus-circle"></i>&nbsp; Nuevo Correo  </button></a></td>
          <th>Sexo:</th> <td>{{$Egresado->sexo}}</td>
          <th>Bach::</th> <td> @if($Egresado->bach >= 20 && $Egresado->bach < 30)  ENP @elseif($Egresado->bach >= 30) CCH @endif </td>
          </tr>
          <tr>
          <td style="padding: 0.1vw" colspan="{{5 + $Telefonos->count()}}">
          <div class="row">
            <div class="col"><a class="btn" href="{{route('edit_20',[$Encuesta->registro,'A'])}}" id='Abtn'> <div id='Atxt'>Seccion A</div></a></div>
            <div class="col"><a class="btn"  href="{{route('edit_20',[$Encuesta->registro,'E'])}}" id='Ebtn'><div id='Etxt'>Seccion E</div></a></div>
            <div class="col"><a class="btn"  href="{{route('edit_20',[$Encuesta->registro,'F'])}}" id='Fbtn'><div id='Ftxt'>Seccion F</div></a></div>
            <div class="col"><a class="btn" href="{{route('edit_20',[$Encuesta->registro,'C'])}}" id='Cbtn'><div id='Ctxt'>Seccion C</div></a></div>
            <div class="col"><a class="btn" href="{{route('edit_20',[$Encuesta->registro,'D'])}}" id='Dbtn'><div id='Dtxt'>Seccion D</div></a></div>
            <div class="col"><a class="btn"  href="{{route('edit_20',[$Encuesta->registro,'G'])}}" id='Gbtn'><div id='Gtxt'>Seccion G</div></a> </div>
          </div>
        </td>
        <td colspan="4">
          @if($Encuesta->completed==1)
          <a href="{{route('terminar',$Encuesta->registro)}}">
        <button   type="button"  style="background-color:{{Auth::user()->color}} ; color:white; ">
<center><i class="fas fa-right-arrow fa-lg"></i>   Terminar :D </center>
  </button></a>
  @else
    <a href="{{route('terminar',$Encuesta->registro)}}">
        <button   type="button"  style="background-color:{{Auth::user()->color}} ; color:white; ">
  <center><i class="fas fa-right-arrow fa-lg"></i>  Salir y respaldar como  inconclusa </center>
  </button></a>
  @endif
        </td>
          </tr>
         </table>
  @push('css')
  <style>
    
    .customSwalBtn{
    padding:0.5vmax;
    margin:0.5vmax;
    }
    .customSwalBtn:hover{
      background-color: #002b7a;
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