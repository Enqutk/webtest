<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Enums\StatusEnum;

class HomeController extends Controller {
    public function index() {
        $services = Service::where( 'status', StatusEnum::active )
        ->orderBy( 'order' )
        ->take( 6 )
        ->get();

        return view( 'index', compact( 'services' ) );
    }
}
