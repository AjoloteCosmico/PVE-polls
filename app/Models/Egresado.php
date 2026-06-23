<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Egresado extends Model
{
    use HasFactory;

    /**
     * Get the users assigned as encuestadores for this egresado's muestra.
     *
     * @return \Illuminate\Database\Eloquent\Collection<int, \App\Models\User>
     */
    public function encuestadoresDeMuestra()
    {
        return User::select('users.*')
            ->join('encuestador_muestra', 'encuestador_muestra.user_id', '=', 'users.id')
            ->where('encuestador_muestra.carrera', $this->carrera)
            ->where('encuestador_muestra.plantel', $this->plantel)
            ->where('encuestador_muestra.estudio_id', $this->muestra)
            ->distinct()
            ->get();
    }
    public function encuestadoresSondeo()
    {
        return User::where('clave', '30')
            ->distinct()
            ->get();
    }
}
