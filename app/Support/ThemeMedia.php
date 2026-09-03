<?php

namespace App\Support;

class ThemeMedia
{
    public static function toUploadState(mixed $value): array|string|null
    {
        if (blank($value)) {
            return [];
        }

        if (is_array($value)) {
            return $value;
        }

        $clean = ltrim(str_replace(['/storage/', 'storage/'], '', (string) $value), '/');

        return [$clean => $clean];
    }

    public static function fromUploadState(mixed $value): ?string
    {
        if (is_array($value)) {
            $value = array_values($value)[0] ?? null;
        }

        return filled($value) ? (string) $value : null;
    }
}
