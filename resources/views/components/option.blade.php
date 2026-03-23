

<select name="{{$Reactivo->clave}}" id="{{$Reactivo->clave}}" style="color:black" onChange="checkBloqueos('{{$Reactivo->clave}}')" 
    @if($Opciones->count()>=10)
    class="select2-searchable"
    @endif
    @if(isset($disabled) && $disabled) 
        disabled 
    @endif >
    <option value=""> </option>
    @foreach($Opciones->sortBy('orden') as $opcion)
        @php
            // Lista de no seleccionado por defecto
            $reactivos_predeterminados = ['ner3', 'ner4', 'ner5', 'ner6', 'ner7', 'ner7int', 'ner7_a'];

            // Bandera para determinar si la opción debe ser seleccionada.
            $seleccionada = false;

            // si ya hay un valor guardado
            if ($value == $opcion->clave) {
                $seleccionada = true;
            } 
            elseif (empty($value) && in_array($Reactivo->clave, $reactivos_predeterminados) && $opcion->clave == '2') {
                $seleccionada = true;
            }
        @endphp
        <option value="{{$opcion->clave}}" @if($seleccionada) selected @endif > <p style="color: #6f6f6f !important;"> {{$opcion->clave}}</p> {{$opcion->descripcion}}</option>
    @endforeach
 
</select>
