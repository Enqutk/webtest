<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UploadedImage
{
    public static function storeOptimized(
        UploadedFile $file,
        string $directory = 'page-images',
        int $maxWidth = 1920,
        int $quality = 82
    ): string {
        if (! extension_loaded('gd')) {
            return $file->store($directory, 'public');
        }

        $image = self::loadImage($file->getRealPath(), $file->getMimeType() ?? '');
        if (! $image) {
            return $file->store($directory, 'public');
        }

        $width = imagesx($image);
        $height = imagesy($image);

        if ($width > $maxWidth) {
            $newHeight = (int) round($height * ($maxWidth / $width));
            $resized = imagecreatetruecolor($maxWidth, $newHeight);
            imagecopyresampled($resized, $image, 0, 0, 0, 0, $maxWidth, $newHeight, $width, $height);
            imagedestroy($image);
            $image = $resized;
        }

        $filename = trim($directory, '/') . '/' . Str::uuid() . '.jpg';
        Storage::disk('public')->makeDirectory(trim($directory, '/'));
        $fullPath = Storage::disk('public')->path($filename);
        imagejpeg($image, $fullPath, $quality);
        imagedestroy($image);

        return $filename;
    }

    /** @return \GdImage|resource|null */
    private static function loadImage(string $path, string $mime)
    {
        return match ($mime) {
            'image/jpeg', 'image/jpg' => @imagecreatefromjpeg($path) ?: null,
            'image/png' => @imagecreatefrompng($path) ?: null,
            'image/webp' => function_exists('imagecreatefromwebp') ? (@imagecreatefromwebp($path) ?: null) : null,
            'image/gif' => @imagecreatefromgif($path) ?: null,
            default => null,
        };
    }
}
