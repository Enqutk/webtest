<?php

namespace App\Filament\Resources\OrganizationResource\Pages;

use App\Filament\Resources\OrganizationResource;
use App\Models\Organization;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOrganization extends EditRecord
{
    protected static string $resource = OrganizationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('view_site')
                ->label('View Public Website')
                ->icon('heroicon-m-arrow-top-right-on-square')
                ->color('gray')
                ->url(fn (): string => url('/'))
                ->openUrlInNewTab(),

            Actions\DeleteAction::make()
                ->visible(fn () => Organization::count() > 1),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $existingTheme = $this->getRecord()?->theme ?? [];
        if (is_array($existingTheme) && isset($data['theme'])) {
            $data['theme'] = array_merge($existingTheme, $data['theme']);
        }

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return static::$resource::getUrl('index');
    }
}
