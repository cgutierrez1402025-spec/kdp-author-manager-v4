<?php

namespace App\Filament\Admin\Resources\EventBooks\Schemas;

use Filament\Forms;
use Filament\Forms\Form;

class EventBookForm
{
    public static function configure(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Evento y Libro')
                    ->schema([
                        Forms\Components\Select::make('event_id')
                            ->relationship('bookEvent', 'title')
                            ->label('Evento')
                            ->required(),

                        Forms\Components\Select::make('work_id')
                            ->relationship('work', 'title_public')
                            ->label('Obra')
                            ->required(),

                        Forms\Components\Select::make('edition_id')
                            ->relationship('edition', 'edition_name')
                            ->label('Edición'),

                        Forms\Components\Select::make('work_language_id')
                            ->relationship('workLanguage', 'language_code')
                            ->label('Idioma'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Inventario y Ventas')
                    ->schema([
                        Forms\Components\TextInput::make('copies_brought')
                            ->label('Copias Llevadas')
                            ->numeric()
                            ->default(0),

                        Forms\Components\TextInput::make('copies_sold')
                            ->label('Copias Vendidas')
                            ->numeric()
                            ->default(0),

                        Forms\Components\TextInput::make('copies_gifted')
                            ->label('Copias Regaladas')
                            ->numeric()
                            ->default(0),

                        Forms\Components\TextInput::make('copies_returned')
                            ->label('Copias Devueltas')
                            ->numeric()
                            ->default(0),

                        Forms\Components\TextInput::make('unit_sale_price')
                            ->label('Precio Venta')
                            ->numeric()
                            ->step('0.01')
                            ->default(0),

                        Forms\Components\TextInput::make('income_amount')
                            ->label('Ingresos')
                            ->numeric()
                            ->step('0.01')
                            ->readOnly(),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('Notas')
                    ->schema([
                        Forms\Components\Textarea::make('notes')
                            ->label('Notas')
                            ->rows(3),
                    ]),
            ]);
    }
}
