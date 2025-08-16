<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Post;

class BlogSection extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public $posts = null)
    {
    }

    public function render(): View|Closure|string
    {
        if (is_null($this->posts)) {
            $this->posts = Post::with(['category', 'creator'])
                ->where('is_active', true)
                ->latest()
                ->take(6)
                ->get();
        }

        return view('components.blog-section');
    }
}
