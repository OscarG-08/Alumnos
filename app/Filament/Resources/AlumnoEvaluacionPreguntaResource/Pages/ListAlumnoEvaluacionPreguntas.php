<?php

namespace App\Filament\Resources\AlumnoEvaluacionPreguntaResource\Pages;

use App\Filament\Resources\AlumnoEvaluacionPreguntaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAlumnoEvaluacionPreguntas extends ListRecords
{
    protected static string $resource = AlumnoEvaluacionPreguntaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
