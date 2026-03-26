<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class respuestas_verdes extends Model
{
    use HasFactory;
    
    
    protected $primaryKey = 'id';

    protected $table = 'respuestas_verdes';

    protected $guarded = ['id'];  
}