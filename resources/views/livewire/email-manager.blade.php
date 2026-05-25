<div>
    <!-- Botón para abrir modal -->
    <button wire:click="openCreateModal" class="btn btn-primary" style="font-size: 120%;">
        <i class="fas fa-plus"></i> Nuevo Correo
    </button>
    
    <!-- Modal -->
    @if($showModal)
        <div class="modal fade show" style="display: block; background: rgba(0,0,0,0.5); z-index:1500;" tabindex="-1" role="dialog" >
            <div class="modal-dialog" style="font-size: 150%;">
                <div class="modal-content" style="background: #131931;">
                    <div class="modal-header" style="border-bottom: 1px solid #444;">
                        <h5 class="modal-title" style="color:white;">
                            {{ $isEditing ? 'Editar Correo' : 'Nuevo Correo' }}
                        </h5>
                        <button type="button" class="close btn btn-danger" 
                                wire:click="closeModal" style="background-color:red; border:none;">
                            <i class="fa fa-times fa-xl" style="color: white;"></i>
                        </button>
                    </div>
                    
                    <div class="modal-body" style="background: #131931;">
                        <h3 style="color: #4CAF50; margin-bottom: 20px;">{{ $egName }}</h3>
                        
                        <form wire:submit.prevent="save">
                            <!-- Campo Correo -->
                            <div class="mb-3">
                                <label style="color:white; font-size: 110%;">Correo</label>
                                <input 
                                    type="email" 
                                    wire:model.defer="correo" 
                                    class="form-control modal-input @error('correo') is-invalid @enderror"
                                    placeholder="correo@ejemplo.com"
                                    style="font-size: 120%; background: #1a1a2e; color: white; border: 1px solid #444;">
                                @error('correo') 
                                    <small class="text-danger" style="font-size: 100%;">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </small>
                                @enderror
                            </div>
                            
                            <!-- Campo Status -->
                            <div class="mb-3">
                                <label style="color:white; font-size: 110%;">Estado</label>
                                <select wire:model.defer="status" class="form-control" 
                                        style="font-size: 120%; background: #1a1a2e; color: white; border: 1px solid #444;">
                                    <option value="13">En Uso</option>
                                    <option value="14">Sin Usar</option>
                                </select>
                            </div>
                            
                            <!-- Campo Descripción -->
                            <div class="mb-3">
                                <label style="color:white; font-size: 110%;">Anotaciones (opcional)</label>
                                <input 
                                    type="text" 
                                    wire:model.defer="description" 
                                    class="form-control modal-input"
                                    placeholder="Ingresa notas adicionales"
                                    style="font-size: 120%; background: #1a1a2e; color: white; border: 1px solid #444;">
                            </div>
                            
                            <!-- Botones -->
                            <div class="modal-footer" style="border-top: 1px solid #444; background: #131931;">
                                <button type="submit" class="btn btn-success" style="font-size: 110%;">
                                    <i class="fas fa-save"></i> Guardar
                                </button>
                                <button type="button" class="btn btn-secondary" wire:click="closeModal" style="font-size: 110%;">
                                    Cancelar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
    
    @script
    <script>
        Livewire.on('show-swal', (data) => {
            Swal.fire({
                position: "top-end",
                icon: data.icon,
                title: data.title,
                text: data.message,
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });
        });
    </script>
    @endscript
</div>
