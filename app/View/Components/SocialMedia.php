<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\SocialRef;
use App\Models\Organization;
use App\Enums\StatusEnum;

class SocialMedia extends Component
{
    public $socialRefs;

    public function __construct()
    {
        $org = Organization::resolvePublicCurrent();
        $theme = $org ? $org->resolvedTheme() : Organization::defaultTheme();

        if (! ($theme['show_social_links'] ?? true) || ! $org) {
            $this->socialRefs = collect();
            return;
        }

        $this->socialRefs = SocialRef::where('organization_id', $org->id)
            ->where('status', StatusEnum::active)
            ->whereNotNull('link')
            ->where('link', '!=', '')
            ->whereNotNull('icon_class')
            ->where('icon_class', '!=', '')
            ->orderBy('order')
            ->get()
            ->unique(fn ($item) => strtolower(trim($item->link)));
    }

    public function render(): View|Closure|string
    {
        return view('components.social-media');
    }
}
