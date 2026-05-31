<?php

namespace App\Filament\Admin\Resources\PromotionCosts\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PromotionCostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryQueryUsing(fn ($query) => $query->with('bookPromotion'))
            ->columns([
                TextColumn::make('bookPromotion.promotion_name')
                    ->label('Promoción')
                    ->searchable()
                    ->limit(30),

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

                TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('cost_type')
                    ->label('Tipo de Costo')
                    ->options([
                        'advertising' => 'Publicidad',
                        'promotion' => 'Promoción',
                        'marketing' => 'Marketing',
                        'tools' => 'Herramientas',
                        'other' => 'Otro',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}