<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AlumnoCursoResource\Pages;
use App\Filament\Resources\AlumnoCursoResource\RelationManagers;
use App\Models\AlumnoCurso;
use App\Models\Alumno;
use App\Models\Curso;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AlumnoCursoResource extends Resource
{
    protected static ?string $model = AlumnoCurso::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('alumno_id')
                    ->required()
                    ->options(
                        Alumno::all()->mapWithKeys(function ($alumno) {
                            $nombreCompleto = trim("{$alumno->alu_nombres} {$alumno->alu_apellidos}");
                            return $nombreCompleto ? [$alumno->id => $nombreCompleto] : [];
                        })->filter()->toArray()
                    )
                    ->label('Alumno')
                    ->placeholder('Selecciona un alumno'),
                Forms\Components\Select::make('curso_id')
                    ->required()
                    ->options(
                        Curso::all()->pluck('cur_nombre', 'id')->toArray()
                    )
                    ->label('Curso')
                    ->placeholder('Selecciona un curso'),
                Forms\Components\DateTimePicker::make('alc_fecha_asignacion')
                //VERIFICAR
                    ->required()
                    ->label('Fecha de Asignacion'),
                Forms\Components\TextInput::make('alc_estado')
                    ->required()
                    ->maxLength(1)
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
                Tables\Columns\TextColumn::make('alumno_id')
                    ->label('Alumno')
                    ->formatStateUsing(function ($state) {
                        $alumno = Alumno::find($state);
                        return $alumno ? "{$alumno->alu_nombres} {$alumno->alu_apellidos}" : 'No asignado';
                    })
                    ->sortable()
                    ->searchable(query: function ($query, $search) {
                        return $query->whereHas('alumno', function ($query) use ($search) {
                            $query->whereRaw("CONCAT(alu_nombres, ' ', alu_apellidos) LIKE ?", "%{$search}%");
                        });
                    }),
                Tables\Columns\TextColumn::make('curso_id')
                    ->label('Curso')
                    ->formatStateUsing(fn ($state) => Curso::find($state)?->cur_nombre ?? 'No asignado')
                    ->sortable()
                    ->searchable(query: function ($query, $search) {
                        return $query->whereHas('curso', function ($query) use ($search) {
                            $query->where('cur_nombre', 'like', "%{$search}%");
                        });
                    }),
                Tables\Columns\TextColumn::make('alc_fecha_asignacion')
                    ->dateTime()
                    ->label('Fecha de Asignacion')
                    ->sortable(),
                Tables\Columns\TextColumn::make('alc_estado')
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
            'index' => Pages\ListAlumnoCursos::route('/'),
            'create' => Pages\CreateAlumnoCurso::route('/create'),
            'edit' => Pages\EditAlumnoCurso::route('/{record}/edit'),
        ];
    }
}
