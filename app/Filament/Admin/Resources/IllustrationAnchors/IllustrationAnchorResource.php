<?php

namespace App\Filament\Admin\Resources\IllustrationAnchors;

use App\Filament\Admin\Resources\IllustrationAnchors\Pages\CreateIllustrationAnchor;
use App\Filament\Admin\Resources\IllustrationAnchors\Pages\EditIllustrationAnchor;
use App\Filament\Admin\Resources\IllustrationAnchors\Pages\ListIllustrationAnchors;
use App\Filament\Admin\Resources\IllustrationAnchors\Schemas\IllustrationAnchorForm;
use App\Filament\Admin\Resources\IllustrationAnchors\Tables\IllustrationAnchorsTable;
use App\Models\IllustrationAnchor;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class IllustrationAnchorResource extends Resource
{
    protected static ?string $model = IllustrationAnchor::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;

    protected static ?string $navigationLabel = 'Anclajes de Ilustraciones';

    protected static ?string $navigationGroup = 'Ilustraciones';

    protected static ?string $recordTitleAttribute = 'anchor_type';

    public static function form(Schema $schema): Schema
    {
        return IllustrationAnchorForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return IllustrationAnchorsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListIllustrationAnchors::route('/'),
            'create' => CreateIllustrationAnchor::route('/create'),
            'edit' => EditIllustrationAnchor::route('/{record}/edit'),
        ];
    }
}