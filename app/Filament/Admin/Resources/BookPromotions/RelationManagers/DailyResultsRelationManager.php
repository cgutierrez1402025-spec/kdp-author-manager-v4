<?php

namespace App\Filament\Admin\Resources\BookPromotions\RelationManagers;

use App\Models\PromotionDailyResult;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Resources\RelationManagers\RelationManager;

class DailyResultsRelationManager extends RelationManager
{
    protected static ?string $relationship = 'dailyResults';

    protected static ?string $recordTitleAttribute = 'date';

    public static ?string $title = 'Resultados Diarios';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                DatePicker::make('date')
                    ->label('Fecha')
                    ->required(),

                TextInput::make('paid_units')
                    ->label('Unidades Pagadas')
                    ->numeric()
                    ->default(0),

                TextInput::make('free_units_promo')
                    ->label('Unidades Gratis (Promo)')
                    ->numeric()
                    ->default(0),

                TextInput::make('free_units_price_match')
                    ->label('Unidades Gratis (Price Match)')
                    ->numeric()
                    ->default(0),

                TextInput::make('kenp_pages_read')
                    ->label('Páginas KENP')
                    ->numeric()
                    ->default(0),

                TextInput::make('gross_royalties')
                    ->label('Royalties Brutas')
                    ->numeric()
                    ->step('0.01')
                    ->default(0),

                TextInput::make('net_royalties')
                    ->label('Royalties Netas')
                    ->numeric()
                    ->step('0.01')
                    ->default(0),

                TextInput::make('currency')
                    ->label('Moneda')
                    ->maxLength(3)
                    ->default('EUR'),

                TextInput::make('ranking_position')
                    ->label('Posición Ranking')
                    ->numeric()
                    ->nullable(),

                Textarea::make('notes')
                    ->label('Notas')
                    ->rows(2),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('date')
                    ->label('Fecha')
                    ->date()
                    ->sortable(),

                TextColumn::make('total_units')
                    ->label('Total Unidades')
                    ->state(fn (PromotionDailyResult $record) => $record->paid_units + $record->free_units_promo + $record->free_units_price_match),

                TextColumn::make('paid_units')
                    ->label('Pagadas')
                    ->sortable(),

                TextColumn::make('free_units_promo')
                    ->label('Gratis')
                    ->sortable(),

                TextColumn::make('net_royalties')
                    ->label('Royalties Netas')
                    ->money('EUR')
                    ->sortable(),
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