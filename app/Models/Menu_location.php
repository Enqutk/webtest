<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu_location extends Model
{
    protected $fillable = [
        'name', 
        'slug', 
        'location', 
        'description'
    ];



    public function items()
    {
        return $this->hasMany(MenuItem::class);
    }

}
