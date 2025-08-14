<?php

namespace App\Models;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\HasUserStamps;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Cache;

class Service extends Model implements HasMedia
{
    use SoftDeletes, HasUserStamps, InteractsWithMedia;

    protected $table = 'services';

    protected $fillable = [
        'slug',
        'title',
        'short_description',
        'quote',
        'description',
        'features',
        'order',
        'status',
    ];

    protected $casts = [
        'order' => 'integer',
        'status' => StatusEnum::class,
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('svg')
            ->singleFile();

        $this->addImageCollectionWithThumb('main_image');
        $this->addImageCollectionWithThumb('secondary_image');
    }

    private function addImageCollectionWithThumb(string $collectionName): void
    {
        $this->addMediaCollection($collectionName)
            ->singleFile()

            ->registerMediaConversions(function () {
                $this->addMediaConversion('thumb')
                    ->width(150)
                    ->height(150)
                    ->sharpen(10);
            });
    }

    protected function secondaryImageUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->getFirstMediaUrl('secondary_image'),
        );
    }
    protected function mainImageUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->getFirstMediaUrl('main_image'),
        );
    }
    protected function svgInline(): Attribute
    {
        return Attribute::make(
                        get: function () {
                return Cache::rememberForever("service.{$this->id}.svg", function () {
                    if ($media = $this->getFirstMedia('svg')) {
                        $path = $media->getPath();
                        if (file_exists($path)) {
                            return file_get_contents($path);
                        }
                    }
                    return '';
                });
            }
        );
    }
    
}
