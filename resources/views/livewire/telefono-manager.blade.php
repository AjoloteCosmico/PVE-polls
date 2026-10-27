<div>
    <button type="button" class="btn boton-dorado" wire:click="nuevoTelefono">
        <i class="fas fa-plus-circle"></i>&nbsp; Nuevo teléfono
    </button>

    @foreach($telefonos as $t)
        <button type="button" class="contact_data" style="color: #002b7a;"
                wire:click="editarTelefono({{ $t->id }})"
                wire:key="telefono-{{ $t->id }}">
            {{ $t->telefono }}
        </button> &nbsp;
    @endforeach

    @if($showPhoneModal)
        <div class="modal show d-block" tabindex="-1" style="background: rgba(19, 25, 49, 0.85); z-index: 2000;" role="dialog">
            <div class="modal-dialog" style="font-size: 150%; z-index:1500">
                <div class="modal-content" style="background-color: #131931; color: white;">
                    <div class="modal-header">
                        <h5 class="modal-title" style="color:white;">
                            {{ $phoneId ? 'Editar Teléfono' : 'Nuevo Teléfono' }}
                        </h5>
                        <button type="button" class="close btn btn-danger" style="background-color:red;" wire:click="cerrarModal">
                            <i class="fa fa-times fa-xl" aria-hidden="true"></i>
                        </button>
                    </div>

                    <form wire:submit.prevent="guardarTelefono">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label style="color:white;">Teléfono</label>
                                <input type="text" class="form-control modal-input" style="font-size: 120%;" wire:model="telefonoInput" required>
                                @error('telefonoInput')
                                    <span class="text-danger" style="font-size: 0.9rem;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label style="color:white;">Descripción</label>
                                <input type="text" class="form-control modal-input" style="font-size: 120%;" wire:model="telefonoDescripcion">
                                @error('telefonoDescripcion')
                                    <span class="text-danger" style="font-size: 0.9rem;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="cerrarModal">Cancelar</button>
                            <button type="submit" class="btn btn-success text-lg">
                                <i class="fas fa-save fa-xlg"></i> Guardar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>