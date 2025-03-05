<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class respuestas16 extends Model
{
    use HasFactory;
    
    protected $table = 'respuestas16';
    
    protected $primaryKey = 'registro';
    
    protected $guarded = ['registro'];
}
