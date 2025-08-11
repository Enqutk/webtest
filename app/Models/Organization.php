<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $fillable = [
        'title',
        'po_box',
        'address',
        'opening_hours',
        'map_url',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    public function contacts()
    {
        return $this->hasMany(OrganizationContact::class);
    }
}
