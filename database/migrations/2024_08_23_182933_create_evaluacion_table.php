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
        Schema::create('evaluaciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('curso_id');
            $table->string('eva_descripcion', 128);
            $table->integer('eva_duracion');
            $table->integer('eva_cantidad_preguntas');
            $table->integer('eva_intentos');
            $table->decimal('eva_peso', 10, 2);
            $table->dateTime('eva_fecha_inicio');
            $table->dateTime('eva_fecha_fin');
            $table->string('eva_estado', 1);
            $table->timestamps();
        });

        // Claves foráneas
        Schema::table('evaluaciones', function($table) {
            $table->foreign('curso_id')->references('id')->on('cursos');
        });
    }

    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluaciones');
    }
};
