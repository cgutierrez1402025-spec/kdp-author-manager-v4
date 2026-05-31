<?php

namespace App\Filament\Admin\Resources\Platforms\RelationManagers;

use App\Models\Marketplace;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Resources\RelationManagers\RelationManager;

class MarketplacesRelationManager extends RelationManager
{
    protected static ?string $relationship = 'marketplaces';

    protected static ?string $recordTitleAttribute = 'name';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nombre')
                    ->required()
                    ->maxLength(255),

                TextInput::make('code')
                    ->label('Código')
                    ->required()
                    ->maxLength(50),

                TextInput::make('currency')
                    ->label('Moneda')
                    ->required()
                    ->maxLength(3),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('code')
                    ->label('Código')
                    ->searchable(),

                TextColumn::make('currency')
                    ->label('Moneda')
                    ->badge()
                    ->color('primary'),

                TextColumn::make('publications_count')
                    ->label('Publicaciones')
                    ->counts('publications'),
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