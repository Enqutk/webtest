<?php

namespace App\Models;

use App\Enums\StatusEnum;
use App\Traits\BelongsToOrganization;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrganizationContact extends Model
{
    use SoftDeletes, BelongsToOrganization;
    
    protected $fillable = [
        'organization_id',
        'type',
        'value',
        'status'
    ];

    protected $casts = [
        'type' => 'string',
        'status'=> StatusEnum::class,

    ];

  
    public static function getTypeOptions(): array
    {
        return [
            'phone' => 'Phone',
            'fax' => 'Fax',
            'email' => 'Email',
        ];
    }
}
