<?php

namespace App\Http\Controllers\Admin\Concerns;

use App\Enums\StatusEnum;
use App\Models\Organization;
use App\Models\OrganizationContact;

trait SyncsOrganizationContacts
{
    protected function syncContacts(Organization $org, string $type, array $values): void
    {
        OrganizationContact::query()
            ->where('organization_id', $org->id)
            ->where('type', $type)
            ->delete();

        foreach ($values as $value) {
            $value = trim((string) $value);
            if ($value === '') {
                continue;
            }

            OrganizationContact::create([
                'organization_id' => $org->id,
                'type' => $type,
                'value' => $value,
                'status' => StatusEnum::active,
            ]);
        }
    }
}
