<?php

namespace App\Filament\Resources\RespuestaResource\Pages;

use App\Filament\Resources\RespuestaResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateRespuesta extends CreateRecord
{
    protected static string $resource = RespuestaResource::class;
    protected function afterSave(): void
    {
        // Redirige al usuario a la página de lista (index) después de crear la respuesta
        $this->redirect($this->getResource()::getUrl('index'));
    }
}

