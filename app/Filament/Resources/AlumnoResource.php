<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AlumnoResource\Pages;
use App\Filament\Resources\AlumnoResource\RelationManagers;
use App\Models\Alumno;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use PhpParser\Node\Stmt\Label;
use PHPUnit\Framework\Constraint\RegularExpression;

class AlumnoResource extends Resource
{
    protected static ?string $model = Alumno::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('alu_nombres')
                    ->required()
                    ->minLength(3)
                    ->maxLength(64)
                    ->label('Nombres')
                    ->helperText('Ejemplo: Nombre1 Nombre2')
                    ->extraAttributes([
                        'oninput' => '
                            let value = this.value;
                            // Reemplaza múltiples espacios consecutivos con un solo espacio
                            value = value.replace(/\s{2,}/g, " ");
                            // Elimina espacios al principio y al final
                            value = value.trim();
                            this.value = value;
                        ',
                        'onkeydown' => '
                            // Permite teclas de navegación y borrar
                            if (["Backspace", "ArrowLeft", "ArrowRight", "Delete"].includes(event.key)) {
                                return;
                            }
                            // Previene la inserción de espacios múltiples
                            if (event.key === " " && this.value.slice(-1) === " ") {
                                event.preventDefault();
                            }
                        '
                    ]),
                Forms\Components\TextInput::make('alu_apellidos')
                    ->required()
                    ->maxLength(64)
                    ->label('Apellidos')
                    ->helperText('Ejemplo: Apellido1 Apellido2'),
                Forms\Components\Select::make('alu_tipo_documento')
                    ->required()
                    ->options([
                        'Cedula' => 'Cedula',
                        'Pasaporte' => 'Pasaporte',
                    ])
                    ->label('Tipo de Documento')
                    ->placeholder('Seleccione una opcion'),
                Forms\Components\TextInput::make('alu_numero_documento')
                    ->required()
                    ->maxLength(10)
                    ->extraAttributes([
                        'onkeydown' => '
                            if(!/^[0-9]$/.test(event.key) && event.key !== "Backspace" && event.key !== "Delete"){
                                event.preventDefault();
                            }
                        '
                        ])
                    ->label('N Documento'),
                Forms\Components\TextInput::make('alu_email')
                    ->email()
                    ->required()
                    ->maxLength(128)
                    ->label('Email'),
                Forms\Components\TextInput::make('alu_telefono')
                    ->tel()
                    ->required()
                    ->maxLength(10)
                    ->extraAttributes(['onkeydown' => 'if(!/^[0-9]$/.test(event.key) && event.key !== "Backspace" && event.key !== "Delete"){event.preventDefault();}'])
                    ->label('Telefono'),
                Forms\Components\TextInput::make('alu_direccion')
                    ->required()
                    ->maxLength(128)
                    ->label('Direccion'),
                Forms\Components\DatePicker::make('alu_fecha_nacimiento')
                    ->required()
                    ->label('Fecha de Nacimiento')
                    ->rules([
                        'before_or_equal:today', 
                        'before:today', 
                    ]),
                Forms\Components\TextInput::make('alu_estado')
                    ->required()
                    ->maxLength(1)
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
                    ->helperText('A: Activo | I:Inactivo'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('alu_nombres')
                    ->searchable() ->label('Nombres'),
                Tables\Columns\TextColumn::make('alu_apellidos')
                    ->searchable() ->label('Apellidos'),
                Tables\Columns\TextColumn::make('alu_tipo_documento')
                    ->searchable() ->label('Tipo de Docuemento'),
                Tables\Columns\TextColumn::make('alu_numero_documento')
                    ->searchable() ->label('N Documento'),
                Tables\Columns\TextColumn::make('alu_email')
                    ->searchable() ->label('Correo'),
                Tables\Columns\TextColumn::make('alu_telefono')
                    ->searchable() ->label('Telefono'),
                Tables\Columns\TextColumn::make('alu_direccion')
                    ->searchable() ->label('Direccion'),
                Tables\Columns\TextColumn::make('alu_fecha_nacimiento')
                    ->date()
                    ->sortable()
                    ->label('Fecha de Nacimiento'),
                Tables\Columns\TextColumn::make('alu_estado')
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
            'index' => Pages\ListAlumnos::route('/'),
            'create' => Pages\CreateAlumno::route('/create'),
            'edit' => Pages\EditAlumno::route('/{record}/edit'),
        ];
    }
}
