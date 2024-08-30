<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DocenteCursoResource\Pages;
use App\Filament\Resources\DocenteCursoResource\RelationManagers;
use App\Models\DocenteCurso;
use App\Models\Curso;
use App\Models\Docente;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DocenteCursoResource extends Resource
{
    protected static ?string $model = DocenteCurso::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('docente_id')
                    ->required()
                    ->options(
                        Docente::all()->mapWithKeys(function ($docente) {
                            return [$docente->id => "{$docente->dce_nombres} {$docente->dce_apellidos}"];
                        })->toArray()
                    )
                    ->label('Docente')
                    ->placeholder('Selecciona un docente'),
                Forms\Components\Select::make('curso_id')
                    ->required()
                    ->options(
                        Curso::all()->pluck('cur_nombre', 'id')->toArray()
                    )
                    ->label('Curso')
                    ->placeholder('Selecciona un curso'),
                Forms\Components\DateTimePicker::make('dcc_fecha_asignacion')
                //VERIFICAR
                    ->required()
                    ->label('Fecha de Asignacion'),
                Forms\Components\TextInput::make('dcc_estado')
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
                Tables\Columns\TextColumn::make('docente_id')
                    ->sortable()
                    ->label('Docente')
                    ->formatStateUsing(fn ($state) => Docente::find($state)?->dce_nombres . ' ' . Docente::find($state)?->dce_apellidos ?? 'No asignado')
                    ->searchable(query: function ($query, $search) {
                        return $query->whereHas('docente', function ($query) use ($search) {
                            $query->whereRaw("CONCAT(dce_nombres, ' ', dce_apellidos) LIKE ?", "%{$search}%");
                        });
                    }),
                Tables\Columns\TextColumn::make('curso.cur_nombre')
                    ->sortable()
                    ->searchable()
                    ->label('Curso'),
                    //->formatStateUsing(fn ($state) => Curso::find($state)?->cur_nombre ?? 'No asignado'),
                Tables\Columns\TextColumn::make('dcc_fecha_asignacion')
                    ->dateTime()
                    ->sortable()
                    ->label('Fecha de Asignacion'),
                Tables\Columns\TextColumn::make('dcc_estado')
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
            'index' => Pages\ListDocenteCursos::route('/'),
            'create' => Pages\CreateDocenteCurso::route('/create'),
            'edit' => Pages\EditDocenteCurso::route('/{record}/edit'),
        ];
    }
}
