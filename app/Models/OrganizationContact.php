<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizationContact extends Model
{
    protected $fillable = [
        'type',
        'value',
    ];

    protected $casts = [
        'type' => 'string',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}
