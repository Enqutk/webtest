<?php

namespace App\Filament\Resources\HeroResource\Pages;

use App\Filament\Resources\HeroResource;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Traits\SetsCreatedAndUpdatedBy;

class CreateHero extends CreateRecord
{
    use SetsCreatedAndUpdatedBy;

    protected static string $resource = HeroResource::class;
}
