<?php

namespace App\Filament\Resources\DocenteCursoResource\Pages;

use App\Filament\Resources\DocenteCursoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDocenteCursos extends ListRecords
{
    protected static string $resource = DocenteCursoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
