<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class CardApplication extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'reference_code',
        'type',
        'name',
        'slug',
        'email',
        'phone',
        'role_title',
        'company_name',
        'tagline',
        'bio',
        'card_edition',
        'quote_amount',
        'theme',
        'highlights',
        'portfolio',
        'social_links',
        'photo_path',
        'status',
        'organization_id',
        'user_id',
        'admin_notes',
    ];

    protected $casts = [
        'theme' => 'array',
        'highlights' => 'array',
        'portfolio' => 'array',
        'social_links' => 'array',
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function generateReferenceCode(): string
    {
        $prefix = 'KIMEM-' . date('y');
        $random = strtoupper(substr(bin2hex(random_bytes(3)), 0, 5));
        return "{$prefix}-{$random}";
    }

    public function getCardEditionTitle(): string
    {
        return match ($this->card_edition) {
            'brushed_gold' => 'Brushed Gold Metal Edition',
            'executive_black' => 'Executive Matte Black Edition',
            default => 'Midnight Obsidian Navy Edition',
        };
    }

    public function getBadgeClass(): string
    {
        return match ($this->status) {
            'approved' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
            'rejected' => 'bg-rose-50 text-rose-700 border-rose-200',
            default => 'bg-amber-50 text-amber-700 border-amber-200',
        };
    }
}
