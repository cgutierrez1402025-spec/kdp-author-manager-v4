<?php

namespace App\Filament\Admin\Resources\Publications\Pages;

use App\Filament\Admin\Resources\Publications\PublicationResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePublication extends CreateRecord
{
    protected static string $resource = PublicationResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $kdpMetadata = $data['kdpMetadata'] ?? [];
        unset($data['kdpMetadata']);

        return $data;
    }

    protected function afterCreate(): void
    {
        $data = $this->form->getRawState();

        if (! empty($data['kdpMetadata'])) {
            $this->record->kdpMetadata()->create($data['kdpMetadata']);
        }
    }
}
