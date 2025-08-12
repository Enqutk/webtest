<?php

namespace App\MediaLibrary;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;

class ModulePathGenerator implements PathGenerator
{
    /**
     * Get the path for the given media, relative to the root storage path.
     */
    public function getPath(Media $media): string
    {
        $modelName = strtolower(class_basename($media->model_type));
        
        return $this->getModulePath($modelName);
    }

    /**
     * Get the path for conversions of the given media, relative to the root storage path.
     */
    public function getPathForConversions(Media $media): string
    {
        $modelName = strtolower(class_basename($media->model_type));
        
        return $this->getModulePath($modelName) . 'conversions/';
    }

    /**
     * Get the path for responsive images of the given media, relative to the root storage path.
     */
    public function getPathForResponsiveImages(Media $media): string
    {
        $modelName = strtolower(class_basename($media->model_type));
        
        return $this->getModulePath($modelName) . 'responsive-images/';
    }

    /**
     * Get the module-specific path
     */
    private function getModulePath(string $modelName): string
    {
        return match ($modelName) {
            'hero' => 'heros/',
            'service' => 'services/',
            'team' => 'teams/',
            'post' => 'posts/',
            'entity' => 'entities/',
            default => "images/{$modelName}/",
        };
    }
}
