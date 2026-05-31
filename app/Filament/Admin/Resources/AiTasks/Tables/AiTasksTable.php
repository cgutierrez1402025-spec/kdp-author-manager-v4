<?php

namespace App\Filament\Admin\Resources\AiTasks\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AiTasksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) => $query->with(['work', 'preferredAiTool']))
            ->columns([
                TextColumn::make('work.title_public')
                    ->label('Obra')
                    ->searchable(),

                TextColumn::make('task_type')
                    ->label('Tipo')
                    ->searchable()
                    ->badge(),

                TextColumn::make('preferredAiTool.name')
                    ->label('Herramienta')
                    ->searchable(),

                TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
