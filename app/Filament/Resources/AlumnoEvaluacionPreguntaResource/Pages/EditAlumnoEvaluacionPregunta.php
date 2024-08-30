<?php

namespace App\Filament\Resources\AlumnoEvaluacionPreguntaResource\Pages;

use App\Filament\Resources\AlumnoEvaluacionPreguntaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAlumnoEvaluacionPregunta extends EditRecord
{
    protected static string $resource = AlumnoEvaluacionPreguntaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    protected function afterSave(): void
    {
        $this->redirect($this->getResource()::getUrl('index'));
    }
}
