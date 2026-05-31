<?php

namespace App\Filament\Admin\Resources\Checklists\Schemas;

use Filament\Forms;
use Filament\Schemas\Schema;

class ChecklistForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\Section::make('Lista de Verificación')
                    ->schema([
                        Forms\Components\Select::make('work_id')
                            ->relationship('work', 'title_public')
                            ->label('Obra')
                            ->required(),

                        Forms\Components\TextInput::make('name')
                            ->label('Nombre')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Textarea::make('description')
                            ->label('Descripción')
                            ->rows(2),
                    ]),
            ]);
    }
}