<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Enums\StatusEnum;
use App\Models\Post;

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

    public function PostIndex()
    {
        $blogPosts = Post::with(['category', 'creator'])
            ->where('is_active', true)
            ->latest()
            ->take(6)
            ->get();

        return view('blog.index', compact('blogPosts'));
    }

    public function PostShow($slug)
    {
        $post = Post::with(['category', 'creator'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $gallery = $post->getMedia('gallery');

        return view('blog.show', compact('post', 'gallery'));
    }
}
