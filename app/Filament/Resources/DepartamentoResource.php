<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DepartamentoResource\Pages;
use App\Filament\Resources\DepartamentoResource\RelationManagers;
use App\Models\Departamento;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DepartamentoResource extends Resource
{
    protected static ?string $model = Departamento::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('dep_nombre')
                    ->required()
                    ->label('Nombre')
                    ->maxLength(64),
                Forms\Components\TextInput::make('dep_descripcion')
                    ->required()
                    ->label('Descripcion')
                    ->maxLength(128),
                Forms\Components\TextInput::make('dep_estado')
                    ->required()
                    ->label('Estado')
                    ->maxLength(1)
                    ->extraAttributes([
                        'onkeydown' => '
                            if (["Backspace", "ArrowLeft", "ArrowRight", "Delete"].includes(event.key)) {
                                return;
                            }
                            if (event.key !== "A" && event.key !== "I") {
                                event.preventDefault();
                            } else {
                                // Fuerza la tecla a mayúscula si es una letra permitida
                                event.key = event.key.toUpperCase();
                            }
                        '
                    ])
                    ->helperText('A: Activo | I: Inactivo'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('dep_nombre')
                    ->searchable() ->label('Nombre'),
                Tables\Columns\TextColumn::make('dep_descripcion')
                    ->searchable() ->label('Descripcion'),
                Tables\Columns\TextColumn::make('dep_estado')
                    ->searchable() ->label('Estado'),
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
            'index' => Pages\ListDepartamentos::route('/'),
            'create' => Pages\CreateDepartamento::route('/create'),
            'edit' => Pages\EditDepartamento::route('/{record}/edit'),
        ];
    }
}
