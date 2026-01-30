<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class respuestas_continua extends Model
{
    use HasFactory;
    
    
    protected $primaryKey = 'registro';

    protected $table = 'respuestas_continua';

    protected $guarded = ['registro'];  
}
