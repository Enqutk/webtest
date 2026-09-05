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
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;

use App\Traits\BelongsToOrganization;

class Service extends Model implements HasMedia {
    use SoftDeletes, HasUserStamps, InteractsWithMedia, BelongsToOrganization;

    protected $table = 'services';

    protected $fillable = [
        'organization_id',
        'slug',
        'title',
        'short_description',
        'quote',
        'description',
        'features',
        'order',
        'status',
        'image_focus_x',
        'image_focus_y',
        'secondary_image_focus_x',
        'secondary_image_focus_y',
    ];

    protected $casts = [
        'order' => 'integer',
        'status' => StatusEnum::class,
        'image_focus_x' => 'integer',
        'image_focus_y' => 'integer',
        'secondary_image_focus_x' => 'integer',
        'secondary_image_focus_y' => 'integer',
    ];

    public function creator(): BelongsTo {
        return $this->belongsTo( User::class, 'created_by' );
    }

    public function updater(): BelongsTo {
        return $this->belongsTo( User::class, 'updated_by' );
    }

    public function registerMediaCollections(): void {
        $this->addMediaCollection( 'svg' )
        ->singleFile();

        $this->addImageCollectionWithThumb( 'main_image' );
        $this->addImageCollectionWithThumb( 'secondary_image' );
    }

    private function addImageCollectionWithThumb( string $collectionName ): void {
        $this->addMediaCollection( $collectionName )
        ->singleFile()

        ->registerMediaConversions(

            function () {
                $this->addMediaConversion( 'thumb' )
                ->width( 150 )
                ->height( 150 )
                ->sharpen( 10 );
            }
        );
    }

    protected function secondaryImageUrl(): Attribute {
        return Attribute::make(
            get: fn() => $this->getFirstMediaUrl( 'secondary_image' ),
        );
    }
    protected function mainImageUrl(): Attribute {
        return Attribute::make(
            get: fn() => $this->getFirstMediaUrl( 'main_image' ),
        );
    }
    protected function svgInline(): Attribute {
        return Attribute::make(
            get: function () {
                $media = $this->getFirstMedia( 'svg' );
                if ( !$media ) {
                    return '';
                }

                // Use the media's updated_at timestamp to bust the cache
                $cacheKey = "service.{$this->id}.svg.{$media->updated_at->timestamp}";

                return Cache::rememberForever($cacheKey, function () use ($media) {
                    $path = $media->getPath();
                    if (Storage::disk($media->disk)->exists($path)) {
                        return Storage::disk($media->disk)->get($path);
                    }
                    return '';
                });
            }
        );
    }

    // Add this scope to your Service model:
    public function scopeActiveOrdered(Builder $query, ?int $limit = null)
    {
        $query->where('status', StatusEnum::active)->orderBy('order');
                if ( $limit ) {
                    $query->take( $limit );
                }
                return $query;
            }
        }
