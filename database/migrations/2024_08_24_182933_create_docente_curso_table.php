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
        Schema::create('docente_curso', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('docente_id');
            $table->unsignedBigInteger('curso_id');
            $table->dateTime('dcc_fecha_asignacion');
            $table->string('dcc_estado', 1);
            $table->timestamps();
        });

        // Claves foráneas
        Schema::table('docente_curso', function($table) {
            $table->foreign('docente_id')->references('id')->on('docentes');
            $table->foreign('curso_id')->references('id')->on('cursos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('docente_curso');
    }
};
