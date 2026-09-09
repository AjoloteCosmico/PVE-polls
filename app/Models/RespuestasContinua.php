<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RespuestasContinua extends Model
{
    use HasFactory;
    
    protected $table = 'respuestas_continua';
    protected $primaryKey = 'registro';
}
