<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class respuestasPosgrado extends Model
{
    use HasFactory;

    protected $table = 'respuestas_posgrado';

    protected $primaryKey = 'registro';

    protected $guarded = ['registro'];  
}
