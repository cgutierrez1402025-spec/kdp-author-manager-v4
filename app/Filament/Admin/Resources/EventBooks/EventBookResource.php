<?php

namespace App\Filament\Admin\Resources\EventBooks;

use App\Filament\Admin\Resources\EventBooks\Pages\CreateEventBook;
use App\Filament\Admin\Resources\EventBooks\Pages\EditEventBook;
use App\Filament\Admin\Resources\EventBooks\Pages\ListEventBooks;
use App\Filament\Admin\Resources\EventBooks\Schemas\EventBookForm;
use App\Filament\Admin\Resources\EventBooks\Tables\EventBooksTable;
use App\Models\EventBook;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class EventBookResource extends Resource
{
    protected static ?string $model = EventBook::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBookOpen;

    protected static ?string $navigationLabel = 'Libros en Eventos';

    protected static ?string $navigationGroup = 'Eventos';

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return EventBookForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EventBooksTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEventBooks::route('/'),
            'create' => CreateEventBook::route('/create'),
            'edit' => EditEventBook::route('/{record}/edit'),
        ];
    }
}