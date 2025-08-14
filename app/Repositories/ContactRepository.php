<?php

namespace App\Repositories;

use App\Models\Organization;
use App\Models\OrganizationContact;
use App\Enums\StatusEnum;

class ContactRepository
{
    /**
     * Get the organization information
     *
     * @return Organization|null
     */
    public function getOrganization(): ?Organization
    {
        return Organization::first();
    }

    /**
     * Get all active contacts
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getActiveContacts()
    {
        return OrganizationContact::where('status', StatusEnum::active)->get();
    }

    /**
     * Get contacts by type
     *
     * @param string $type
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getContactsByType(string $type)
    {
        return OrganizationContact::where('type', $type)
            ->where('status', StatusEnum::active)
            ->get();
    }
}
