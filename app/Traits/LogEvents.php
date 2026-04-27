<?php
namespace App\Traits;

use App\Models\Event;
use Illuminate\Support\Facades\Auth;

trait LogEvents
{
    /**
     * Registra un evento en la base de datos de forma sencilla
     */
    public function recordEvent(int $modelId, string $eventName, string $description): void
    {
        Event::create([
            'user_id'     => Auth::id(),
            'model_id'    => $modelId,
            'event'       => $eventName,
            'description' => $description,
        ]);
    }
}