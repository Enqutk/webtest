<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class OrganizationContact extends Model
{
    use SoftDeletes;
    
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
    public static function getTypeOptions(): array
    {
        return [
            'phone' => 'Phone',
            'fax' => 'Fax',
            'email' => 'Email',
        ];
    }
}
