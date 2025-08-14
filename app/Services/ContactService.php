<?php

namespace App\Services;

use App\Repositories\ContactRepository;

class ContactService
{
    protected $contactRepository;

    public function __construct(ContactRepository $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    /**
     * Get all contact information for the organization
     *
     * @return array
     */
    public function getContactData(): array
    {
        $organization = $this->contactRepository->getOrganization();
        $contacts = $this->contactRepository->getActiveContacts();
        
        return [
            'email' => $this->getContactsByType($contacts, 'email'),
            'phone' => $this->getContactsByType($contacts, 'phone'),
            'fax' => $this->getContactsByType($contacts, 'fax'),
            'address' => $organization->address ?? null,
            'working_days' => $this->formatWorkingDays($organization),
            'map' => $organization->map_url ?? null
        ];
    }

    /**
     * Get contacts filtered by type
     *
     * @param \Illuminate\Database\Eloquent\Collection $contacts
     * @param string $type
     * @return array
     */
    private function getContactsByType($contacts, string $type): array
    {
        return $contacts->where('type', $type)->pluck('value')->toArray();
    }

    /**
     * Format working days from organization data
     *
     * @param \App\Models\Organization|null $organization
     * @return array
     */
    private function formatWorkingDays($organization): array
    {
        if (!$organization || !$organization->opening_hours) {
            return [];
        }

        $workingDays = [];
        foreach ($organization->opening_hours as $slot) {
            if (isset($slot['days']) && isset($slot['from']) && isset($slot['to'])) {
                $dayNames = array_map('ucfirst', $slot['days']);
                $workingDays[] = [
                    'days' => $dayNames,
                    'from' => $slot['from'],
                    'to' => $slot['to']
                ];
            }
        }

        return $workingDays;
    }
}
