<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class OrganizationInvitation extends Model
{
    protected $fillable = [
        'token',
        'client_name',
        'client_email',
        'client_phone',
        'initial_role',
        'card_edition',
        'status',
        'created_by',
        'organization_id',
        'card_application_id',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function cardApplication(): BelongsTo
    {
        return $this->belongsTo(CardApplication::class);
    }

    public static function generateToken(): string
    {
        // Google Meet style friendly invitation code: km-abc-xyz
        $part1 = Str::lower(Str::random(3));
        $part2 = Str::lower(Str::random(4));
        return "km-{$part1}-{$part2}";
    }

    public function getInvitationUrl(): string
    {
        return route('card.invite.show', ['token' => $this->token]);
    }
}
