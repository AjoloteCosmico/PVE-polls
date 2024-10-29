<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresas extends Model
{
    use HasFactory;
    // Aquí defines los campos que se pueden asignar masivamente
    protected $fillable = [
        'usuario',
        'nombre',
        'giro',
        'clave_giro',
        'giro_especifico',
        'nota',
        'registro',
    ];

    // Si tienes un campo id autoincremental, no necesitas incluirlo en fillable.
}
