{{--
<select name="{{$Reactivo->clave}}" id="{{$Reactivo->clave}}" style="color:black" onChange="checkBloqueos('{{$Reactivo->clave}}')">
    <option value="">seleccione </option>
    @foreach($Opciones as $opcion)
        
        <option value="{{$opcion->clave}}" @if($value==$opcion->clave) selected @endif > {{$opcion->clave}}  {{$opcion->descripcion}}</option>
    @endforeach
</select>  
--}}


@php
    use Illuminate\Support\Str;

    // Detectar si no hay valor
    $sinValor = is_null($value) || $value === '' || $value === 0 || $value === '0';

    // Verificar si es sección E (por campo o por prefijo)
    $esSeccionE = ($Reactivo->section ?? '') === 'E' || Str::startsWith(strtolower($Reactivo->clave), 'e');

    // Forzar "No" si no hay valor y es sección E
    $forzarNo = $sinValor && $esSeccionE;
@endphp

<select name="{{ $Reactivo->clave }}" id="{{ $Reactivo->clave }}" style="color:black" onChange="checkBloqueos('{{ $Reactivo->clave }}')">
    {{-- Mostrar "seleccione" solo si no se fuerza "No" --}}
    @if(!$forzarNo)
        <option value="">seleccione</option>
    @endif

    @foreach($Opciones as $opcion)
        @php
            $selected = '';

            if ($value == $opcion->clave) {
                $selected = 'selected';
            } elseif ($forzarNo && $opcion->clave == '2') {
                $selected = 'selected';
            }
        @endphp

        <option value="{{ $opcion->clave }}" {{ $selected }}>
            {{ $opcion->clave }} {{ $opcion->descripcion }}
        </option>
    @endforeach
</select>
