<?php

namespace App\Filament\Admin\Resources\BookPromotions\RelationManagers;

use App\Models\PromotionCost;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Resources\RelationManagers\RelationManager;

class CostsRelationManager extends RelationManager
{
    protected static ?string $relationship = 'costs';

    protected static ?string $recordTitleAttribute = 'cost_type';

    public static ?string $title = 'Costos';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('cost_type')
                    ->label('Tipo de Costo')
                    ->options([
                        'advertising' => 'Publicidad',
                        'promotion' => 'Promoción',
                        'marketing' => 'Marketing',
                        'tools' => 'Herramientas',
                        'other' => 'Otro',
                    ])
                    ->required(),

                TextInput::make('description')
                    ->label('Descripción')
                    ->maxLength(255),

                TextInput::make('amount')
                    ->label('Importe')
                    ->numeric()
                    ->step('0.01')
                    ->required(),

                TextInput::make('currency')
                    ->label('Moneda')
                    ->maxLength(3)
                    ->default('EUR')
                    ->required(),

                DatePicker::make('date')
                    ->label('Fecha')
                    ->required(),

                Textarea::make('notes')
                    ->label('Notas')
                    ->rows(2),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('cost_type')
                    ->label('Tipo')
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'advertising' => 'primary',
                        'promotion' => 'warning',
                        'marketing' => 'info',
                        'tools' => 'success',
                        default => 'gray',
                    }),

                TextColumn::make('description')
                    ->label('Descripción')
                    ->limit(30),

                TextColumn::make('amount')
                    ->label('Importe')
                    ->money('EUR')
                    ->sortable(),

                TextColumn::make('date')
                    ->label('Fecha')
                    ->date()
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