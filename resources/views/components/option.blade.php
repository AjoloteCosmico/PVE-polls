
<select name="{{$Reactivo->clave}}" id="{{$Reactivo->clave}}" style="color:black" onChange="checkBloqueos('{{$Reactivo->clave}}')">
    <option value="">seleccione </option>
    @foreach($Opciones as $opcion)
        
        <option value="{{$opcion->clave}}" @if($value==$opcion->clave) selected @endif > {{$opcion->clave}}  {{$opcion->descripcion}}</option>
    @endforeach
</select>  

