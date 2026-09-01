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

    protected function mutateFormDataBeforeFill(array $data): array
    {
        if (isset($data['theme']['home_sections']['hero']['slides']) && is_array($data['theme']['home_sections']['hero']['slides'])) {
            foreach ($data['theme']['home_sections']['hero']['slides'] as &$slide) {
                if (isset($slide['image']) && is_string($slide['image']) && filled($slide['image'])) {
                    $img = $slide['image'];
                    $slide['image'] = [$img => $img];
                }
            }
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (isset($data['theme']['home_sections']['hero']['slides']) && is_array($data['theme']['home_sections']['hero']['slides'])) {
            foreach ($data['theme']['home_sections']['hero']['slides'] as &$slide) {
                if (isset($slide['image']) && is_array($slide['image'])) {
                    $slide['image'] = array_values($slide['image'])[0] ?? null;
                }
            }
        }

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
