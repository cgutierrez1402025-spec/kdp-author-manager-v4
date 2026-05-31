<?php

namespace App\Filament\Admin\Resources\Checklists;

use App\Filament\Admin\Resources\Checklists\Pages\CreateChecklist;
use App\Filament\Admin\Resources\Checklists\Pages\EditChecklist;
use App\Filament\Admin\Resources\Checklists\Pages\ListChecklists;
use App\Filament\Admin\Resources\Checklists\Schemas\ChecklistForm;
use App\Filament\Admin\Resources\Checklists\Tables\ChecklistsTable;
use App\Models\Checklist;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ChecklistResource extends Resource
{
    protected static ?string $model = Checklist::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static ?string $navigationLabel = 'Listas de Verificación';

    protected static ?string $navigationGroup = 'Gestión';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return ChecklistForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ChecklistsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListChecklists::route('/'),
            'create' => CreateChecklist::route('/create'),
            'edit' => EditChecklist::route('/{record}/edit'),
        ];
    }
}