<?php

namespace App\Filament\Resources\SocialRefResource\Pages;

use App\Filament\Resources\SocialRefResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditSocialRef extends EditRecord {
    protected static string $resource = SocialRefResource::class;

    protected function getHeaderActions(): array {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    protected function mutateFormDataBeforeSave( array $data ): array {
        $data[ 'updated_by' ] = Auth::user()->id;
        return $data;
    }
}
