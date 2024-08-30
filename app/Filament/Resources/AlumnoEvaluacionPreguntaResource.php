<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AlumnoEvaluacionPreguntaResource\Pages;
use App\Filament\Resources\AlumnoEvaluacionPreguntaResource\RelationManagers;
use App\Models\AlumnoEvaluacionPregunta;
use App\Models\Alumno;
use App\Models\Pregunta;
use App\Models\Evaluacion;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;

class AlumnoEvaluacionPreguntaResource extends Resource
{
    protected static ?string $model = AlumnoEvaluacionPregunta::class;

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
                Forms\Components\Select::make('evaluacion_id')
                    ->required()
                    ->label('Evaluacion')
                    ->options(
                        Evaluacion::all()->pluck('eva_descripcion', 'id')->toArray()
                    )
                    ->placeholder('Selecciona una evaluacion'),
                Forms\Components\Select::make('pregunta_id')
                ->required()
                ->options(
                    Pregunta::all()->pluck('pre_descripcion', 'id')->toArray()
                )
                ->label('Pregunta')
                ->placeholder('Selecciona una pregunta'),
                Forms\Components\Textarea::make('ale_respuesta')
                    ->maxLength(300)
                    ->default(null),
                Forms\Components\Toggle::make('ale_es_correcto'),
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
                Tables\Columns\TextColumn::make('evaluacion.eva_descripcion')
                    ->searchable()
                    ->label('Evaluacion')
                    //->formatStateUsing(fn ($state) => Evaluacion::find($state)?->eva_descripcion ?? 'No asignado')
                    ->sortable(),
                Tables\Columns\TextColumn::make('pregunta.pre_descripcion')
                    ->label('Pregunta')
                    //->formatStateUsing(fn ($state) => Pregunta::find($state)?->pre_descripcion ?? 'No asignado')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('ale_respuesta')
                    ->searchable(),
                Tables\Columns\IconColumn::make('ale_es_correcto')
                    ->boolean(),
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
                SelectFilter::make('alumno_id')
                    ->label('Alumno')
                    ->options(Alumno::all()->pluck('alu_nombres', 'id')->toArray()),

                SelectFilter::make('evaluacion_id')
                    ->label('Evaluacion')
                    ->options(Evaluacion::all()->pluck('eva_descripcion', 'id')->toArray()),

                SelectFilter::make('pregunta_id')
                    ->label('Pregunta')
                    ->options(Pregunta::all()->pluck('pre_descripcion', 'id')->toArray()),

                Filter::make('ale_respuesta')
                    ->label('Respuesta')
                    ->query(function (Builder $query, array $data) {
                        if (!empty($data['ale_respuesta'])) {
                            $query->where('ale_respuesta', 'like', '%' . $data['ale_respuesta'] . '%');
                        }
                    })
                    ->form([
                        Forms\Components\TextInput::make('ale_respuesta')
                            ->label('Buscar por Respuesta'),
                    ]),
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
            'index' => Pages\ListAlumnoEvaluacionPreguntas::route('/'),
            'create' => Pages\CreateAlumnoEvaluacionPregunta::route('/create'),
            'edit' => Pages\EditAlumnoEvaluacionPregunta::route('/{record}/edit'),
        ];
    }
}
