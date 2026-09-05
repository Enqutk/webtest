<?php

namespace App\Http\Controllers;

use App\Enums\StatusEnum;
use App\Models\Organization;
use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        $currentOrg = Organization::resolvePublicCurrent();

        $services = Service::where('organization_id', $currentOrg->id)
            ->where('status', StatusEnum::active)
            ->orderBy('order')
            ->get();

        return view('services.index', compact('services', 'currentOrg'));
    }

    public function show(string $slug, ?string $service_slug = null)
    {
        $currentOrg = Organization::resolvePublicCurrent();
        $lookup = $service_slug ?: $slug;

        $service = Service::where('organization_id', $currentOrg->id)
            ->where('slug', $lookup)
            ->where('status', StatusEnum::active)
            ->firstOrFail();

        $allServices = Service::where('organization_id', $currentOrg->id)
            ->where('status', StatusEnum::active)
            ->orderBy('order')
            ->get();

        return view('services.show', compact('service', 'allServices', 'currentOrg'));
    }
}
