<?php

namespace App\Filament\Admin\Resources\AiTasks;

use App\Filament\Concerns\ScopesAuthorOwnedRecords;
use App\Models\AiTask;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AiTaskResource extends Resource
{
    use ScopesAuthorOwnedRecords;

    protected static string $authorOwnershipPath = 'work';

    protected static ?string $slug = 'ai-tasks';

    protected static ?string $model = AiTask::class;

    protected static ?string $navigationIcon = 'heroicon-o-queue-list';

    protected static ?string $navigationLabel = 'Tareas IA';

    protected static ?string $pluralLabel = 'Tareas IA';

    protected static ?string $recordTitleAttribute = 'task_type';

    protected static ?string $navigationGroup = 'Inteligencia artificial';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('task_type')
                    ->label('Tipo de tarea')
                    ->required()
                    ->maxLength(255),

                Select::make('status')
                    ->label('Estado')
                    ->options([
                        'pending' => 'Pendiente',
                        'processing' => 'Procesando',
                        'completed' => 'Completada',
                        'failed' => 'Fallida',
                    ])
                    ->default('pending')
                    ->required(),

                Textarea::make('description')
                    ->label('Descripción')
                    ->maxLength(65535)
                    ->columnSpanFull(),

                Textarea::make('result')
                    ->label('Resultado')
                    ->maxLength(65535)
                    ->columnSpanFull(),

                TextInput::make('user_id')
                    ->label('Usuario ID')
                    ->numeric()
                    ->hidden(fn () => ! auth()->user()->is_admin ?? false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('task_type')
                    ->label('Tipo de tarea')
                    ->searchable()
                    ->sortable(),

                BadgeColumn::make('status')
                    ->label('Estado')
                    ->colors([
                        'warning' => 'pending',
                        'info' => 'processing',
                        'success' => 'completed',
                        'danger' => 'failed',
                    ])
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('updated_at')
                    ->label('Actualizado')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAiTasks::route('/'),
            'create' => Pages\CreateAiTask::route('/create'),
            'edit' => Pages\EditAiTask::route('/{record}/edit'),
        ];
    }
}
