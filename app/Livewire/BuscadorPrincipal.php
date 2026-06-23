<?php

namespace App\Livewire;

use Livewire\Component;

class BuscadorPrincipal extends Component
{
    public $nc = '';
    public $nombre_completo = '';

    // Se ejecuta automáticamente cuando cambia $nc
    public function updatedNc()
    {
        $this->dispatch('filtrarPorCuenta', nc: $this->nc);
    }

    // Se ejecuta automáticamente cuando cambia $nombre_completo
    public function updatedNombreCompleto()
    {
        $this->dispatch('filtrarPorNombre', nombre_completo: $this->nombre_completo);
    }

    public function render()
    {
        return view('livewire.buscador-principal');
    }
}