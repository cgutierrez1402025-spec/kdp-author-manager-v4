<?php

namespace App\Filament\Admin\Resources\PromotionDailyResults;

use App\Filament\Admin\Resources\PromotionDailyResults\Pages\CreatePromotionDailyResult;
use App\Filament\Admin\Resources\PromotionDailyResults\Pages\EditPromotionDailyResult;
use App\Filament\Admin\Resources\PromotionDailyResults\Pages\ListPromotionDailyResults;
use App\Filament\Admin\Resources\PromotionDailyResults\Schemas\PromotionDailyResultForm;
use App\Filament\Admin\Resources\PromotionDailyResults\Tables\PromotionDailyResultsTable;
use App\Models\PromotionDailyResult;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PromotionDailyResultResource extends Resource
{
    protected static ?string $model = PromotionDailyResult::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChartBar;

    protected static ?string $navigationLabel = 'Resultados Diarios';

    protected static ?string $navigationGroup = 'Publicaciones';

    protected static ?string $recordTitleAttribute = 'date';

    public static function form(Schema $schema): Schema
    {
        return PromotionDailyResultForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PromotionDailyResultsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPromotionDailyResults::route('/'),
            'create' => CreatePromotionDailyResult::route('/create'),
            'edit' => EditPromotionDailyResult::route('/{record}/edit'),
        ];
    }
}