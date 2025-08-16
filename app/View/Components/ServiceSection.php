<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Service;
use App\Enums\StatusEnum;

class ServiceSection extends Component
{
    public $services;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->services = Service::where('status', StatusEnum::active)->orderBy('order')->take(5)->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.service-section');
    }
}


