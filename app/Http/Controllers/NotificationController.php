<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()->notifications()->paginate(20);
        
        return view('notifications.index', compact('notifications'));
    }
    
    public function markAsReadAndRedirect($notificationId)
    {
        // Buscar la notificación del usuario autenticado
        $notification = Auth::user()->notifications()
            ->where('id', $notificationId)
            ->firstOrFail();
        
        // Marcar como leída
        $notification->markAsRead();
        
        // Obtener la URL de acción desde los datos de la notificación
        $actionUrl = $notification->data['action_url'] ?? '/dashboard';
        
        // Redirigir
        return redirect($actionUrl);
    }
}
