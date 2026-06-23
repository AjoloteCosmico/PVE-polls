@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="mb-0">Notificaciones</h1>
            <p class="text-muted mb-0">Todas las notificaciones de tu cuenta.</p>
        </div>
        <span class="badge badge-secondary">{{ $notifications->total() }} total{{ $notifications->total() === 1 ? '' : 'es' }}</span>
    </div>

    @if($notifications->count())
        <div class="table-responsive">
            <table class="table  table-bordered" class="notification_table">
                <thead>
                    <tr>
                        <th>Estado</th>
                        <th>Mensaje</th>
                        <th>Fecha</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($notifications as $notification)
                        <tr class="{{ is_null($notification->read_at) ? 'table-warning' : '' }}">
                            <td>
                                @if(is_null($notification->read_at))
                                    <span class="badge badge-danger">No leído</span>
                                @else
                                    <span class="badge badge-success">Leído</span>
                                @endif
                            </td>
                            <td>
                                <i class="{{ $notification->data['icon'] ?? 'fas fa-bell' }} mr-2"></i>
                                {{ $notification->data['message'] ?? json_encode($notification->data) }}
                            </td>
                            <td>{{ $notification->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <a href="{{ route('notifications.read', $notification->id) }}" class="btn btn-sm btn-primary">
                                    @if(is_null($notification->read_at))
                                        Marcar como leída y abrir
                                    @else
                                        Ver
                                    @endif
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center">
            {{ $notifications->links() }}
        </div>
    @else
        <div class="alert alert-info">
            No hay notificaciones por mostrar.
        </div>
    @endif
</div>
@endsection


@push('css')
<style>
    .notification_table{
        td{
            background-color: #444749 !important;
        }


    }
</style>
@endpush