<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PreguntaResource\Pages;
use App\Filament\Resources\PreguntaResource\RelationManagers;
use App\Models\Pregunta;
use App\Models\Curso;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PreguntaResource extends Resource
{
    protected static ?string $model = Pregunta::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('curso_id')
                ->required()
                ->options(
                    Curso::all()->pluck('cur_nombre', 'id')->toArray()
                )
                ->label('Curso')
                ->placeholder('Selecciona un curso'),
                Forms\Components\Select::make('pre_tipo')
                ->required()
                ->options([
                    'Opción múltiple' => 'Opción múltiple',
                    'Verdadero/Falso' => 'Verdadero/Falso',
                    'Respuesta corta' => 'Respuesta corta',
                    'Ensayo' => 'Ensayo',
                ])
                ->label('Tipo de Pregunta')
                ->placeholder('Selecciona un tipo de pregunta'),
                Forms\Components\TextInput::make('pre_descripcion')
                    ->required()
                    ->label('Descripcion')
                    ->maxLength(128),
                Forms\Components\TextInput::make('pre_puntuacion')
                    ->required()
                    ->label('Puntuacion')
                    ->extraAttributes([
                        'onkeydown' => '
                            if(!/^[0-9]$/.test(event.key) && event.key !== "Backspace" && event.key !== "Delete"){
                                event.preventDefault();
                            }
                        '
                    ]),
                Forms\Components\TextInput::make('pre_estado')
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
                Tables\Columns\TextColumn::make('curso.cur_nombre')
                    //->formatStateUsing(fn ($state) => Curso::find($state)?->cur_nombre ?? 'No asignado')
                    ->label('Curso')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('pre_tipo')
                    ->searchable()
                    ->label('Tipo de Pregunta'),
                Tables\Columns\TextColumn::make('pre_descripcion')
                    ->label('Descripcion')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pre_puntuacion')
                    ->label('Puntuacion')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('pre_estado')
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
            'index' => Pages\ListPreguntas::route('/'),
            'create' => Pages\CreatePregunta::route('/create'),
            'edit' => Pages\EditPregunta::route('/{record}/edit'),
        ];
    }
}
