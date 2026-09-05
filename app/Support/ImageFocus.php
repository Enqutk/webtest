<?php

namespace App\Support;

use Illuminate\Http\Request;

class ImageFocus
{
    public static function clamp(mixed $x = null, mixed $y = null): array
    {
        return [
            'x' => max(0, min(100, (int) ($x ?? 50))),
            'y' => max(0, min(100, (int) ($y ?? 50))),
        ];
    }

    public static function position(mixed $x = null, mixed $y = null): string
    {
        $focus = self::clamp($x, $y);

        return "{$focus['x']}% {$focus['y']}%";
    }

    public static function style(mixed $x = null, mixed $y = null, ?string $extra = null): string
    {
        $parts = ['object-position: ' . self::position($x, $y)];

        if (filled($extra)) {
            $parts[] = trim($extra, '; ');
        }

        return implode('; ', $parts);
    }

    /** @return array<string, int> */
    public static function fromRequest(Request $request, string $prefix = ''): array
    {
        $xKey = $prefix === '' ? 'image_focus_x' : "{$prefix}_image_focus_x";
        $yKey = $prefix === '' ? 'image_focus_y' : "{$prefix}_image_focus_y";
        $focus = self::clamp($request->input($xKey, 50), $request->input($yKey, 50));

        if ($prefix === 'secondary') {
            return [
                'secondary_image_focus_x' => $focus['x'],
                'secondary_image_focus_y' => $focus['y'],
            ];
        }

        if ($prefix === '') {
            return [
                'image_focus_x' => $focus['x'],
                'image_focus_y' => $focus['y'],
            ];
        }

        return [
            "{$prefix}_image_focus_x" => $focus['x'],
            "{$prefix}_image_focus_y" => $focus['y'],
        ];
    }

    public static function previewUrl(mixed $path): string
    {
        if (blank($path)) {
            return '';
        }

        if (is_array($path)) {
            $path = array_values($path)[0] ?? null;
        }

        $path = (string) $path;

        if ($path === '') {
            return '';
        }

        if (str_starts_with($path, 'http')) {
            return $path;
        }

        return asset('storage/' . ltrim(str_replace(['/storage/', 'storage/'], '', $path), '/'));
    }
}
