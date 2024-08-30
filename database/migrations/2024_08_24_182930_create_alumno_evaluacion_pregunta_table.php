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
        Schema::create('alumno_evaluacion_preguntas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('alumno_id');
            $table->unsignedBigInteger('evaluacion_id');
            $table->unsignedBigInteger('pregunta_id');
            $table->string('ale_respuesta', 300)->nullable();
            $table->boolean('ale_es_correcto')->nullable();
            $table->timestamps();
        });

        // Claves foráneas
        Schema::table('alumno_evaluacion_preguntas', function($table) {
            $table->foreign('alumno_id')->references('id')->on('alumnos');
            $table->foreign('evaluacion_id')->references('id')->on('evaluaciones');
            $table->foreign('pregunta_id')->references('id')->on('preguntas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumno_evaluacion_preguntas');
    }
};
