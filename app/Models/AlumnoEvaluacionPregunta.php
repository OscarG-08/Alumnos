<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlumnoEvaluacionPregunta extends Model
{
    use HasFactory;

    protected $fillable = ['alumno_id', 'evaluacion_id', 'pregunta_id', 'ale_respuesta', 'ale_es_correcto'];

    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }

    public function evaluacion()
    {
        return $this->belongsTo(Evaluacion::class);
    }

    public function pregunta()
    {
        return $this->belongsTo(Pregunta::class);
    }
}
