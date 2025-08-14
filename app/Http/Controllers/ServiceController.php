<?php

namespace App\Http\Controllers;

use App\Models\Service;

class ServiceController extends Controller {
    public function show(string $slug) {
        $service = Service::where( 'slug', $slug )->firstOrFail();
        return view( 'services.service-detail', compact( 'service' ) );
    }
}
