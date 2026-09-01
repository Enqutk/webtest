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
            $this->addHeroSlideAction(),
            $this->configureHeroBannerAction(),
            \Filament\Actions\Action::make('view_site')
                ->label('View Live Home Page')
                ->icon('heroicon-m-arrow-top-right-on-square')
                ->color('gray')
                ->url(url('/'))
                ->openUrlInNewTab(),
        ];
    }

    public function configureHeroBannerAction(): \Filament\Actions\Action
    {
        return \Filament\Actions\Action::make('configureHeroBanner')
            ->label('Configure Banner (Modal)')
            ->icon('heroicon-m-pencil-square')
            ->modalHeading('Configure Hero Banner Settings')
            ->modalDescription('Update the top hero headline, category badge, supporting copy, and action buttons.')
            ->modalWidth('3xl')
            ->modalSubmitActionLabel('Save Banner Settings')
            ->fillForm(function (): array {
                $record = $this->getRecord();
                $hero = $record?->theme['home_sections']['hero'] ?? Organization::defaultHomeSections()['hero'];
                return [
                    'is_visible' => $hero['is_visible'] ?? true,
                    'badge' => $hero['badge'] ?? 'Infrastructure · Engineering · Impact',
                    'subtitle' => $hero['subtitle'] ?? 'Engineering Excellence',
                    'title' => $hero['title'] ?? 'Building resilient infrastructure for lasting communities',
                    'description' => $hero['description'] ?? 'We design, engineer, and deliver high-impact water and infrastructure systems that power communities across East Africa.',
                    'cta_text' => $hero['cta_text'] ?? 'Explore Our Work',
                    'cta_url' => $hero['cta_url'] ?? '/portfolio',
                    'secondary_cta_text' => $hero['secondary_cta_text'] ?? 'Our Services',
                    'secondary_cta_url' => $hero['secondary_cta_url'] ?? '/our-services',
                    'image_shape' => $hero['image_shape'] ?? 'inherit',
                ];
            })
            ->form([
                \Filament\Forms\Components\Toggle::make('is_visible')
                    ->label('Show Hero Section on Home Page (ON / OFF)')
                    ->default(true),
                \Filament\Forms\Components\Select::make('image_shape')
                    ->label('Hero Carousel Slide Photo Shape')
                    ->options(Organization::imageShapeOptions(true))
                    ->default('inherit')
                    ->helperText('Shape and corner rounding applied to the hero slide photos.'),
                \Filament\Forms\Components\Grid::make(2)
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('badge')
                            ->label('Eyebrow / Badge')
                            ->placeholder('e.g. Infrastructure · Engineering · Impact')
                            ->maxLength(255),
                        \Filament\Forms\Components\TextInput::make('subtitle')
                            ->label('Category / Subtitle')
                            ->placeholder('e.g. Engineering Excellence')
                            ->maxLength(255),
                    ]),
                \Filament\Forms\Components\TextInput::make('title')
                    ->label('Main Headline')
                    ->placeholder('e.g. Building resilient infrastructure for lasting communities')
                    ->required()
                    ->maxLength(255),
                \Filament\Forms\Components\Textarea::make('description')
                    ->label('Supporting Paragraph')
                    ->rows(3)
                    ->maxLength(500),
                \Filament\Forms\Components\Grid::make(2)
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('cta_text')
                            ->label('Primary Button Text')
                            ->default('Explore Our Work'),
                        \Filament\Forms\Components\TextInput::make('cta_url')
                            ->label('Primary Button Link')
                            ->default('/portfolio'),
                    ]),
                \Filament\Forms\Components\Grid::make(2)
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('secondary_cta_text')
                            ->label('Secondary Button Text')
                            ->default('Our Services'),
                        \Filament\Forms\Components\TextInput::make('secondary_cta_url')
                            ->label('Secondary Button Link')
                            ->default('/our-services'),
                    ]),
            ])
            ->action(function (array $data) {
                $record = $this->getRecord();
                $theme = is_array($record->theme) ? $record->theme : Organization::defaultTheme();
                foreach ($data as $k => $v) {
                    $theme['home_sections']['hero'][$k] = $v;
                }
                $record->theme = $theme;
                $record->save();
                $this->fillForm();
                \Filament\Notifications\Notification::make()
                    ->title('Hero banner settings saved')
                    ->success()
                    ->send();
            });
    }

    public function addHeroSlideAction(): \Filament\Actions\Action
    {
        return \Filament\Actions\Action::make('addHeroSlide')
            ->label('Add Hero Slide (Modal)')
            ->icon('heroicon-m-plus-circle')
            ->modalHeading('Add New Hero Slide')
            ->modalDescription('Add a carousel slide photo, headline, supporting text, and action button.')
            ->modalWidth('3xl')
            ->modalSubmitActionLabel('Add Slide')
            ->form(HomePageResource::getHeroSlideFormSchema())
            ->action(function (array $data) {
                $record = $this->getRecord();
                $theme = is_array($record->theme) ? $record->theme : Organization::defaultTheme();
                $slides = $theme['home_sections']['hero']['slides'] ?? Organization::defaultHeroSlides();

                $img = $data['image'] ?? null;
                if (is_array($img)) {
                    $img = array_values($img)[0] ?? null;
                }
                $data['image'] = $img;

                $slides[] = $data;
                $theme['home_sections']['hero']['slides'] = $slides;
                $record->theme = $theme;
                $record->save();
                $this->fillForm();
                \Filament\Notifications\Notification::make()
                    ->title('Slide added successfully')
                    ->success()
                    ->send();
            });
    }

    public function editHeroSlideAction(): \Filament\Actions\Action
    {
        return \Filament\Actions\Action::make('editHeroSlide')
            ->modalHeading('Edit Hero Slide')
            ->modalWidth('3xl')
            ->modalSubmitActionLabel('Save Slide Changes')
            ->fillForm(function (array $arguments): array {
                $index = $arguments['index'] ?? 0;
                $record = $this->getRecord();
                $slides = $record->theme['home_sections']['hero']['slides'] ?? Organization::defaultHeroSlides();
                $slide = $slides[$index] ?? [];
                if (isset($slide['image']) && is_string($slide['image']) && filled($slide['image'])) {
                    $slide['image'] = [$slide['image'] => $slide['image']];
                }
                return $slide;
            })
            ->form(HomePageResource::getHeroSlideFormSchema())
            ->action(function (array $arguments, array $data) {
                $index = $arguments['index'] ?? 0;
                $record = $this->getRecord();
                $theme = is_array($record->theme) ? $record->theme : Organization::defaultTheme();
                $slides = $theme['home_sections']['hero']['slides'] ?? Organization::defaultHeroSlides();

                $img = $data['image'] ?? null;
                if (is_array($img)) {
                    $img = array_values($img)[0] ?? null;
                }
                $data['image'] = $img;

                $slides[$index] = $data;
                $theme['home_sections']['hero']['slides'] = $slides;
                $record->theme = $theme;
                $record->save();
                $this->fillForm();
                \Filament\Notifications\Notification::make()
                    ->title('Slide updated successfully')
                    ->success()
                    ->send();
            });
    }

    public function deleteHeroSlideAction(): \Filament\Actions\Action
    {
        return \Filament\Actions\Action::make('deleteHeroSlide')
            ->requiresConfirmation()
            ->modalHeading('Delete Slide')
            ->modalDescription('Are you sure you want to delete this slide from the homepage carousel?')
            ->modalSubmitActionLabel('Delete Slide')
            ->color('danger')
            ->action(function (array $arguments) {
                $index = $arguments['index'] ?? 0;
                $record = $this->getRecord();
                $theme = is_array($record->theme) ? $record->theme : Organization::defaultTheme();
                $slides = $theme['home_sections']['hero']['slides'] ?? Organization::defaultHeroSlides();

                unset($slides[$index]);
                $theme['home_sections']['hero']['slides'] = array_values($slides);
                $record->theme = $theme;
                $record->save();
                $this->fillForm();
                \Filament\Notifications\Notification::make()
                    ->title('Slide deleted')
                    ->success()
                    ->send();
            });
    }

    public function toggleHeroSlideVisibility(int $index): void
    {
        $record = $this->getRecord();
        $theme = is_array($record->theme) ? $record->theme : Organization::defaultTheme();
        $slides = $theme['home_sections']['hero']['slides'] ?? Organization::defaultHeroSlides();

        if (isset($slides[$index])) {
            $slides[$index]['is_visible'] = !($slides[$index]['is_visible'] ?? true);
            $theme['home_sections']['hero']['slides'] = $slides;
            $record->theme = $theme;
            $record->save();
            $this->fillForm();
        }
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
