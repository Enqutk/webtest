<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;

class HomeController extends Controller {
    public function index() {
       
        $services = Service::activeOrdered()->get();

       
        $blogPosts = Post::latestActive()->get();

      
        $categories = PostCategory::withCount( 'posts' )->get();
        $recentPosts = Post::latestActive( 5 )->get();

        return view( 'index', compact( 'services', 'blogPosts', 'categories', 'recentPosts' ) );
    }
}
