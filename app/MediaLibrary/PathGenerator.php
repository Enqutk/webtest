<?php

namespace App\MediaLibrary;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator as BasePathGenerator;

class ModelNamePathGenerator extends BasePathGenerator
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
