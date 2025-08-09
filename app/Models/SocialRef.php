<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SocialRef extends Model {
    use SoftDeletes;

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
}
