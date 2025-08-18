<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Enums\StatusEnum;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $services = Service::where('status', StatusEnum::active)
            ->orderBy('order')
            ->take(6)
            ->get();

        return view('index', compact('services'));
    }

    public function postIndex()
    {
        $blogPosts = Post::with(['category', 'creator'])
            ->where('is_active', true)
            ->latest()
            ->take(6)
            ->get();

        return view('blog.index', compact('blogPosts'));
    }

    public function postShow($slug)
    {
        $post = Post::with(['category', 'creator'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();
        $recentPosts = Post::where('is_active', true)
            ->where('id', '!=', $post->id)
            ->latest()
            ->take(5)
            ->get();
        $categories = PostCategory::all();
        $gallery = $post->getMedia('gallery');

        return view('blog.show', compact('post', 'gallery', 'categories', 'recentPosts'));
    }
    public function postsByCategory($slug)
    {
        // Get category by slug
        $category = PostCategory::where('slug', $slug)->firstOrFail();


        $posts = Post::with('creator')
            ->where('category_id', $category->id)
            ->where('is_active', true)
            ->latest()
            ->get();

        $categories = PostCategory::withCount('posts')->get();

        $recentPosts = Post::where('is_active', true)->latest()->take(5)->get();

        return view('blog.category', compact('category', 'posts', 'categories', 'recentPosts'));
    }
}
