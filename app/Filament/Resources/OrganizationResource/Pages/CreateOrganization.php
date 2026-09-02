<?php

namespace App\Filament\Resources\OrganizationResource\Pages;

use App\Filament\Resources\OrganizationResource;
use App\Models\Organization;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateOrganization extends CreateRecord
{
    protected static string $resource = OrganizationResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (empty($data['theme'])) {
            $data['theme'] = Organization::defaultTheme();
        }

        return $data;
    }

    protected function afterCreate(): void
    {
        $organization = $this->getRecord();
        $user = Auth::user();

        if ($organization && $user) {
            $organization->users()->syncWithoutDetaching([
                $user->id => ['role' => 'owner'],
            ]);
        }
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('edit', ['record' => $this->getRecord()]);
    }
}
