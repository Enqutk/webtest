<?php

namespace App\Models;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use App\Traits\HasUserStamps;

class Hero extends Model
{
    use SoftDeletes, HasUserStamps;

    protected static function booted(): void
    {
        static::deleting(function (Hero $hero) {
            if ($hero->isForceDeleting()) {
                Storage::disk('public')->delete($hero->img_path);
            }
        });
    }

    protected $table = 'heroes';

    protected $fillable = [
        'title',
        'description',
        'img_path',
        'link',
        'order',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'status'      => StatusEnum::class,
        'order'       => 'integer',
        'created_at'  => 'datetime',
        'updated_at'  => 'datetime',
        'deleted_at'  => 'datetime',
    ];

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
