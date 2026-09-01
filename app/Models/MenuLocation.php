<?php

namespace App\Models;

use App\Enums\MenuLocationEnum;
use App\Traits\BelongsToOrganization;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuLocation extends Model
{
    use SoftDeletes, BelongsToOrganization;
    
    protected $fillable = [
        'organization_id',
        'name', 
        'slug', 
        'location', 
        'description'
    ];
    protected $casts = [
        'location' => MenuLocationEnum::class,
    ];
    
    public function items()
    {
        return $this->hasMany(MenuItem::class , 'menu_id');
    }

}
