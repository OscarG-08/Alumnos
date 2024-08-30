<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AlumnoResultadoResource\Pages;
use App\Filament\Resources\AlumnoResultadoResource\RelationManagers;
use App\Models\AlumnoResultado;
use App\Models\Evaluacion;
use App\Models\Alumno;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AlumnoResultadoResource extends Resource
{
    protected static ?string $model = AlumnoResultado::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('evaluacion_id')
                    ->required()
                    ->options(
                        Evaluacion::all()->pluck('eva_descripcion', 'id')->toArray()
                    )
                    ->label('Evaluación')
                    ->placeholder('Selecciona una evaluación'),
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
                Forms\Components\TextInput::make('evr_nota')
                ->required()
                ->label('Nota')
                ->extraAttributes([
                    'onkeydown' => '
                        if(!/[0-9.,]/.test(event.key) && event.key !== "Backspace" && event.key !== "Delete" && event.key !== "ArrowLeft" && event.key !== "ArrowRight" && event.key !== "Tab") {
                            event.preventDefault();
                        }
                    ',
                    'oninput' => '
                        const value = event.target.value;
                        const dotsAndCommas = value.match(/[.,]/g);
                        if (dotsAndCommas && dotsAndCommas.length > 1) {
                            event.target.value = value.slice(0, -1);
                        }
                    ',
                ])
                ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('evaluacion.eva_descripcion')
                    ->label('Evaluacion')
                    //->formatStateUsing(fn ($state) => Evaluacion::find($state)?->eva_descripcion ?? 'No asignado')
                    ->sortable()
                    ->searchable(),
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
                Tables\Columns\TextColumn::make('evr_nota')
                    ->numeric()
                    ->searchable()
                    ->label('Nota')
                    ->sortable(),
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
            'index' => Pages\ListAlumnoResultados::route('/'),
            'create' => Pages\CreateAlumnoResultado::route('/create'),
            'edit' => Pages\EditAlumnoResultado::route('/{record}/edit'),
        ];
    }
}
