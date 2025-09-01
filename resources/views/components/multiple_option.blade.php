
<div class="container" style="width: 15vmax; color:white">
    <!-- Renderiza el componente de nar3a solo si hay opciones disponibles -->
    @if($Becas_options->count() > 0)
    <div>
        <h2 class="text-2xl font-bold mb-4"></h2>
        <p>Seleccione una o varias opciones</p>
        @foreach($Becas_options->sortBy('orden') as $o)
            <div class="row mb-2">
                <div class="col">
                    <input type="checkbox"
                           id="nar3aop{{$o->clave}}"
                           class="nar3aopcion"
                           name="nar3a[]"
                           value="{{ $o->clave }}"
                           onclick="checkBloqueos('nar3a')"
                           @if($Becas->where('clave_opcion', $o->clave)->count() > 0) checked @endif
                           data-tippy-size="jumbo"
                           data-tippy-content="{{$o->help_info}}" />
                    <label data-tippy-size="jumbo"
                           data-tippy-content="{{$o->help_info}}">
                        {{$o->descripcion}}
                    </label>
                </div>
            </div>
        @endforeach
        <br>
        
    </div>
    @endif

    <!-- Renderiza el componente de nfr23 solo si hay opciones disponibles -->
    @if($nfr23_options->count() > 0)
    <div>
        <h2 class="text-2xl font-bold mb-4"></h2>
        <p>Seleccione una o varias opciones</p>
        @foreach($nfr23_options->sortBy('orden') as $o)
            <div class="row mb-2">
                <div class="col">
                    <input type="checkbox"
                           id="nfr23op{{$o->clave}}"
                           class="nfr23opcion"
                           name="nfr23[]"
                           value="{{ $o->clave }}"
                           onclick="checkBloqueos('nfr23')"
                           @if($nfr23_answers->where('clave_opcion', $o->clave)->count() > 0) checked @endif
                           data-tippy-size="jumbo"
                           data-tippy-content="{{$o->help_info}}" />
                    <label data-tippy-size="jumbo"
                           data-tippy-content="{{$o->help_info}}">
                        {{$o->descripcion}}
                    </label>
                </div>
            </div>
        @endforeach
        <br>
        
    </div>
    @endif
</div>
