<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SocialRef extends Model {
     use SoftDeletes;
    public static function statusOptions(): array {
        return [
            'active' => 'Active',
            'inactive' => 'Inactive',
        ];
    }
    protected $table = 'social_refs';

    protected $fillable = [
        'title',
        'link',
        'description',
        'icon_class',
        'order',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $casts = [

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'order' => 'integer',
    ];

    public function createdBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
        return $this->belongsTo( User::class, 'created_by' );
    }

    public function updatedBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
        return $this->belongsTo( User::class, 'updated_by' );
    }
}
