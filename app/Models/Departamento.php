<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    use HasFactory;

    protected $fillable = ['dep_nombre', 'dep_descripcion', 'dep_estado'];

    public function docentes()
    {
        return $this->hasMany(Docente::class);
    }
}
