<?php

namespace App\Filament\Resources\OrganizationResource\Pages;

use App\Filament\Resources\OrganizationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOrganization extends EditRecord
{
    public function mount($record = null): void
    {
        if ($record === null) {
            $record = \App\Models\Organization::first()?->getKey();
        }
        parent::mount($record);
    }
    protected static string $resource = OrganizationResource::class;


    protected function getHeaderActions(): array
    {
        return [
        ];
    }

    protected function getRedirectUrl(): string
    {
        // Always redirect to the singleton edit page
        return static::$resource::getUrl('index');
    }
}
