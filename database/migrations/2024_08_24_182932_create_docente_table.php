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
        Schema::create('docentes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('departamento_id');
            $table->string('dce_nombres', 64);
            $table->string('dce_apellidos', 64);
            $table->string('dce_tipo_documento', 64);
            $table->string('dce_numero_documento', 20);
            $table->string('dce_email', 128);
            $table->string('dce_direccion', 128);
            $table->string('dce_telefono', 10);
            $table->date('dce_fecha_nacimiento');
            $table->decimal('dce_salario', 10, 2);
            $table->dateTime('dce_fecha_contratacion');
            $table->string('dce_estado', 1);
            $table->timestamps();
        });

        // Claves foráneas
        Schema::table('docentes', function($table) {
            $table->foreign('departamento_id')->references('id')->on('departamentos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('docentes');
    }
};
