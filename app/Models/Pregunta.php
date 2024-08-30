<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pregunta extends Model
{
    use HasFactory;

    protected $fillable = ['curso_id', 'pre_tipo', 'pre_descripcion', 'pre_puntuacion', 'pre_estado'];

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    public function respuestas()
    {
        return $this->hasMany(Respuesta::class);
    }
}
