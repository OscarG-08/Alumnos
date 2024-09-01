<?php

namespace App\Filament\Alumno\Pages;

use App\Models\Alumno;
use App\Models\Pregunta;
use Filament\Pages\Page;
use App\Models\Evaluacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AlumnoEvaluacionPregunta;

class RendirEvaluacion extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.alumno.pages.rendir-evaluacion';

    protected static bool $shouldRegisterNavigation = false;

    public $evaluacion;
    public $preguntas;
    public $respuestas = [];

    public function mount($evaluacion)
    {
        // Cargar la evaluación
        $this->evaluacion = Evaluacion::findOrFail($evaluacion);

        // Obtener el banco de preguntas del curso y seleccionar aleatoriamente según la cantidad de la evaluación
        $this->preguntas = Pregunta::where('curso_id', $this->evaluacion->curso_id)
            ->inRandomOrder()
            ->take($this->evaluacion->eva_cantidad_preguntas)
            ->get();
    }

    public function guardarRespuestas()
    {
        // Obtener el email del usuario autenticado
        $userEmail = Auth::user()->email;

        // Buscar el alumno que tiene ese email
        $alumno = Alumno::where('alu_email', $userEmail)->first();

        if ($alumno) {
            // Recorrer las preguntas y guardar las respuestas
            foreach ($this->preguntas as $pregunta) {
                // Guardar la respuesta escrita, si existe
                // if (isset($this->respuestas[$pregunta->id])) {
                //     AlumnoEvaluacionPregunta::create(
                //         [
                //             'alumno_id' => $alumno->id,
                //             'evaluacion_id' => $this->evaluacion->id,
                //             'pregunta_id' => $pregunta->id,
                //             'ale_respuesta' => $this->respuestas[$pregunta->id
                //         ]]
                //     );
                // }
                //
                if (isset($this->respuestas[$pregunta->id])) {
                    AlumnoEvaluacionPregunta::updateOrCreate(
                        [
                            'alumno_id' => $alumno->id,
                            'evaluacion_id' => $this->evaluacion->id,
                            'pregunta_id' => $pregunta->id,
                        ],
                        ['ale_respuesta' => $this->respuestas[$pregunta->id]]
                    );
                }
                
            }

            // Redirigir o mostrar un mensaje de éxito
            session()->flash('message', 'Respuestas guardadas con éxito.');
            // Asegúrate de que el método getUrl() devuelve la URL deseada
            //$url = Evaluaciones::getUrl();

            // Usar la URL para redirigir
            return redirect('alumno/evaluaciones');
        } else {
            session()->flash('error', 'No se pudo encontrar el alumno.');
        }
    }
}
