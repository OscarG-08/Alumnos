<?php

namespace App\Filament\Resources\AlumnoResultadoResource\Pages;

use App\Filament\Resources\AlumnoResultadoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAlumnoResultados extends ListRecords
{
    protected static string $resource = AlumnoResultadoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
