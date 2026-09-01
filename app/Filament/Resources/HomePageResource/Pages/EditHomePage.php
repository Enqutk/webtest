<?php

namespace App\Filament\Resources\HomePageResource\Pages;

use App\Filament\Resources\HomePageResource;
use App\Models\Organization;
use Filament\Resources\Pages\EditRecord;

class EditHomePage extends EditRecord
{
    protected static string $resource = HomePageResource::class;

    public function mount($record = null): void
    {
        $organization = Organization::firstOrCreate([], [
            'title' => 'Your Organization',
            'status' => 'active',
        ]);

        parent::mount($organization->getKey());
    }

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\Action::make('view_site')
                ->label('View Live Home Page')
                ->icon('heroicon-m-arrow-top-right-on-square')
                ->color('gray')
                ->url(url('/'))
                ->openUrlInNewTab(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return static::$resource::getUrl('index');
    }
}
