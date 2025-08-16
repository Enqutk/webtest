<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Post;

class BlogSection extends Component
{
    public $posts;

    /**
     * Create a new component instance.
     */

    public function __construct()
    {
        $this->posts = Post::with(['category', 'creator'])
            ->where('is_active', true)
            ->latest()
            ->take(6)
            ->get();
    }

    /**
     * Get the view / contents that represent the component.
     */

    public function render(): View|Closure|string
    {
        return view('components.blog-section');
    }
}
