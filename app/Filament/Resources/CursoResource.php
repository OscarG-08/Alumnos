<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CursoResource\Pages;
use App\Filament\Resources\CursoResource\RelationManagers;
use App\Models\Curso;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CursoResource extends Resource
{
    protected static ?string $model = Curso::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('cur_nombre')
                    ->required()
                    ->label('Nombre')
                    ->maxLength(64),
                Forms\Components\TextInput::make('cur_descripcion')
                    ->required()
                    ->label('Descripcion')
                    ->maxLength(128),
                Forms\Components\TextInput::make('cur_duracion')
                //Verificar
                    ->required()
                    ->label('Duracion')
                    ->extraAttributes([
                        'onkeydown' => '
                            if(!/^[0-9]$/.test(event.key) && event.key !== "Backspace" && event.key !== "Delete"){
                                event.preventDefault();
                            }
                        '
                    ])
                    ->helperText('Mes? Anio?'),
                Forms\Components\TextInput::make('cur_estado')
                    ->required()
                    ->label('Estado')
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
                    ->maxLength(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('cur_nombre')
                    ->searchable()
                    ->label('Nombre'),
                Tables\Columns\TextColumn::make('cur_descripcion')
                    ->searchable()
                    ->label('Descripcion'),
                Tables\Columns\TextColumn::make('cur_duracion')
                    ->numeric()
                    ->sortable()
                    ->label('Duracion'),
                Tables\Columns\TextColumn::make('cur_estado')
                    ->searchable()
                    ->label('Estado'),
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
            'index' => Pages\ListCursos::route('/'),
            'create' => Pages\CreateCurso::route('/create'),
            'edit' => Pages\EditCurso::route('/{record}/edit'),
        ];
    }
}
