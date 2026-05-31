<?php

namespace App\Filament\Admin\Resources\Prompts\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\RatingColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PromptsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) => $query->with(['work', 'aiTool', 'task']))
            ->columns([
                TextColumn::make('title')
                    ->label('Título')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('work.title_public')
                    ->label('Obra')
                    ->searchable(),

                TextColumn::make('aiTool.name')
                    ->label('Herramienta IA')
                    ->searchable()
                    ->badge(),

                TextColumn::make('task.task_type')
                    ->label('Tarea')
                    ->searchable()
                    ->placeholder('N/A'),

                RatingColumn::make('rating')
                    ->label('Rating')
                    ->sortable(),

                TextColumn::make('purpose')
                    ->label('Propósito')
                    ->searchable()
                    ->limit(30),

                TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('ai_tool_id')
                    ->label('Herramienta IA')
                    ->relationship('aiTool', 'name'),

                SelectFilter::make('task_id')
                    ->label('Tarea')
                    ->relationship('task', 'task_type'),
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
