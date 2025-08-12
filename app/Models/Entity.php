<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\Enums\EntityTypeEnum;
use App\Enums\StatusEnum;
use App\Traits\HasUserStamps;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Entity extends Model implements HasMedia 
{
    use SoftDeletes, HasUserStamps, InteractsWithMedia;

    protected $fillable = [
        'name',
        'type',
        'link',
        'description',
        'order',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'order' => 'integer',
        'type' => EntityTypeEnum::class,
        'status' => StatusEnum::class,
    ];

    // Relationships

    public function creator():BelongsTo {
        return $this->belongsTo( User::class, 'created_by' );
    }

    public function updater(): BelongsTo {
        return $this->belongsTo( User::class, 'updated_by' );
    }

    public function registerMediaCollections(): void {
        $this->addMediaCollection('images')
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