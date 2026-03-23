<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    // Bloqueos — las dos columnas más consultadas
    Schema::table('bloqueos', function (Blueprint $table) {
        $table->index('clave_reactivo');
        $table->index('valor');
    });

    // Reactivos
    Schema::table('reactivos', function (Blueprint $table) {
        $table->index('clave');
        $table->index('section');
    });

    // Respuestas múltiples — búsquedas combinadas frecuentes
    Schema::table('multiple_option_answers', function (Blueprint $table) {
        $table->index(['encuesta_id', 'reactivo']);
        $table->index('clave_opcion');
    });

    // Egresados y encuestas
    Schema::table('egresados_especialidad', function (Blueprint $table) {
        $table->index('cuenta');
    });

    Schema::table('respuestas_especialidad', function (Blueprint $table) {
        $table->index('cuenta');
    });
}
};
