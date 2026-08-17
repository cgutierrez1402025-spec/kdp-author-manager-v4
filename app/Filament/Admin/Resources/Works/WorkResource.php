<?php

namespace App\Filament\Admin\Resources\Works;

use App\Filament\Admin\Resources\Works\Pages\CreateWork;
use App\Filament\Admin\Resources\Works\Pages\EditWork;
use App\Filament\Admin\Resources\Works\Pages\ListWorks;
use App\Filament\Admin\Resources\Works\Schemas\WorkForm;
use App\Filament\Admin\Resources\Works\Tables\WorksTable;
use App\Models\Work;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class WorkResource extends Resource
{
    protected static ?string $slug = 'works';

    protected static ?string $model = Work::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $recordTitleAttribute = 'title_public';

    protected static ?string $navigationLabel = 'Obras';

    protected static ?string $navigationGroup = 'Catálogo editorial';

    public static function form(Form $form): Form
    {
        return WorkForm::configure($form);
    }

    public static function table(Table $table): Table
    {
        return WorksTable::configure($table);
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        return auth()->user()?->canViewAllAuthorData()
            ? $query
            : $query->where('user_id', auth()->id());
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
            'index' => ListWorks::route('/'),
            'create' => CreateWork::route('/create'),
            'edit' => EditWork::route('/{record}/edit'),
        ];
    }
}
