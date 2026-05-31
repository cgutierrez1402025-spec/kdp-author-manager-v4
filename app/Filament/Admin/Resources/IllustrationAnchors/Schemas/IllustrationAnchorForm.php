<?php

namespace App\Filament\Admin\Resources\IllustrationAnchors\Schemas;

use Filament\Forms;
use Filament\Forms\Form;

class IllustrationAnchorForm
{
    public static function configure(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información del Anclaje')
                    ->schema([
                        Forms\Components\Select::make('illustration_id')
                            ->relationship('illustration', 'title')
                            ->label('Ilustración')
                            ->required(),

                        Forms\Components\Select::make('manuscript_version_id')
                            ->relationship('manuscriptVersion', 'name')
                            ->label('Versión Manuscrito')
                            ->required(),

                        Forms\Components\Select::make('chapter_id')
                            ->relationship('chapter', 'title')
                            ->label('Capítulo')
                            ->nullable(),

                        Forms\Components\Select::make('anchor_type')
                            ->label('Tipo de Anclaje')
                            ->options([
                                'inline' => 'En línea',
                                'block' => 'Bloque',
                                'chapter_start' => 'Inicio de Capítulo',
                                'chapter_end' => 'Final de Capítulo',
                            ])
                            ->required(),

                        Forms\Components\Select::make('position_type')
                            ->label('Tipo de Posición')
                            ->options([
                                'before' => 'Antes',
                                'after' => 'Después',
                                'replace' => 'Reemplazar',
                                'wrap' => 'Envolver',
                            ])
                            ->nullable(),

                        Forms\Components\Select::make('insertion_mode')
                            ->label('Modo de Inserción')
                            ->options([
                                'inline' => 'En línea',
                                'block' => 'Bloque',
                                'float_left' => 'Flotar Izquierda',
                                'float_right' => 'Flotar Derecha',
                            ])
                            ->nullable(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Ubicación')
                    ->schema([
                        Forms\Components\Textarea::make('search_text')
                            ->label('Texto de Búsqueda')
                            ->rows(2)
                            ->placeholder('Texto donde insertar la ilustración...')
                            ->columnSpan(2),

                        Forms\Components\Textarea::make('search_text_before')
                            ->label('Texto Antes')
                            ->rows(2),

                        Forms\Components\Textarea::make('search_text_after')
                            ->label('Texto Después')
                            ->rows(2),

                        Forms\Components\TextInput::make('css_selector')
                            ->label('Selector CSS')
                            ->placeholder('Ej: .chapter-content p:nth-child(3)'),

                        Forms\Components\TextInput::make('html_marker')
                            ->label('Marcador HTML')
                            ->placeholder('<!-- illustration-here -->'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Metadatos')
                    ->schema([
                        Forms\Components\TextInput::make('confidence')
                            ->label('Confianza')
                            ->placeholder('Ej: 0.95'),

                        Forms\Components\Select::make('status')
                            ->label('Estado')
                            ->options([
                                'pending' => 'Pendiente',
                                'applied' => 'Aplicado',
                                'rejected' => 'Rechazado',
                            ])
                            ->default('pending')
                            ->required(),

                        Forms\Components\Textarea::make('notes')
                            ->label('Notas')
                            ->rows(2)
                            ->columnSpan(2),
                    ])
                    ->columns(2),
            ]);
    }
}
