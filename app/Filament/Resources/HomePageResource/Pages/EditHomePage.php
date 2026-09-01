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
            $this->addTeamMemberAction(),
            $this->configureTeamSectionAction(),
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

    public function configureTeamSectionAction(): \Filament\Actions\Action
    {
        return \Filament\Actions\Action::make('configureTeamSection')
            ->label('Configure Team Section')
            ->icon('heroicon-m-pencil-square')
            ->modalHeading('Configure Leadership Team Section')
            ->modalDescription('Update the heading, eyebrow, supporting description, CTA button, and photo shape for the team showcase.')
            ->modalWidth('3xl')
            ->modalSubmitActionLabel('Save Team Section')
            ->fillForm(function (): array {
                $record = $this->getRecord();
                $team = $record?->theme['home_sections']['team'] ?? Organization::defaultHomeSections()['team'];
                return [
                    'is_visible' => $team['is_visible'] ?? true,
                    'eyebrow' => $team['eyebrow'] ?? 'Leadership & Team',
                    'title' => $team['title'] ?? 'Experienced engineers & hydrologists',
                    'description' => $team['description'] ?? 'Multidisciplinary experts dedicated to delivering technical precision and community impact.',
                    'cta_text' => $team['cta_text'] ?? 'Meet the entire team',
                    'cta_url' => $team['cta_url'] ?? '/about#team',
                    'image_shape' => $team['image_shape'] ?? 'inherit',
                ];
            })
            ->form([
                \Filament\Forms\Components\Toggle::make('is_visible')
                    ->label('Show Team Section on Home Page (ON / OFF)')
                    ->default(true),
                \Filament\Forms\Components\Select::make('image_shape')
                    ->label('Team Member Photo Shape Style')
                    ->options(Organization::imageShapeOptions(true))
                    ->default('inherit')
                    ->helperText('Shape and corner rounding for team headshots / profile pictures.'),
                \Filament\Forms\Components\Grid::make(2)
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('eyebrow')
                            ->label('Section Eyebrow')
                            ->default('Leadership & Team')
                            ->maxLength(100),
                        \Filament\Forms\Components\TextInput::make('title')
                            ->label('Section Heading')
                            ->default('Experienced engineers & hydrologists')
                            ->required()
                            ->maxLength(255),
                    ]),
                \Filament\Forms\Components\Textarea::make('description')
                    ->label('Section Description')
                    ->rows(3)
                    ->maxLength(500),
                \Filament\Forms\Components\Grid::make(2)
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('cta_text')
                            ->label('CTA Button Text')
                            ->default('Meet the entire team'),
                        \Filament\Forms\Components\TextInput::make('cta_url')
                            ->label('CTA Button Link')
                            ->default('/about#team'),
                    ]),
            ])
            ->action(function (array $data) {
                $record = $this->getRecord();
                $theme = is_array($record->theme) ? $record->theme : Organization::defaultTheme();
                foreach ($data as $k => $v) {
                    $theme['home_sections']['team'][$k] = $v;
                }
                $record->theme = $theme;
                $record->save();
                $this->fillForm();
                \Filament\Notifications\Notification::make()
                    ->title('Team section settings saved')
                    ->success()
                    ->send();
            });
    }

    public function addTeamMemberAction(): \Filament\Actions\Action
    {
        return \Filament\Actions\Action::make('addTeamMember')
            ->label('Add Team Member (Modal)')
            ->icon('heroicon-m-plus-circle')
            ->modalHeading('Add New Team Member')
            ->modalDescription('Add a leadership or staff member with profile photo, name, title, and bio.')
            ->modalWidth('3xl')
            ->modalSubmitActionLabel('Save Team Member')
            ->form([
                \Filament\Forms\Components\Grid::make(2)
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('first_name')
                            ->label('First name')
                            ->required()
                            ->maxLength(120),
                        \Filament\Forms\Components\TextInput::make('last_name')
                            ->label('Last name')
                            ->maxLength(120),
                    ]),
                \Filament\Forms\Components\TextInput::make('title')
                    ->label('Role / Title')
                    ->placeholder('e.g. Lead Irrigation Agronomist')
                    ->required()
                    ->maxLength(190),
                \Filament\Forms\Components\Textarea::make('description')
                    ->label('Short Bio / Description')
                    ->rows(3)
                    ->maxLength(500),
                \Filament\Forms\Components\FileUpload::make('photo')
                    ->label('Profile Photo')
                    ->image()
                    ->imageEditor()
                    ->disk('public')
                    ->directory('team-photos')
                    ->visibility('public')
                    ->helperText('Upload a square or portrait headshot photo.'),
                \Filament\Forms\Components\Grid::make(3)
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('order')
                            ->label('Display Order')
                            ->numeric()
                            ->default(fn () => (\App\Models\Team::max('order') ?? 0) + 1)
                            ->required(),
                        \Filament\Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options(\App\Enums\StatusEnum::class)
                            ->default(\App\Enums\StatusEnum::active)
                            ->required(),
                        \Filament\Forms\Components\Toggle::make('founder')
                            ->label('Founder Badge (ON / OFF)'),
                    ]),
            ])
            ->action(function (array $data) {
                $member = new \App\Models\Team();
                $member->first_name = $data['first_name'];
                $member->last_name = $data['last_name'] ?? null;
                $member->title = $data['title'];
                $member->description = $data['description'] ?? null;
                $member->founder = (bool) ($data['founder'] ?? false);
                $member->order = (int) ($data['order'] ?? 1);
                $member->status = $data['status'] ?? \App\Enums\StatusEnum::active;
                $member->save();

                if (!empty($data['photo'])) {
                    $photoPath = is_array($data['photo']) ? array_values($data['photo'])[0] : $data['photo'];
                    if (is_string($photoPath) && filled($photoPath)) {
                        $fullPath = storage_path('app/public/' . ltrim($photoPath, '/'));
                        if (file_exists($fullPath)) {
                            $member->clearMediaCollection('team-images');
                            $member->addMedia($fullPath)->preservingOriginal()->toMediaCollection('team-images');
                        }
                    }
                }

                $this->fillForm();
                \Filament\Notifications\Notification::make()
                    ->title('Team member added successfully')
                    ->success()
                    ->send();
            });
    }

    public function editTeamMemberAction(): \Filament\Actions\Action
    {
        return \Filament\Actions\Action::make('editTeamMember')
            ->modalHeading('Edit Team Member')
            ->modalWidth('3xl')
            ->modalSubmitActionLabel('Save Changes')
            ->fillForm(function (array $arguments): array {
                $member = \App\Models\Team::find($arguments['id'] ?? 0);
                if (!$member) return [];
                return [
                    'first_name' => $member->first_name,
                    'last_name' => $member->last_name,
                    'title' => $member->title,
                    'description' => $member->description,
                    'founder' => (bool) $member->founder,
                    'order' => $member->order ?? 1,
                    'status' => $member->status?->value ?? 'active',
                ];
            })
            ->form([
                \Filament\Forms\Components\Grid::make(2)
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('first_name')
                            ->label('First name')
                            ->required()
                            ->maxLength(120),
                        \Filament\Forms\Components\TextInput::make('last_name')
                            ->label('Last name')
                            ->maxLength(120),
                    ]),
                \Filament\Forms\Components\TextInput::make('title')
                    ->label('Role / Title')
                    ->required()
                    ->maxLength(190),
                \Filament\Forms\Components\Textarea::make('description')
                    ->label('Short Bio / Description')
                    ->rows(3)
                    ->maxLength(500),
                \Filament\Forms\Components\FileUpload::make('photo')
                    ->label('Change Profile Photo (Optional)')
                    ->image()
                    ->imageEditor()
                    ->disk('public')
                    ->directory('team-photos')
                    ->visibility('public')
                    ->helperText('Upload new photo to replace the current headshot.'),
                \Filament\Forms\Components\Grid::make(3)
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('order')
                            ->label('Display Order')
                            ->numeric()
                            ->required(),
                        \Filament\Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options(\App\Enums\StatusEnum::class)
                            ->required(),
                        \Filament\Forms\Components\Toggle::make('founder')
                            ->label('Founder Badge (ON / OFF)'),
                    ]),
            ])
            ->action(function (array $arguments, array $data) {
                $member = \App\Models\Team::find($arguments['id'] ?? 0);
                if (!$member) return;

                $member->first_name = $data['first_name'];
                $member->last_name = $data['last_name'] ?? null;
                $member->title = $data['title'];
                $member->description = $data['description'] ?? null;
                $member->founder = (bool) ($data['founder'] ?? false);
                $member->order = (int) ($data['order'] ?? 1);
                $member->status = $data['status'] ?? \App\Enums\StatusEnum::active;
                $member->save();

                if (!empty($data['photo'])) {
                    $photoPath = is_array($data['photo']) ? array_values($data['photo'])[0] : $data['photo'];
                    if (is_string($photoPath) && filled($photoPath)) {
                        $fullPath = storage_path('app/public/' . ltrim($photoPath, '/'));
                        if (file_exists($fullPath)) {
                            $member->clearMediaCollection('team-images');
                            $member->addMedia($fullPath)->preservingOriginal()->toMediaCollection('team-images');
                        }
                    }
                }

                $this->fillForm();
                \Filament\Notifications\Notification::make()
                    ->title('Team member updated successfully')
                    ->success()
                    ->send();
            });
    }

    public function deleteTeamMemberAction(): \Filament\Actions\Action
    {
        return \Filament\Actions\Action::make('deleteTeamMember')
            ->requiresConfirmation()
            ->modalHeading('Delete Team Member')
            ->modalDescription('Are you sure you want to remove this team member?')
            ->modalSubmitActionLabel('Delete Member')
            ->color('danger')
            ->action(function (array $arguments) {
                $member = \App\Models\Team::find($arguments['id'] ?? 0);
                if ($member) {
                    $member->delete();
                    $this->fillForm();
                    \Filament\Notifications\Notification::make()
                        ->title('Team member deleted')
                        ->success()
                        ->send();
                }
            });
    }

    public function toggleTeamMemberStatus(int $id): void
    {
        $member = \App\Models\Team::find($id);
        if ($member) {
            $member->status = ($member->status === \App\Enums\StatusEnum::active)
                ? \App\Enums\StatusEnum::inactive
                : \App\Enums\StatusEnum::active;
            $member->save();
            $this->fillForm();
        }
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
