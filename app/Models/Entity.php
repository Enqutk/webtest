<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Enums\EntityTypeEnum;
use App\Enums\StatusEnum;

class Entity extends Model {
    use SoftDeletes;

    protected $fillable = [
        'name',
        'type',
        'link',
        'image_path',
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

    public function creator() {
        return $this->belongsTo( User::class, 'created_by' );
    }

    public function updater() {
        return $this->belongsTo( User::class, 'updated_by' );
    }
}