<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;

class HomeController extends Controller {
    public function index() {
       
        $services = Service::activeOrdered()->get();      
  
        return view( 'index', compact( 'services' ) );
    }
}
