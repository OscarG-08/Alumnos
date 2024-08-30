<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DocenteResource\Pages;
use App\Filament\Resources\DocenteResource\RelationManagers;
use App\Models\Docente;
use App\Models\Departamento;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DocenteResource extends Resource
{
    protected static ?string $model = Docente::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('departamento_id')
                    ->required()
                    ->options(
                        Departamento::all()->pluck('dep_nombre', 'id')->toArray()
                    )
                    ->label('Departamento')
                    ->placeholder('Selecciona un departamento'),
                Forms\Components\TextInput::make('dce_nombres')
                    ->required()
                    ->label('Nombres')
                    ->helperText('Ejemplo: Nombre1 Nombre2')
                    ->maxLength(64),
                Forms\Components\TextInput::make('dce_apellidos')
                    ->required()
                    ->label('Apellidos')
                    ->helperText('Ejemplo: Apellido1 Apellido2')
                    ->maxLength(64),
                Forms\Components\Select::make('dce_tipo_documento')
                    ->required()
                    ->options([
                        'Cedula' => 'Cedula',
                        'Pasaporte' => 'Pasaporte',
                    ])
                    ->label('Tipo de documento')
                    ->placeholder('Seleccione una opcion'),
                Forms\Components\TextInput::make('dce_numero_documento')
                    ->required()
                    ->label('N° Documento')
                    ->extraAttributes([
                        'onkeydown' => '
                            if(!/^[0-9]$/.test(event.key) && event.key !== "Backspace" && event.key !== "Delete"){
                                event.preventDefault();
                            }
                        '
                        ])
                    ->maxLength(10),
                Forms\Components\TextInput::make('dce_email')
                    ->email()
                    ->required()
                    ->label('Email')
                    ->maxLength(128),
                Forms\Components\TextInput::make('dce_direccion')
                    ->required()
                    ->label('Direccion')
                    ->maxLength(128),
                Forms\Components\TextInput::make('dce_telefono')
                    ->tel()
                    ->required()
                    ->label('Telefono')
                    ->extraAttributes([
                        'onkeydown' => '
                            if(!/^[0-9]$/.test(event.key) && event.key !== "Backspace" && event.key !== "Delete"){
                                event.preventDefault();
                            }
                        '
                        ])
                    ->maxLength(10),
                Forms\Components\DatePicker::make('dce_fecha_nacimiento')
                    ->required()
                    ->label('Fecha de Nacimiento')
                    ->rules([
                        'before_or_equal:today', 
                        'before:today', 
                    ]),
                Forms\Components\TextInput::make('dce_salario')
                    ->required()
                    ->label('Salario')
                    ->numeric(),
                Forms\Components\DateTimePicker::make('dce_fecha_contratacion')
                //revisar la logica 
                    ->required()
                    ->label('Fecha de Contratacion')
                    ->rules([
                        'before_or_equal:today', 
                        'before:today', 
                    ]),
                Forms\Components\TextInput::make('dce_estado')
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
                Tables\Columns\TextColumn::make('departamento.dep_nombre')
                    ->searchable()
                    ->sortable()
                    //->formatStateUsing(fn ($state) => Departamento::find($state)?->dep_nombre ?? 'No asignado')
                    ->label('Departamento'),
                Tables\Columns\TextColumn::make('dce_nombres')
                    ->searchable()
                    ->label('Nombres'),
                Tables\Columns\TextColumn::make('dce_apellidos')
                    ->searchable()
                    ->label('Apellidos'),
                Tables\Columns\TextColumn::make('dce_tipo_documento')
                    ->searchable()
                    ->label('Tipo de Documento'),
                Tables\Columns\TextColumn::make('dce_numero_documento')
                    ->searchable()
                    ->label('N Documento'),
                Tables\Columns\TextColumn::make('dce_email')
                    ->searchable()
                    ->label('Email'),
                Tables\Columns\TextColumn::make('dce_direccion')
                    ->searchable()
                    ->label('Direccion'),
                Tables\Columns\TextColumn::make('dce_telefono')
                    ->searchable()
                    ->label('Telefono'),
                Tables\Columns\TextColumn::make('dce_fecha_nacimiento')
                    ->date()
                    ->sortable()
                    ->label('Fecha de Nacimiento'),
                Tables\Columns\TextColumn::make('dce_salario')
                    ->numeric()
                    ->sortable()
                    ->label('Salario'),
                Tables\Columns\TextColumn::make('dce_fecha_contratacion')
                    ->dateTime()
                    ->sortable()
                    ->label('Fecha de Contratacion'),
                Tables\Columns\TextColumn::make('dce_estado')
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
            'index' => Pages\ListDocentes::route('/'),
            'create' => Pages\CreateDocente::route('/create'),
            'edit' => Pages\EditDocente::route('/{record}/edit'),
        ];
    }
}
