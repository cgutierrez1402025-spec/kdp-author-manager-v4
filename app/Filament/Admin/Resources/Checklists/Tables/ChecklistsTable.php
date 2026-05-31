<?php

namespace App\Filament\Admin\Resources\Checklists\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ProgressBarColumn;
use Filament\Tables\Table;

class ChecklistsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('work.title_public')
                    ->label('Obra')
                    ->searchable(),

                TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),

                ProgressBarColumn::make('progress_percentage')
                    ->label('Progreso'),

                TextColumn::make('items_count')
                    ->label('Items')
                    ->counts('items'),

                TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime()
                    ->sortable(),
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