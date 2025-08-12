<?php

namespace App\MediaLibrary;

use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ModelNamePathGenerator extends PathGenerator
{
    public function getPath(Media $media): string
    {
        $modelName = strtolower(class_basename($media->model_type));
        return "images/{$modelName}/";
    }

    public function getPathForConversions(Media $media): string
    {
        $modelName = strtolower(class_basename($media->model_type));
        return "images/{$modelName}/conversions/";
    }
}
