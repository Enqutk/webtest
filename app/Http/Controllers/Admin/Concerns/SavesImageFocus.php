<?php

namespace App\Http\Controllers\Admin\Concerns;

use App\Support\ImageFocus;
use Illuminate\Http\Request;

trait SavesImageFocus
{
    /** @return array<string, int> */
    protected function imageFocusFromRequest(Request $request, string $prefix = ''): array
    {
        return ImageFocus::fromRequest($request, $prefix);
    }
}
