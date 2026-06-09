<div>
    
        
        {{-- Input de Cuenta --}}
        <div class="col-md-6 mb-3 mb-md-0">
            <br>
            <br>
            <h3>Número de Cuenta</h3>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-id-card"></i></span>
                </div>
                <input type="text" 
                       wire:model.live.debounce.400ms="nc" 
                       class="form-control" 
                       placeholder="Escribe el número de cuenta a buscar...">
            </div>
        </div>

        {{-- Input de Nombre --}}
        <div class="col-md-6">
            <br>
            <br>
            <h3>Nombre Completo</h3>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-user"></i></span>
                </div>
                <input type="text" 
                       wire:model.live.debounce.400ms="nombre_completo" 
                       class="form-control" 
                       placeholder="Escribe el nombre o apellidos...">
            </div>
        </div>
    </div>
</div>