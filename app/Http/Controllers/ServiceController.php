<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Enums\StatusEnum;
use Illuminate\Http\Request;

class ServiceController extends Controller {
    /**
    * Display a listing of the services.
    */

    public function index() {
        $services = Service::where( 'status', StatusEnum::active )
        ->orderBy( 'order' )
        ->get();

        return view( 'services.index', compact( 'services' ) );
    }

    /**
    * Display the specified service.
    */

    public function show( string $slug ) {
        $service = Service::where( 'slug', $slug )
        ->where( 'status', StatusEnum::active )
        ->firstOrFail();

        $allServices = Service::where( 'status', StatusEnum::active )
        ->orderBy( 'order' )
        ->get();

        $service->features_list = $service->features ? explode( '\n', $service->features ) : [];

        return view( 'services.show', compact( 'service', 'allServices' ) );
    }
}
