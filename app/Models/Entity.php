<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\Enums\EntityTypeEnum;
use App\Enums\StatusEnum;
use App\Traits\BelongsToOrganization;
use App\Traits\HasUserStamps;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Entity extends Model implements HasMedia 
{
    use SoftDeletes, HasUserStamps, InteractsWithMedia, BelongsToOrganization;

    protected $fillable = [
        'organization_id',
        'name',
        'type',
        'category',
        'link',
        'description',
        'order',
        'status',
        'created_by',
        'updated_by',
        'image_focus_x',
        'image_focus_y',
    ];

    protected $appends = [
        'image_url',
    ];

    protected $casts = [
        'order' => 'integer',
        'type' => EntityTypeEnum::class,
        'status' => StatusEnum::class,
        'image_focus_x' => 'integer',
        'image_focus_y' => 'integer',
    ];

    // Relationships

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
        $this->addMediaCollection('image')
            ->singleFile()

            ->registerMediaConversions(function () {
                $this->addMediaConversion('thumb')
                    ->width(150)
                    ->height(150)
                    ->sharpen(10);
            });
    }

    public function getImageUrlAttribute(): ?string
    {
        $url = $this->getFirstMediaUrl('image');

        return $url !== '' ? $url : null;
    }
}
