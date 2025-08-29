<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    use HasFactory;
    protected $table = 'comentario';
    protected $primaryKey = 'registro';

     protected $fillable = [
        'comentario',
        'cuenta',
        // Si hay otras columnas que deseas actualizar de forma masiva, agrégalas aquí.
    ];
}
