<?php
namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\SocialRef;

class SocialMedia extends Component {
    public $socialRefs;

    public function __construct() {
        $this->socialRefs = SocialRef::where('status', \App\Enums\StatusEnum::active)
            ->orderBy('order')
            ->get();
    }

    public function render(): View|Closure|string {
        // don't pass manually, Laravel auto-binds public properties
        return view('components.social-media');
    }
}
