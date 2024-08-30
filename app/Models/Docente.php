<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    use HasFactory;

    protected $fillable = [
        'departamento_id', 'dce_nombres', 'dce_apellidos', 'dce_tipo_documento',
        'dce_numero_documento', 'dce_email', 'dce_direccion', 'dce_telefono',
        'dce_fecha_nacimiento', 'dce_salario', 'dce_fecha_contratacion', 'dce_estado'
    ];

    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }

    public function cursos()
    {
        return $this->belongsToMany(Curso::class, 'docente_curso');
    }
}
