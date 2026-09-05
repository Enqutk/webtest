<?php

namespace App\Models;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\BelongsToOrganization;
use App\Traits\HasUserStamps;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Hero extends Model implements HasMedia
{
    use SoftDeletes, HasUserStamps, InteractsWithMedia, BelongsToOrganization;

    protected $table = 'heroes';

    protected $fillable = [
        'organization_id',
        'title',
        'subtitle',
        'description',
        'button_link',
        'text_link',
        'order',
        'status',
        'created_by',
        'updated_by',
        'image_focus_x',
        'image_focus_y',
    ];

    protected $casts = [
        'status'      => StatusEnum::class,
        'order'       => 'integer',
        'image_focus_x' => 'integer',
        'image_focus_y' => 'integer',
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
        $this->addMediaCollection('image')
            ->singleFile()

            ->registerMediaConversions(function () {
                $this->addMediaConversion('thumb')
                    ->width(150)
                    ->height(150)
                    ->sharpen(10);
            });
    }

    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->getFirstMediaUrl('image'),
        );
    }
}
