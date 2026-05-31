<?php

namespace App\Filament\Admin\Resources\Publications\RelationManagers;

use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Resources\RelationManagers\RelationManager;

class KdpMetadataRelationManager extends RelationManager
{
    protected static ?string $relationship = 'kdpMetadata';

    protected static ?string $recordTitleAttribute = 'title';

    public static ?string $title = 'Metadatos KDP';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\TextInput::make('title')
                    ->label('Título')
                    ->maxLength(255),

                \Filament\Forms\Components\TextInput::make('subtitle')
                    ->label('Subtítulo')
                    ->maxLength(255),

                \Filament\Forms\Components\TextInput::make('author')
                    ->label('Autor')
                    ->maxLength(255),

                \Filament\Forms\Components\TextInput::make('series_name')
                    ->label('Nombre de Serie')
                    ->maxLength(255),

                \Filament\Forms\Components\TextInput::make('series_number')
                    ->label('Número de Serie')
                    ->numeric(),

                \Filament\Forms\Components\Textarea::make('description')
                    ->label('Descripción')
                    ->rows(4),

                \Filament\Forms\Components\TextInput::make('keywords')
                    ->label('Palabras Clave')
                    ->maxLength(255),

                \Filament\Forms\Components\TextInput::make('age_range')
                    ->label('Rango de Edad')
                    ->maxLength(50),

                \Filament\Forms\Components\Textarea::make('rights')
                    ->label('Derechos')
                    ->rows(2),

                \Filament\Forms\Components\Textarea::make('ai_declaration')
                    ->label('Declaración IA')
                    ->rows(2),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Título')
                    ->searchable(),

                TextColumn::make('subtitle')
                    ->label('Subtítulo')
                    ->searchable(),

                TextColumn::make('author')
                    ->label('Autor'),

                TextColumn::make('series_name')
                    ->label('Serie'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                CreateAction::make()
                    ->slideOver(),
            ]);
    }
}