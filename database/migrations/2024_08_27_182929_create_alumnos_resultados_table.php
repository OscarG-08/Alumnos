<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('alumnos_resultados', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('evaluacion_id');
            $table->unsignedBigInteger('alumno_id');
            $table->decimal('evr_nota', 10, 2);
            $table->timestamps();
        });

        // Claves foráneas
        Schema::table('alumnos_resultados', function($table) {
            $table->foreign('evaluacion_id')->references('id')->on('evaluaciones');
            $table->foreign('alumno_id')->references('id')->on('alumnos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumnos_resultados');
    }
};
