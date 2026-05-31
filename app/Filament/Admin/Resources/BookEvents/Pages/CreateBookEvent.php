<?php

namespace App\Filament\Admin\Resources\BookEvents\Pages;

use App\Filament\Admin\Resources\BookEvents\BookEventResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBookEvent extends CreateRecord
{
    protected static string $resource = BookEventResource::class;
}