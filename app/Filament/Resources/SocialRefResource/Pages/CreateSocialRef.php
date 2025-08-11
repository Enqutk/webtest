<?php

namespace App\Filament\Resources\SocialRefResource\Pages;

use App\Filament\Resources\SocialRefResource;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Traits\SetsCreatedAndUpdatedBy;

class CreateSocialRef extends CreateRecord
{
    use SetsCreatedAndUpdatedBy;
    protected static string $resource = SocialRefResource::class;
}
