<?php

namespace App\Filament\Admin\Resources\ManuscriptVersions\Pages;

use App\Filament\Admin\Resources\ManuscriptVersions\ManuscriptVersionResource;
use Filament\Resources\Pages\EditRecord;
use App\Services\EditorialIntegrityService;

class EditManuscriptVersion extends EditRecord
{
    protected static string $resource = ManuscriptVersionResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return app(EditorialIntegrityService::class)->validateManuscript($data, auth()->user());
    }
}
