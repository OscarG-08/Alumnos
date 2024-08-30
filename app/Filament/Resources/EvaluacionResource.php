<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EvaluacionResource\Pages;
use App\Filament\Resources\EvaluacionResource\RelationManagers;
use App\Models\Evaluacion;
use App\Models\Curso;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EvaluacionResource extends Resource
{
    protected static ?string $model = Evaluacion::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('curso_id')
                    ->required()
                    ->label('Curso')
                    ->options(
                        Curso::all()->pluck('cur_nombre', 'id')->toArray()
                    )
                    ->placeholder('Selecciona un curso'),
                Forms\Components\TextInput::make('eva_descripcion')
                    ->required()
                    ->label('Descripcion')
                    ->maxLength(128),
                Forms\Components\TextInput::make('eva_duracion')
                    ->required()
                    ->label('Duracion')
                    ->extraAttributes([
                        'onkeydown' => '
                            if(!/^[0-9]$/.test(event.key) && event.key !== "Backspace" && event.key !== "Delete"){
                                event.preventDefault();
                            }
                        '
                    ]),
                Forms\Components\TextInput::make('eva_cantidad_preguntas')
                    ->required()
                    ->label('Cantidad de Preguntas')
                    ->extraAttributes([
                        'onkeydown' => '
                            if(!/^[0-9]$/.test(event.key) && event.key !== "Backspace" && event.key !== "Delete"){
                                event.preventDefault();
                            }
                        '
                    ]),
                Forms\Components\TextInput::make('eva_intentos')
                    ->required()
                    ->label('N° Intentos')
                    ->extraAttributes([
                        'onkeydown' => '
                            if(!/^[0-9]$/.test(event.key) && event.key !== "Backspace" && event.key !== "Delete"){
                                event.preventDefault();
                            }
                        '
                    ]),
                Forms\Components\TextInput::make('eva_peso')
                    ->required()
                    ->label('Peso')
                    ->numeric(),
                Forms\Components\DateTimePicker::make('eva_fecha_inicio')
                    ->required()
                    ->label('Fecha de Inicio')
                    ->rules([
                        'after_or_equal:today', 
                        'after:today', 
                    ]),
                Forms\Components\DateTimePicker::make('eva_fecha_fin')
                    ->required()
                    ->label('Fecha de Fin')
                    ->rules([
                        'after_or_equal:today', 
                        'after:today', 
                    ]),
                Forms\Components\TextInput::make('eva_estado')
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
                    ->helperText('A: Activo | I:Inactivo'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('curso.cur_nombre')
                    ->label('Curso')
                    ->searchable()
                    //->formatStateUsing(fn ($state) => Curso::find($state)?->cur_nombre ?? 'No asignado')
                    ->sortable(),
                Tables\Columns\TextColumn::make('eva_descripcion')
                    ->searchable()
                    ->label('Descripcion'),
                Tables\Columns\TextColumn::make('eva_duracion')
                    ->numeric()
                    ->label('Duracion')
                    ->sortable(),
                Tables\Columns\TextColumn::make('eva_cantidad_preguntas')
                    ->numeric()
                    ->label('Cantidad de Preguntas')
                    ->sortable(),
                Tables\Columns\TextColumn::make('eva_intentos')
                    ->numeric()
                    ->label('N° Intentos')
                    ->sortable(),
                Tables\Columns\TextColumn::make('eva_peso')
                    ->numeric()
                    ->label('Peso')
                    ->sortable(),
                Tables\Columns\TextColumn::make('eva_fecha_inicio')
                    ->dateTime()
                    ->label('Fecha de Inicio')
                    ->sortable(),
                Tables\Columns\TextColumn::make('eva_fecha_fin')
                    ->dateTime()
                    ->label('Fecha de Fin')
                    ->sortable(),
                Tables\Columns\TextColumn::make('eva_estado')
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
            'index' => Pages\ListEvaluacions::route('/'),
            'create' => Pages\CreateEvaluacion::route('/create'),
            'edit' => Pages\EditEvaluacion::route('/{record}/edit'),
        ];
    }
}
