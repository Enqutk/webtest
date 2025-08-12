<?php

namespace App\Models;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\HasUserStamps;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Service extends Model implements HasMedia {

       use SoftDeletes, HasUserStamps, InteractsWithMedia;

    protected $table = 'services';

    protected $fillable = [
        'slug',
        'title',
        'svg_path',
        'image_1_path',
        'image_2_path',
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

    public function creator(): BelongsTo {
        return $this->belongsTo( User::class, 'created_by' );
    }

    public function updater(): BelongsTo {
        return $this->belongsTo( User::class, 'updated_by' );
    }
}
