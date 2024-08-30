<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;

    protected $fillable = ['cur_nombre', 'cur_descripcion', 'cur_duracion', 'cur_estado'];

    public function evaluaciones()
    {
        return $this->hasMany(Evaluacion::class);
    }

    public function preguntas()
    {
        return $this->hasMany(Pregunta::class);
    }

    public function alumnos()
    {
        return $this->belongsToMany(Alumno::class, 'alumno_cursos');
    }

    public function docentes()
    {
        return $this->belongsToMany(Docente::class, 'docente_curso');
    }
}
