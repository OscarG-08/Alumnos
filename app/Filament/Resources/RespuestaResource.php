<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RespuestaResource\Pages;
use App\Filament\Resources\RespuestaResource\RelationManagers;
use App\Models\Respuesta;
use App\Models\Pregunta;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RespuestaResource extends Resource
{
    protected static ?string $model = Respuesta::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('pregunta_id')
                ->required()
                ->options(
                    Pregunta::all()->pluck('pre_descripcion', 'id')->toArray()
                )
                ->label('Pregunta')
                ->placeholder('Selecciona una pregunta'),
                Forms\Components\Textarea::make('res_descripcion_esperada')
                    ->required()
                    ->label('Respuesta Esperada')
                    ->maxLength(128),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('pregunta.pre_descripcion')
                    ->label('Pregunta')
                    ->searchable()
                    //->formatStateUsing(fn ($state) => Pregunta::find($state)?->pre_descripcion ?? 'No asignado')
                    ->sortable(),
                Tables\Columns\TextColumn::make('res_descripcion_esperada')
                    ->searchable()
                    ->label('Respuesta Esperada'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRespuestas::route('/'),
            'create' => Pages\CreateRespuesta::route('/create'),
            'edit' => Pages\EditRespuesta::route('/{record}/edit'),
        ];
    }
}
