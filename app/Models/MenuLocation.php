<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuLocation extends Model
{
    protected $fillable = [
        'name', 
        'slug', 
        'location', 
        'description'
    ];



    public function items()
    {
        return $this->hasMany(MenuItem::class, 'menu_id');
    }

}
