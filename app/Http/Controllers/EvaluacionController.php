<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curso;
use App\Models\Evaluacion;
use App\Models\AlumnoResultado;
use Illuminate\Support\Facades\Auth;

class EvaluacionController extends Controller
{
    public function show($cursoId)
    {
        $alumnoId = Auth::id(); // Obtener el ID del alumno autenticado

        // Obtener el curso y sus evaluaciones
        $curso = Curso::with('evaluaciones.preguntas')->findOrFail($cursoId);

        // Verificar si el alumno está inscrito en el curso
        $isEnrolled = $curso->alumnos()->where('alumno_id', $alumnoId)->exists();

        if (!$isEnrolled) {
            return redirect()->back()->with('error', 'No estás inscrito en este curso.');
        }

        // Obtener la evaluación asociada al curso (aquí debes decidir cómo seleccionar la evaluación correcta)
        $evaluacion = $curso->evaluaciones()->first(); // Selecciona la lógica adecuada si hay múltiples evaluaciones

        return view('evaluacion.show', compact('evaluacion'));
    }

    public function submit(Request $request)
{
    $alumnoId = Auth::id();
    $respuestas = $request->input('respuestas');
    $preguntaIds = $request->input('pregunta_ids');
    $evaluacionId = $request->input('evaluacion_id'); // Asegúrate de obtener este campo

    foreach ($preguntaIds as $index => $preguntaId) {
        AlumnoResultado::create([
            'alumno_id' => $alumnoId,
            'evaluacion_id' => $evaluacionId, // Agregar el ID de evaluación
            'pregunta_id' => $preguntaId,
            'respuesta' => $respuestas[$index],
        ]);
    }

    return redirect()->route('evaluacion.index')->with('success', 'Evaluación enviada con éxito.');
}
}
