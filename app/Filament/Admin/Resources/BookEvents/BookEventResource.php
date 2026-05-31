<?php

namespace App\Filament\Admin\Resources\BookEvents;

use App\Filament\Admin\Resources\BookEvents\Pages\CreateBookEvent;
use App\Filament\Admin\Resources\BookEvents\Pages\EditBookEvent;
use App\Filament\Admin\Resources\BookEvents\Pages\ListBookEvents;
use App\Filament\Admin\Resources\BookEvents\Schemas\BookEventForm;
use App\Filament\Admin\Resources\BookEvents\Tables\BookEventsTable;
use App\Models\BookEvent;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BookEventResource extends Resource
{
    protected static ?string $model = BookEvent::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    protected static ?string $navigationLabel = 'Eventos';

    protected static ?string $navigationGroup = 'Eventos';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return BookEventForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BookEventsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBookEvents::route('/'),
            'create' => CreateBookEvent::route('/create'),
            'edit' => EditBookEvent::route('/{record}/edit'),
        ];
    }
}