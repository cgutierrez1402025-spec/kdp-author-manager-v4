<?php

namespace App\Filament\Admin\Resources\Checklists\RelationManagers;

use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Table;
use Filament\Resources\RelationManagers\RelationManager;

class ItemsRelationManager extends RelationManager
{
    protected static ?string $relationship = 'items';

    protected static ?string $recordTitleAttribute = 'item';

    public static ?string $title = 'Elementos';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('item')
                    ->label('Elemento')
                    ->required()
                    ->maxLength(255),

                Toggle::make('is_checked')
                    ->label('Completado')
                    ->default(false),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('item')
                    ->label('Elemento')
                    ->searchable(),

                BooleanColumn::make('is_checked')
                    ->label('Completado')
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle'),

                TextColumn::make('checkedBy.name')
                    ->label('Completado por')
                    ->placeholder('N/A'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                CreateAction::make(),
            ]);
    }
}