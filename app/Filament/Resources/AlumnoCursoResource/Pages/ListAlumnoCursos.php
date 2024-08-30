<?php

namespace App\Filament\Resources\AlumnoCursoResource\Pages;

use App\Filament\Resources\AlumnoCursoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAlumnoCursos extends ListRecords
{
    protected static string $resource = AlumnoCursoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
