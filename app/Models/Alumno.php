<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    use HasFactory;

    protected $fillable = [
        'alu_nombres', 'alu_apellidos', 'alu_tipo_documento', 'alu_numero_documento',
        'alu_email', 'alu_telefono', 'alu_direccion', 'alu_fecha_nacimiento', 'alu_estado'
    ];

    

    public function cursos()
    {
        return $this->belongsToMany(Curso::class, 'alumno_cursos');
    }

    public function evaluaciones()
    {
        return $this->belongsToMany(Evaluacion::class, 'alumno_evaluacion_preguntas')
                    ->withPivot('pregunta_id', 'ale_respuesta', 'ale_es_correcto');
    }

    public function resultados()
    {
        return $this->hasMany(AlumnoResultado::class);
    }
}
