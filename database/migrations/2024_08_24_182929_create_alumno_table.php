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
        Schema::create('alumnos', function (Blueprint $table) {
            $table->id();
            $table->string('alu_nombres', 64);
            $table->string('alu_apellidos', 64);
            $table->string('alu_tipo_documento', 64);
            $table->string('alu_numero_documento', 20);
            $table->string('alu_email', 128);
            $table->string('alu_telefono', 10);
            $table->string('alu_direccion', 128);
            $table->date('alu_fecha_nacimiento');
            $table->string('alu_estado', 1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumnos');
    }
};
