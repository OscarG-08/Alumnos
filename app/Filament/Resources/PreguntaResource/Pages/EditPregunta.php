<?php

namespace App\Filament\Resources\PreguntaResource\Pages;

use App\Filament\Resources\PreguntaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPregunta extends EditRecord
{
    protected static string $resource = PreguntaResource::class;

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
