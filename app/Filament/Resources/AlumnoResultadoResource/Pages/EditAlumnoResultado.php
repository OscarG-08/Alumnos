<?php

namespace App\Filament\Resources\AlumnoResultadoResource\Pages;

use App\Filament\Resources\AlumnoResultadoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAlumnoResultado extends EditRecord
{
    protected static string $resource = AlumnoResultadoResource::class;

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
