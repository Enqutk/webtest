<?php

namespace App\Models;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\BelongsToOrganization;
use App\Traits\HasUserStamps;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Support\Str;

class Page extends Model implements HasMedia
{
    use SoftDeletes, HasUserStamps, InteractsWithMedia, BelongsToOrganization;

    public const RESERVED_SLUGS = [
        'about',
        'contact',
        'our-services',
        'portfolio',
        'mgt',
        'up',
        'home',
        'apply',
        'cards',
        'order',
        'order-card',
    ];

    protected $fillable = [
        'organization_id',
        'title',
        'slug',
        'short_description',
        'content',
        'is_active',
        'display_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'display_order' => 'integer',
        'content' => 'array',
    ];

    // Relationships
    public function sections(): HasMany
    {
        return $this->hasMany(PageSection::class)->orderBy('display_order');
    }

    public function activeSections(): HasMany
    {
        return $this->hasMany(PageSection::class)->where('is_active', true)->orderBy('display_order');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Media Collections
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('hero_image')
            ->singleFile()
            ->registerMediaConversions(function () {
                $this->addMediaConversion('thumb')
                    ->width(300)
                    ->height(200)
                    ->sharpen(10);
            });
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order');
    }

    // Accessors & Mutators
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        if (empty($this->attributes['slug'])) {
            $this->attributes['slug'] = Str::slug($value);
        }
    }

    // Helper Methods
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getUrlAttribute()
    {
        return route('pages.show', $this->slug);
    }

    /**
     * Page-owned sections. Uses content JSON first so admin does not
     * need to open Page Sections or Content Blocks.
     *
     * @return array<int, array<string, mixed>>
     */
    public function displaySections(): array
    {
        $owned = collect($this->content ?? [])
            ->filter(fn ($section) => is_array($section) && ($section['is_visible'] ?? true))
            ->values()
            ->all();

        if ($owned !== []) {
            return $owned;
        }

        return $this->activeSections
            ->map(function ($section) {
                $blocks = $section->activeContentBlocks->map(function ($block) {
                    return [
                        'type' => $block->type?->value ?? 'text',
                        'eyebrow' => $block->subtitle,
                        'heading' => $block->title,
                        'body' => $block->content,
                        'image' => $block->getFirstMediaUrl('images') ?: null,
                        'video_url' => $block->video_url,
                        'items' => $block->list_items ?? [],
                        'is_visible' => true,
                    ];
                })->all();

                return [
                    'type' => 'group',
                    'eyebrow' => $section->subtitle,
                    'heading' => $section->title,
                    'body' => null,
                    'image' => null,
                    'video_url' => null,
                    'items' => [],
                    'blocks' => $blocks,
                    'is_visible' => true,
                ];
            })
            ->all();
    }
}
