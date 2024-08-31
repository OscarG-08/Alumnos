<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluacion extends Model
{
    use HasFactory;

    protected $table = "evaluaciones";
    
    protected $fillable = [
        'curso_id', 'eva_descripcion', 'eva_duracion', 'eva_cantidad_preguntas',
        'eva_intentos', 'eva_peso', 'eva_fecha_inicio', 'eva_fecha_fin', 'eva_estado'
    ];

    protected $casts = [
        'eva_fecha_inicio' => 'datetime',
        'eva_fecha_fin' => 'datetime',
    ];

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    public function preguntas()
    {
        return $this->belongsToMany(Pregunta::class, 'alumno_evaluacion_preguntas')
                    ->withPivot('alumno_id', 'ale_respuesta', 'ale_es_correcto');
    }

    public function resultados()
    {
        return $this->hasMany(AlumnoResultado::class);
    }
}
