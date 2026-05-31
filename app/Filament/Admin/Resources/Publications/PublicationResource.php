<?php

namespace App\Filament\Admin\Resources\Publications;

use App\Filament\Admin\Resources\Publications\Pages\CreatePublication;
use App\Filament\Admin\Resources\Publications\Pages\EditPublication;
use App\Filament\Admin\Resources\Publications\Pages\ListPublications;
use App\Filament\Admin\Resources\Publications\Schemas\PublicationForm;
use App\Filament\Admin\Resources\Publications\Tables\PublicationsTable;
use App\Models\Publication;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;

class PublicationResource extends Resource
{
    protected static ?string $model = Publication::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $recordTitleAttribute = 'format';

    protected static ?string $navigationGroup = 'Publicaciones';

    public static function form(Form $form): Form
    {
        return PublicationForm::configure($form);
    }

    public static function table(Table $table): Table
    {
        return PublicationsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\KdpMetadataRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPublications::route('/'),
            'create' => CreatePublication::route('/create'),
            'edit' => EditPublication::route('/{record}/edit'),
        ];
    }
}
