<?php

namespace App\Models;

use App\MediaLibrary\ModelNamePathGenerator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;

class Team extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia;

    protected $fillable = [
        'first_name',
        'last_name',
        'title',
        'description',
        'image_path',
        'status',
        'founder',
        'order',
    ];

    protected $casts = [
        'founder' => 'boolean',
        'status' => \App\Enums\StatusEnum::class,
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    
    public static function getStatusOptions(): array
    {
        $options = [];
        foreach (\App\Enums\StatusEnum::cases() as $case) {
            $options[$case->value] = ucfirst($case->name);
        }
        return $options;
    }

     public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('team-images')
            ->useDisk('public')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml']);
    }
}
