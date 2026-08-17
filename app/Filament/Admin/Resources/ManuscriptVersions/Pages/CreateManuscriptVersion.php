<?php

namespace App\Filament\Admin\Resources\ManuscriptVersions\Pages;

use App\Filament\Admin\Resources\ManuscriptVersions\ManuscriptVersionResource;
use App\Services\EditorialIntegrityService;
use Filament\Resources\Pages\CreateRecord;

class CreateManuscriptVersion extends CreateRecord
{
    protected static string $resource = ManuscriptVersionResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['created_by'] = auth()->id();

        return app(EditorialIntegrityService::class)->validateManuscript($data, auth()->user());
    }
}
