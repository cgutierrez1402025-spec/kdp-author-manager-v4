<?php

namespace App\Filament\Admin\Resources\AiTools;

use App\Filament\Admin\Resources\AiTools\Pages\CreateAiTool;
use App\Filament\Admin\Resources\AiTools\Pages\EditAiTool;
use App\Filament\Admin\Resources\AiTools\Pages\ListAiTools;
use App\Filament\Admin\Resources\AiTools\Schemas\AiToolForm;
use App\Filament\Admin\Resources\AiTools\Tables\AiToolsTable;
use App\Models\AiTool;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AiToolResource extends Resource
{
    protected static ?string $model = AiTool::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCpuChip;

    protected static ?string $navigationLabel = 'Herramientas IA';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return AiToolForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AiToolsTable::configure($table);
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
            'index' => ListAiTools::route('/'),
            'create' => CreateAiTool::route('/create'),
            'edit' => EditAiTool::route('/{record}/edit'),
        ];
    }
}