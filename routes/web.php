<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EvaluacionController;

Route::get('/', function () {
    return view('welcome');
});

// Ruta para mostrar la evaluación
Route::get('/curso/{cursoId}/evaluacion', [EvaluacionController::class, 'show'])
    ->name('evaluacion.show')
    ->middleware('auth'); // Asegúrate de que el usuario esté autenticado

// Ruta para enviar las respuestas de la evaluación
Route::post('/evaluacion/submit', [EvaluacionController::class, 'submit'])
    ->name('evaluacion.submit')
    ->middleware('auth'); // Asegúrate de que el usuario esté autenticado
