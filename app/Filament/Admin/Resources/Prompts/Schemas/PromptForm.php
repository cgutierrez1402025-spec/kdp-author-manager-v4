<?php

namespace App\Filament\Admin\Resources\Prompts\Schemas;

use Filament\Forms\Components\Rating;
use Filament\Forms;
use Filament\Schemas\Schema;

class PromptForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\Section::make('Información del Prompt')
                    ->schema([
                        Forms\Components\Select::make('work_id')
                            ->relationship('work', 'title_public')
                            ->label('Obra')
                            ->required(),

                        Forms\Components\Select::make('ai_tool_id')
                            ->relationship('aiTool', 'name')
                            ->label('Herramienta IA')
                            ->required(),

                        Forms\Components\Select::make('task_id')
                            ->relationship('task', 'task_type')
                            ->label('Tarea IA')
                            ->nullable(),

                        Forms\Components\TextInput::make('title')
                            ->label('Título')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Select::make('language_code')
                            ->label('Idioma')
                            ->options([
                                'es' => 'Español',
                                'en' => 'Inglés',
                            ])
                            ->default('es'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Contenido')
                    ->schema([
                        Forms\Components\Textarea::make('prompt_text')
                            ->label('Prompt')
                            ->required()
                            ->rows(6),

                        Forms\Components\Textarea::make('result_text')
                            ->label('Resultado')
                            ->rows(6)
                            ->columnSpan(2),
                    ]),

                Forms\Components\Section::make('Metadatos')
                    ->schema([
                        Forms\Components\TextInput::make('purpose')
                            ->label('Propósito')
                            ->maxLength(255),

                        Forms\Components\Textarea::make('result_summary')
                            ->label('Resumen')
                            ->rows(2),

                        Forms\Components\Toggle::make('reused')
                            ->label('Reutilizado'),

                        Forms\Components\Toggle::make('generated_final_content')
                            ->label('Contenido Final'),

                        Forms\Components\Rating::make('rating')
                            ->label('Rating')
                            ->minValue(1)
                            ->maxValue(5),
                    ])
                    ->columns(2),
            ]);
    }
}