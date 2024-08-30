<?php

namespace App\Filament\Resources\DocenteCursoResource\Pages;

use App\Filament\Resources\DocenteCursoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDocenteCurso extends EditRecord
{
    protected static string $resource = DocenteCursoResource::class;

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
