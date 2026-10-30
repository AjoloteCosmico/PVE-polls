<div>
    @if($showEmailModal)
        <div class="modal show d-block" tabindex="-1" style="background: rgba(19, 25, 49, 0.85); z-index: 2000;" role="dialog">
            <div class="modal-dialog" style="font-size: 150%;">
                <form wire:submit.prevent="guardarCorreo" class="modal-content" style="background-color: #131931; color: white;">
                    <div class="modal-header">
                        <h5 class="modal-title" style="color:white;">
                            {{ $emailId ? 'Editar Correo' : 'Agregar Correo' }}
                        </h5>
                        <button type="button" class="close btn btn-danger" style="background-color:red;" wire:click="cerrarModal">
                            <i class="fa fa-times fa-xl" aria-hidden="true"></i>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label style="color:white;">Correo Electrónico</label>
                            <input type="email" class="form-control modal-input" style="font-size: 120%;" wire:model="correoInput" required>
                            @error('correoInput')
                                <span class="text-danger" style="font-size: 0.9rem;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label style="color:white;">Descripción</label>
                            <input type="text" class="form-control modal-input" style="font-size: 120%;" wire:model="correoDescripcion">
                            @error('correoDescripcion')
                                <span class="text-danger" style="font-size: 0.9rem;">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="cerrarModal">Cancelar</button>

                        @if($emailId)
                            <button type="button" class="btn boton-dorado" wire:click="enviarAvisoPrivacidad" wire:loading.attr="disabled">
                                <i class="fas fa-paper-plane"></i> Enviar Aviso de Privacidad
                            </button>
                        @endif

                        <button type="submit" class="btn btn-success text-lg">
                            <i class="fas fa-save fa-xlg"></i> Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>