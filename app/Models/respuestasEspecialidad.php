<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class respuestasEspecialidad extends Model
{
    use HasFactory;
    protected $table = 'respuestas_especialidad';

    protected $primaryKey = 'registro';

    protected $guarded = ['registro'];  
}
