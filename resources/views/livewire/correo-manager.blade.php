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
                        <div class="mb-3">
                            <label style="color:white;">Status</label>
                            <select class="form-control modal-input" style="font-size: 120%;" wire:model="correoStatus" required>
                                <option value="">Selecciona un status</option>
                                <option value="13">En Uso</option>
                                <option value="14">Sin usar</option>
                            </select>
                            @error('correoStatus')
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

   @if($showSendModal)
        <div class="modal show d-block" tabindex="-1" role="dialog" style="background: rgba(19,25,49,.85); z-index: 2000;">
            <div class="modal-dialog" style="font-size:150%;">
                <div class="modal-content" style="background-color:#131931; color:white;">
                    <div class="modal-header">
                        <h5 class="modal-title" style="color:white;">Enviar Correo Electrónico</h5>
                        <button type="button" class="close btn btn-danger" style="background-color:red;" wire:click="cerrarEnvio">
                            <i class="fa fa-times fa-xl"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="text-center font-weight-bold lead mb-3" style="color:white;">
                            ¿Deseas enviar la encuesta al siguiente correo?
                        </p>
                        <table class="table table-bordered text-white" style="font-size:15px;">
                            <tr style="background-color: rgb(0,43,122);">
                                <td><strong>Egresado:</strong></td>
                                <td>{{ $this->nombreEgresado }}</td>
                            </tr>
                            <tr style="background-color: rgb(0,43,122);">
                                <td><strong>Cuenta:</strong></td>
                                <td>{{ $cuenta }}</td>
                            </tr>
                            <tr style="background-color: rgb(0,43,122);">
                                <td><strong>Correo:</strong></td>
                                <td>{{ $sendCorreo }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="cerrarEnvio">Cancelar</button>
                        <button type="button" class="btn btn-success" wire:click="confirmarEnvio" wire:loading.attr="disabled">
                            <i class="fas fa-paper-plane"></i> Enviar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>