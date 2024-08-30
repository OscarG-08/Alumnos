<?php

namespace App\Filament\Resources\AlumnoCursoResource\Pages;

use App\Filament\Resources\AlumnoCursoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAlumnoCurso extends EditRecord
{
    protected static string $resource = AlumnoCursoResource::class;

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
