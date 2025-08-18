<?php

namespace App\Models;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\HasUserStamps;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Builder;

class Post extends Model implements HasMedia
{
    use SoftDeletes, HasUserStamps, InteractsWithMedia;

    protected $table = 'posts';

    protected $fillable = [
        'title',
        'category_id',
        'short_description',
        'content',
        'tags',
        'slug',
        'is_active',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(PostCategory::class, 'category_id');
    }

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
        $this->addMediaCollection('main_image')
            ->singleFile()
            ->registerMediaConversions(function () {
                $this->addMediaConversion('thumb')
                    ->width(300)
                    ->height(200)
                    ->sharpen(10);

                $this->addMediaConversion('medium')
                    ->width(600)
                    ->height(400)
                    ->sharpen(10);
            });

        $this->addMediaCollection('gallery')
            ->registerMediaConversions(function () {
                $this->addMediaConversion('thumb')
                    ->width(150)
                    ->height(150)
                    ->sharpen(10);
            });
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
        });

        static::updating(function ($post) {
            if ($post->isDirty('title')) {
                $post->slug = Str::slug($post->title);
            }
        });
    }

    protected function mainImageUrl(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->getFirstMediaUrl('main_image'),
        );
    }

    public function getExcerptAttribute(): string
    {
        $content = $this->short_description ?? strip_tags($this->content);
        return \Illuminate\Support\Str::limit($content, 100);
    }

    public function scopeLatestActive(Builder $query, int $limit = 6)
    {
        return $query->with(['category', 'creator'])
            ->where('is_active', true)
            ->latest()
            ->take($limit);
    }
}
