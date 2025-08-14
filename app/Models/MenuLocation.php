<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class MenuLocation extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'name', 
        'slug', 
        'location', 
        'description'
    ];
    protected $casts = [
        'location' => \App\Enums\LocationEnum::class,
    ];
    
    public function items()
    {
        return $this->hasMany(MenuItem::class , 'menu_id');
    }

}
