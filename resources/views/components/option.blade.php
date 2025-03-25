
<select name="{{$Reactivo->clave}}" id="{{$Reactivo->clave}}" style="color:black" onChange="checkBloqueos('{{$Reactivo->clave}}')">
    <option value="">seleccione </option>
    @foreach($Opciones as $opcion)
        
<<<<<<< HEAD
        <option value="{{$opcion->clave}}" @if($value==$opcion->clave) selected @endif > {{--{{$opcion->clave}} --}} {{$opcion->descripcion}}</option>
=======
        <option value="{{$opcion->clave}}" @if($value==$opcion->clave) selected @endif > {{$opcion->clave}} {{$opcion->descripcion}}</option>
>>>>>>> 404e8c6f30ab8f2f64983058bcd403f89c362eb5
    @endforeach
</select>