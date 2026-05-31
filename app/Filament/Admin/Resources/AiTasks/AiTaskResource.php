<?php

namespace App\Filament\Admin\Resources\AiTasks;

use App\Filament\Admin\Resources\AiTasks\Pages\CreateAiTask;
use App\Filament\Admin\Resources\AiTasks\Pages\EditAiTask;
use App\Filament\Admin\Resources\AiTasks\Pages\ListAiTasks;
use App\Filament\Admin\Resources\AiTasks\Schemas\AiTaskForm;
use App\Filament\Admin\Resources\AiTasks\Tables\AiTasksTable;
use App\Models\AiTask;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AiTaskResource extends Resource
{
    protected static ?string $model = AiTask::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedQueueList;

    protected static ?string $navigationLabel = 'Tareas IA';

    protected static ?string $recordTitleAttribute = 'task_type';

    public static function form(Schema $schema): Schema
    {
        return AiTaskForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AiTasksTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAiTasks::route('/'),
            'create' => CreateAiTask::route('/create'),
            'edit' => EditAiTask::route('/{record}/edit'),
        ];
    }
}