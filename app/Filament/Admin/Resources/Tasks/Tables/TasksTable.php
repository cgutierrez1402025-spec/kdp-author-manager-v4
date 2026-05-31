<?php

namespace App\Filament\Admin\Resources\Tasks\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class TasksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryQueryUsing(fn ($query) => $query->with(['work', 'assignedTo']))
            ->columns([
                TextColumn::make('title')
                    ->label('Título')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('work.title_public')
                    ->label('Obra')
                    ->searchable()
                    ->placeholder('N/A'),

                TextColumn::make('assignedTo.name')
                    ->label('Asignado a')
                    ->searchable()
                    ->placeholder('Sin asignar'),

                TextColumn::make('priority')
                    ->label('Prioridad')
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'low' => 'gray',
                        'medium' => 'warning',
                        'high' => 'danger',
                        'urgent' => 'info',
                        default => 'gray',
                    }),

                TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'pending' => 'gray',
                        'in_progress' => 'warning',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('due_date')
                    ->label('Vencimiento')
                    ->date()
                    ->sortable()
                    ->color('danger'),

                TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Estado')
                    ->options([
                        'pending' => 'Pendiente',
                        'in_progress' => 'En Progreso',
                        'completed' => 'Completada',
                    ]),

                SelectFilter::make('assigned_to')
                    ->label('Asignado a')
                    ->relationship('assignedTo', 'name'),
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