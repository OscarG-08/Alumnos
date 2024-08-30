<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlumnoResultado extends Model
{
    use HasFactory;

    protected $table = "alumnos_resultados";
    protected $fillable = ['evaluacion_id', 'alumno_id', 'evr_nota'];

    public function evaluacion()
    {
        return $this->belongsTo(Evaluacion::class);
    }

    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }
}
