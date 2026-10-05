<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class respuestas_credencial extends Model
{
    use HasFactory;
    protected $primaryKey = 'registro';

    protected $table = 'respuestas_credencial';

    protected $guarded = ['registro']; 
}
