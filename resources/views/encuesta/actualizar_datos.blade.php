@extends('layouts.app')
@section('content')

    {{-- Componente Principal de Datos de Contacto --}}
    <livewire:actualizar-datos
        :egresado="$Egresado"
        :telefonoEnLlamada="$TelefonoEnLlamada"
        :carrera="$Carrera"
        :plantel="$Plantel"
        :gen="$gen"
        :typeStudy="$typeStudy" 
    />

    {{-- Modales Genericos Globales (Compartidos con PersonalData) --}}
    <livewire:telefono-manager :cuenta="$Egresado->cuenta" />
    <livewire:correo-manager :cuenta="$Egresado->cuenta" :egresado="$Egresado" />

@stop

@push('css')
<style>
  .numero_telefonico {
    position: fixed;
    top: 50px;
    z-index: 2;
    right: 30px;
    padding: 10px 20px;
    background-color: {{ Auth::user()->color}};
    color: white;
    border-radius: 8px;
    font-size: 1.5vw;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  }
</style>

@endpush