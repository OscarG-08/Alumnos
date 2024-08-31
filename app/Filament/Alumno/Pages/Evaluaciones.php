<?php

namespace App\Filament\Alumno\Pages;

use App\Models\Alumno;
use Filament\Pages\Page;
use App\Models\Evaluacion;
use App\Models\AlumnoCurso;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class Evaluaciones extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.alumno.pages.evaluaciones';

    public $evaluaciones;

    public function mount()
    {
        // Obtener el email del usuario autenticado
        $userEmail = Auth::user()->email;

        // Buscar el alumno que tiene ese email
        $alumno = Alumno::where('alu_email', $userEmail)->first();

        if ($alumno) {
            // Obtener los IDs de los cursos en los que el alumno está inscrito y que están activos
            $cursosIds = AlumnoCurso::where('alumno_id', $alumno->id)
                ->where('alc_estado', 'A') // A: Activo
                ->pluck('curso_id');

            // Cargar las evaluaciones activas de los cursos en los que el alumno está inscrito
            $this->evaluaciones = Evaluacion::whereIn('curso_id', $cursosIds)
                ->where('eva_estado', 'A') // A: Activo
                ->where('eva_fecha_fin', '>=', Carbon::now())
                ->get();
        } else {
            // Si no se encuentra el alumno, no mostrar evaluaciones
            $this->evaluaciones = collect();
        }
    }

    public function redirectToEvaluacion($evaluacionId)
    {
        return redirect()->route('filament.pages.rendir-evaluacion', ['evaluacion' => $evaluacionId]);
    }
}
