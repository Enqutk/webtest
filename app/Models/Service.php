<?php

namespace App\Models;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\HasUserStamps;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

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
        'created_by',
        'updated_by',
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
            ->singleFile()
            ->useDisk('public');

        $this->addImageCollectionWithThumb('main_image');
        $this->addImageCollectionWithThumb('secondary_image');
    }

    private function addImageCollectionWithThumb(string $collectionName): void
    {
        $this->addMediaCollection($collectionName)
            ->singleFile()
            ->useDisk('public')
            ->registerMediaConversions(function () {
                $this->addMediaConversion('thumb')
                    ->width(150)
                    ->height(150)
                    ->sharpen(10);
            });
    }
}
