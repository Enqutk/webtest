<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Enums\StatusEnum;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
   
    public function index()
    {
        $services = Service::where('status', StatusEnum::active)
            ->orderBy('order')
            ->get();

        return view('services.index', compact('services'));
    }

    /**
     * Display the specified service.
     */

    public function show(string $slug)
    {
        $service = Service::where('slug', $slug)
            ->where('status', StatusEnum::active)
            ->firstOrFail();

        // Use the activeOrdered scope for related services:
        $relatedServices = Service::activeOrdered(5)
            ->where('id', '!=', $service->id)
            ->get();

        return view('services.show', compact('service', 'relatedServices'));
    }
}
