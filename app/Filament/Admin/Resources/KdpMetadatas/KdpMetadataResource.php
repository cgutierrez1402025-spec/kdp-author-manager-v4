<?php

namespace App\Filament\Admin\Resources\KdpMetadatas;

use App\Filament\Admin\Resources\KdpMetadatas\Pages\CreateKdpMetadata;
use App\Filament\Admin\Resources\KdpMetadatas\Pages\EditKdpMetadata;
use App\Filament\Admin\Resources\KdpMetadatas\Pages\ListKdpMetadatas;
use App\Filament\Admin\Resources\KdpMetadatas\Schemas\KdpMetadataForm;
use App\Filament\Admin\Resources\KdpMetadatas\Tables\KdpMetadatasTable;
use App\Models\KdpMetadata;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class KdpMetadataResource extends Resource
{
    protected static ?string $model = KdpMetadata::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTag;

    protected static ?string $navigationLabel = 'Metadatos KDP';

    protected static ?string $navigationGroup = 'Publicaciones';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return KdpMetadataForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KdpMetadatasTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListKdpMetadatas::route('/'),
            'create' => CreateKdpMetadata::route('/create'),
            'edit' => EditKdpMetadata::route('/{record}/edit'),
        ];
    }
}