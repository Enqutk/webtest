<?php

namespace App\Traits;

use App\Models\Organization;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToOrganization
{
    public static function bootBelongsToOrganization(): void
    {
        // Auto-assign organization_id on creation if available
        static::creating(function ($model) {
            if (empty($model->organization_id)) {
                $tenant = Filament::getTenant();
                if ($tenant instanceof Organization) {
                    $model->organization_id = $tenant->id;
                } elseif (app()->bound('currentOrganization')) {
                    $model->organization_id = app('currentOrganization')->id;
                } else {
                    $defaultOrg = Organization::first();
                    if ($defaultOrg) {
                        $model->organization_id = $defaultOrg->id;
                    }
                }
            }
        });
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function scopeForOrganization(Builder $query, int|Organization $organization): Builder
    {
        $id = $organization instanceof Organization ? $organization->id : $organization;
        return $query->where('organization_id', $id);
    }
}
