<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $fillable = [
        'menu_id',
        'parent_id',
        'title',
        'icon',
        'link_type',
        'url',
        'target',
        'order_number'
    ];

    public function menu()
    {
        return $this->belongsTo(MenuLocation::class , 'menu_id');
    }

    public function parent()
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }

}
