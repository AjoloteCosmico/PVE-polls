<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
// Importamos el modelo de Respuestas20 para poder consultarlo
use App\Models\Respuestas20; 

class EgresadoPosgrado extends Model
{
    use HasFactory;
    
    protected $table = 'egresados_posgrado';

    public function encuestadoresDeMuestra()
    {
        return User::select('users.*')
            ->join('encuestador_muestra', 'encuestador_muestra.user_id', '=', 'users.id')
            ->where('encuestador_muestra.programa_pos', $this->programa)
            ->distinct()
            ->get();
    }

}