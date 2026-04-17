<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// Importamos el modelo de Respuestas20 para poder consultarlo
use App\Models\Respuestas20; 

class EgresadoPosgrado extends Model
{
    use HasFactory;
    
    protected $table = 'egresados_posgrado';

    /**
     * The "booted" method of the model.
     */
    protected static function booted()
    {
        static::saving(function ($egresado) {
            // Buscamos si existe un registro en Respuestas20 que coincida
            // con la 'cuenta' y esté marcado como completado ('1')
            $tieneRespuestaCompletada = \DB::table('respuestas_posgrado')
                ->where('cuenta', $egresado->cuenta)
                ->where('completed', '1')
                ->exists();

            if ($tieneRespuestaCompletada) {
                // Si el estatus actual no es 1, lo forzamos a ser 1
                if ($egresado->status != '1') {
                    $egresado->status = '1';
                }
            }
        });
    }
}