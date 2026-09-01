<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HomePageResource\Pages;
use App\Models\Organization;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;

class HomePageResource extends Resource
{
    protected static ?string $model = Organization::class;

    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static ?string $navigationLabel = 'Home Page Sections';

    protected static ?string $modelLabel = 'Home Page Section';

    protected static ?string $pluralModelLabel = 'Home Page Sections';

    protected static ?string $navigationGroup = 'Website';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Home Page Customizer')
                    ->tabs([
                        // Tab 1: Hero Section
                        Forms\Components\Tabs\Tab::make('Hero Banner')
                            ->icon('heroicon-m-sparkles')
                            ->schema([
                                Forms\Components\Section::make('Hero Banner Settings')
                                    ->description('Global headline, badge, and action buttons for the top hero banner.')
                                    ->headerActions([
                                        Forms\Components\Actions\Action::make('configure_hero')
                                            ->label('Configure Banner (Modal)')
                                            ->icon('heroicon-m-pencil-square')
                                            ->color('primary')
                                            ->modalHeading('Configure Hero Banner Settings')
                                            ->modalDescription('Update the main top headline, category badge, supporting copy, and action buttons.')
                                            ->modalWidth('3xl')
                                            ->modalSubmitActionLabel('Save Banner Settings')
                                            ->fillForm(fn ($get) => [
                                                'is_visible' => $get('theme.home_sections.hero.is_visible') ?? true,
                                                'badge' => $get('theme.home_sections.hero.badge') ?: 'Infrastructure · Engineering · Impact',
                                                'subtitle' => $get('theme.home_sections.hero.subtitle') ?: 'Engineering Excellence',
                                                'title' => $get('theme.home_sections.hero.title') ?: 'Building resilient infrastructure for lasting communities',
                                                'description' => $get('theme.home_sections.hero.description') ?: 'We design, engineer, and deliver high-impact water and infrastructure systems that power communities across East Africa.',
                                                'cta_text' => $get('theme.home_sections.hero.cta_text') ?: 'Explore Our Work',
                                                'cta_url' => $get('theme.home_sections.hero.cta_url') ?: '/portfolio',
                                                'secondary_cta_text' => $get('theme.home_sections.hero.secondary_cta_text') ?: 'Our Services',
                                                'secondary_cta_url' => $get('theme.home_sections.hero.secondary_cta_url') ?: '/our-services',
                                            ])
                                            ->form([
                                                Forms\Components\Toggle::make('is_visible')
                                                    ->label('Show Hero Section on Home Page (ON / OFF)')
                                                    ->default(true),
                                                Forms\Components\Grid::make(2)
                                                    ->schema([
                                                        Forms\Components\TextInput::make('badge')
                                                            ->label('Eyebrow / Badge')
                                                            ->placeholder('e.g. Infrastructure · Engineering · Impact')
                                                            ->maxLength(255),
                                                        Forms\Components\TextInput::make('subtitle')
                                                            ->label('Category / Subtitle')
                                                            ->placeholder('e.g. Engineering Excellence')
                                                            ->maxLength(255),
                                                    ]),
                                                Forms\Components\TextInput::make('title')
                                                    ->label('Main Headline')
                                                    ->placeholder('e.g. Building resilient infrastructure for lasting communities')
                                                    ->required()
                                                    ->maxLength(255),
                                                Forms\Components\Textarea::make('description')
                                                    ->label('Supporting Paragraph')
                                                    ->placeholder('We design, engineer, and deliver high-impact systems...')
                                                    ->rows(3)
                                                    ->maxLength(500),
                                                Forms\Components\Grid::make(2)
                                                    ->schema([
                                                        Forms\Components\TextInput::make('cta_text')
                                                            ->label('Primary Button Text')
                                                            ->default('Explore Our Work'),
                                                        Forms\Components\TextInput::make('cta_url')
                                                            ->label('Primary Button Link')
                                                            ->default('/portfolio'),
                                                    ]),
                                                Forms\Components\Grid::make(2)
                                                    ->schema([
                                                        Forms\Components\TextInput::make('secondary_cta_text')
                                                            ->label('Secondary Button Text')
                                                            ->default('Our Services'),
                                                        Forms\Components\TextInput::make('secondary_cta_url')
                                                            ->label('Secondary Button Link')
                                                            ->default('/our-services'),
                                                    ]),
                                            ])
                                            ->action(function (array $data, $set) {
                                                foreach ($data as $key => $val) {
                                                    $set("theme.home_sections.hero.{$key}", $val);
                                                }
                                            }),
                                    ])
                                    ->schema([
                                        Forms\Components\Toggle::make('theme.home_sections.hero.is_visible')
                                            ->label('Show Hero Section on Home Page (ON / OFF)')
                                            ->default(true)
                                            ->live(),

                                        Forms\Components\Placeholder::make('hero_summary')
                                            ->label('Current Banner Configuration')
                                            ->content(function ($get) {
                                                $title = $get('theme.home_sections.hero.title') ?: 'Building resilient infrastructure for lasting communities';
                                                $badge = $get('theme.home_sections.hero.badge') ?: 'Infrastructure · Engineering · Impact';
                                                $sub = $get('theme.home_sections.hero.subtitle') ?: 'Engineering Excellence';
                                                $desc = $get('theme.home_sections.hero.description') ?: 'We design, engineer, and deliver high-impact water and infrastructure systems...';
                                                $btn1 = ($get('theme.home_sections.hero.cta_text') ?: 'Explore Our Work') . ' (' . ($get('theme.home_sections.hero.cta_url') ?: '/portfolio') . ')';
                                                $btn2 = ($get('theme.home_sections.hero.secondary_cta_text') ?: 'Our Services') . ' (' . ($get('theme.home_sections.hero.secondary_cta_url') ?: '/our-services') . ')';

                                                return new \Illuminate\Support\HtmlString("
                                                    <div style='display: grid; gap: 0.5rem; font-size: 0.875rem; background: rgba(0,0,0,0.02); border: 1px solid rgba(0,0,0,0.06); padding: 0.85rem 1.15rem; border-radius: 0.5rem;'>
                                                        <div><span style='font-weight: 600; opacity: 0.7;'>Eyebrow / Badge:</span> " . e($badge) . " &bull; <span style='font-weight: 600; opacity: 0.7;'>Category:</span> " . e($sub) . "</div>
                                                        <div><span style='font-weight: 600; opacity: 0.7;'>Headline:</span> <strong>" . e($title) . "</strong></div>
                                                        <div style='opacity: 0.85; font-size: 0.825rem;'><span style='font-weight: 600; opacity: 0.7;'>Supporting Text:</span> " . e(\Illuminate\Support\Str::limit($desc, 120)) . "</div>
                                                        <div style='font-size: 0.8rem; display: flex; gap: 1rem;'><span style='font-weight: 600; opacity: 0.7;'>Buttons:</span> <span>🔹 " . e($btn1) . "</span> <span>🔸 " . e($btn2) . "</span></div>
                                                    </div>
                                                ");
                                            }),

                                        // Hidden fields to ensure live wire state persists
                                        Forms\Components\Hidden::make('theme.home_sections.hero.badge')->default('Infrastructure · Engineering · Impact'),
                                        Forms\Components\Hidden::make('theme.home_sections.hero.subtitle')->default('Engineering Excellence'),
                                        Forms\Components\Hidden::make('theme.home_sections.hero.title')->default('Building resilient infrastructure for lasting communities'),
                                        Forms\Components\Hidden::make('theme.home_sections.hero.description')->default('We design, engineer, and deliver high-impact water and infrastructure systems that power communities across East Africa.'),
                                        Forms\Components\Hidden::make('theme.home_sections.hero.cta_text')->default('Explore Our Work'),
                                        Forms\Components\Hidden::make('theme.home_sections.hero.cta_url')->default('/portfolio'),
                                        Forms\Components\Hidden::make('theme.home_sections.hero.secondary_cta_text')->default('Our Services'),
                                        Forms\Components\Hidden::make('theme.home_sections.hero.secondary_cta_url')->default('/our-services'),
                                    ]),

                                Forms\Components\Section::make('Hero Carousel Slides')
                                    ->description('Add, edit, reorder, or toggle individual carousel slide photos, headlines, and links directly on the home page.')
                                    ->schema([
                                        Forms\Components\Repeater::make('theme.home_sections.hero.slides')
                                            ->label('Hero Carousel Slides')
                                            ->helperText('Manage individual slides displayed in the homepage carousel slider. Click "Add Slide (Modal)" or the pencil icon to edit in a modal.')
                                            ->default(fn () => Organization::defaultHeroSlides())
                                            ->afterStateHydrated(function (Forms\Components\Repeater $component, $state) {
                                                if (empty($state)) {
                                                    $component->state(Organization::defaultHeroSlides());
                                                } elseif (is_array($state)) {
                                                    $updated = [];
                                                    foreach ($state as $key => $slide) {
                                                        if (isset($slide['image']) && is_string($slide['image']) && filled($slide['image'])) {
                                                            $clean = str_replace(url('/storage') . '/', '', $slide['image']);
                                                            $clean = str_replace('/storage/', '', $clean);
                                                            $slide['image'] = [$clean => $clean];
                                                        }
                                                        $updated[$key] = $slide;
                                                    }
                                                    $component->state($updated);
                                                }
                                            })
                                            ->schema(self::getHeroSlideFormSchema())
                                            ->columns(1)
                                            ->reorderable()
                                            ->collapsible()
                                            ->collapsed()
                                            ->cloneable()
                                            ->addAction(fn (Forms\Components\Actions\Action $action) => $action
                                                ->label('Add Hero Slide (Modal)')
                                                ->icon('heroicon-m-plus-circle')
                                                ->modalHeading('Add New Hero Slide')
                                                ->modalDescription('Configure a new slide with photo, headline, and action link.')
                                                ->modalWidth('3xl')
                                                ->modalSubmitActionLabel('Add Slide')
                                                ->form(self::getHeroSlideFormSchema())
                                                ->action(function (array $data, Forms\Components\Repeater $component): void {
                                                    $state = $component->getState() ?? [];
                                                    $state[] = $data;
                                                    $component->state($state);
                                                })
                                            )
                                            ->extraItemActions([
                                                Forms\Components\Actions\Action::make('edit_modal')
                                                    ->label('Edit in Modal')
                                                    ->tooltip('Open in modal editor')
                                                    ->icon('heroicon-m-pencil-square')
                                                    ->color('primary')
                                                    ->modalHeading(fn (array $arguments, Forms\Components\Repeater $component): string => 'Edit Slide: ' . ($component->getItemState($arguments['item'])['title'] ?? 'Slide'))
                                                    ->modalWidth('3xl')
                                                    ->modalSubmitActionLabel('Save Slide Changes')
                                                    ->form(self::getHeroSlideFormSchema())
                                                    ->fillForm(fn (array $arguments, Forms\Components\Repeater $component): array => $component->getItemState($arguments['item']) ?? [])
                                                    ->action(function (array $arguments, array $data, Forms\Components\Repeater $component): void {
                                                        $state = $component->getState();
                                                        $state[$arguments['item']] = array_merge($state[$arguments['item']] ?? [], $data);
                                                        $component->state($state);
                                                    }),
                                            ])
                                            ->itemLabel(function (array $state): ?string {
                                                $title = $state['title'] ?? 'Untitled Slide';
                                                $eyebrow = !empty($state['subtitle']) ? "[{$state['subtitle']}] " : '';
                                                $status = (isset($state['is_visible']) && ! $state['is_visible']) ? ' (OFF - Hidden)' : ' (ON - Visible)';
                                                return $eyebrow . $title . $status;
                                            }),
                                    ]),
                            ]),

                        // Tab 2: About & Highlights
                        Forms\Components\Tabs\Tab::make('About & Mission')
                            ->icon('heroicon-m-information-circle')
                            ->schema([
                                Forms\Components\Section::make('About Section Settings')
                                    ->description('Customize the intro about section and key capability bullet points.')
                                    ->schema([
                                        Forms\Components\Toggle::make('theme.home_sections.about.is_visible')
                                            ->label('Show About Section on Home Page (ON / OFF)')
                                            ->default(true)
                                            ->live(),

                                        Forms\Components\Grid::make(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('theme.home_sections.about.eyebrow')
                                                    ->label('Section Eyebrow')
                                                    ->default('Who we are')
                                                    ->maxLength(100),
                                                Forms\Components\TextInput::make('theme.home_sections.about.title')
                                                    ->label('Section Heading')
                                                    ->default('Water expertise for living landscapes')
                                                    ->required()
                                                    ->maxLength(255),
                                            ]),

                                        Forms\Components\Textarea::make('theme.home_sections.about.description')
                                            ->label('Main Introduction Description')
                                            ->default('We combine technical hydrology, sustainable agriculture, and community governance to design water infrastructure that lasts generations.')
                                            ->rows(4),

                                        Forms\Components\Repeater::make('theme.home_sections.about.points')
                                            ->label('Core Pillars / Highlights')
                                            ->default([
                                                ['title' => 'Design & Build', 'description' => 'Turnkey irrigation schemes, boreholes, and piped distribution networks.'],
                                                ['title' => 'Climate Resilience', 'description' => 'Flood control, catchment rehabilitation, and water harvesting structures.'],
                                                ['title' => 'Governance & Training', 'description' => 'Capacity building for community water management committees and utilities.'],
                                            ])
                                            ->schema([
                                                Forms\Components\TextInput::make('title')
                                                    ->label('Pillar Title')
                                                    ->required(),
                                                Forms\Components\TextInput::make('description')
                                                    ->label('Pillar Description')
                                                    ->required(),
                                            ])
                                            ->columns(2)
                                            ->reorderable()
                                            ->collapsible(),
                                    ]),
                            ]),

                        // Tab 3: Services Section
                        Forms\Components\Tabs\Tab::make('Services Section')
                            ->icon('heroicon-m-wrench-screwdriver')
                            ->schema([
                                Forms\Components\Section::make('Services Section Header')
                                    ->description('Configure the title and copy above the services cards on the home page.')
                                    ->schema([
                                        Forms\Components\Toggle::make('theme.home_sections.services.is_visible')
                                            ->label('Show Services Section on Home Page (ON / OFF)')
                                            ->default(true)
                                            ->live(),

                                        Forms\Components\Grid::make(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('theme.home_sections.services.eyebrow')
                                                    ->label('Eyebrow')
                                                    ->default('What we deliver'),
                                                Forms\Components\TextInput::make('theme.home_sections.services.title')
                                                    ->label('Heading')
                                                    ->default('Specialized engineering across the water cycle')
                                                    ->required(),
                                            ]),

                                        Forms\Components\Textarea::make('theme.home_sections.services.description')
                                            ->label('Section Description')
                                            ->default('From feasibility studies to long-term asset management, our services address critical water challenges.')
                                            ->rows(3),

                                        Forms\Components\Grid::make(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('theme.home_sections.services.cta_text')
                                                    ->label('Bottom Link Text')
                                                    ->default('View all services'),
                                                Forms\Components\TextInput::make('theme.home_sections.services.cta_url')
                                                    ->label('Bottom Link URL')
                                                    ->default('/our-services'),
                                            ]),
                                    ]),
                            ]),

                        // Tab 4: Impact & Stats
                        Forms\Components\Tabs\Tab::make('Impact & Stats')
                            ->icon('heroicon-m-chart-bar')
                            ->schema([
                                Forms\Components\Section::make('Impact Numbers & Statistics')
                                    ->description('Manage animated impact counters and statistics.')
                                    ->schema([
                                        Forms\Components\Toggle::make('theme.home_sections.stats.is_visible')
                                            ->label('Show Stats Section on Home Page (ON / OFF)')
                                            ->default(true)
                                            ->live(),

                                        Forms\Components\Grid::make(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('theme.home_sections.stats.eyebrow')
                                                    ->label('Eyebrow')
                                                    ->default('By the numbers'),
                                                Forms\Components\TextInput::make('theme.home_sections.stats.title')
                                                    ->label('Section Title')
                                                    ->default('Impact that compounds across communities')
                                                    ->required(),
                                            ]),

                                        Forms\Components\Textarea::make('theme.home_sections.stats.subtitle')
                                            ->label('Section Subtitle')
                                            ->default('Measured outcomes delivered through disciplined engineering and long-term community stewardship.')
                                            ->rows(2),

                                        Forms\Components\Repeater::make('theme.home_sections.stats.items')
                                            ->label('Impact Counter Items')
                                            ->default([
                                                ['value' => '25+', 'label' => 'Counties served', 'description' => 'Across East Africa'],
                                                ['value' => '140k+', 'label' => 'People with clean water', 'description' => 'Sustainable access'],
                                                ['value' => '98%', 'label' => 'Scheme uptime', 'description' => 'Reliable operations'],
                                                ['value' => '65+', 'label' => 'Completed projects', 'description' => 'On time & budget'],
                                            ])
                                            ->schema([
                                                Forms\Components\TextInput::make('value')
                                                    ->label('Stat Number / Metric')
                                                    ->placeholder('e.g. 25+, 140k+, 98%')
                                                    ->required(),
                                                Forms\Components\TextInput::make('label')
                                                    ->label('Metric Label')
                                                    ->placeholder('e.g. Counties served')
                                                    ->required(),
                                                Forms\Components\TextInput::make('description')
                                                    ->label('Subtext (Optional)')
                                                    ->placeholder('e.g. Across East Africa'),
                                            ])
                                            ->columns(3)
                                            ->reorderable()
                                            ->collapsible(),
                                    ]),
                            ]),

                        // Tab 5: Portfolio Section
                        Forms\Components\Tabs\Tab::make('Portfolio Section')
                            ->icon('heroicon-m-briefcase')
                            ->schema([
                                Forms\Components\Section::make('Featured Projects Section')
                                    ->description('Customize the heading and introduction for the portfolio projects grid.')
                                    ->schema([
                                        Forms\Components\Toggle::make('theme.home_sections.portfolio.is_visible')
                                            ->label('Show Portfolio Section on Home Page (ON / OFF)')
                                            ->default(true)
                                            ->live(),

                                        Forms\Components\Grid::make(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('theme.home_sections.portfolio.eyebrow')
                                                    ->label('Eyebrow')
                                                    ->default('Selected projects'),
                                                Forms\Components\TextInput::make('theme.home_sections.portfolio.title')
                                                    ->label('Heading')
                                                    ->default('Engineered systems operating in the field')
                                                    ->required(),
                                            ]),

                                        Forms\Components\Textarea::make('theme.home_sections.portfolio.description')
                                            ->label('Description')
                                            ->default('A showcase of recent irrigation schemes, dam rehabilitations, and municipal water supply projects.')
                                            ->rows(3),

                                        Forms\Components\Grid::make(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('theme.home_sections.portfolio.cta_text')
                                                    ->label('CTA Button Text')
                                                    ->default('View full portfolio'),
                                                Forms\Components\TextInput::make('theme.home_sections.portfolio.cta_url')
                                                    ->label('CTA Button URL')
                                                    ->default('/portfolio'),
                                            ]),
                                    ]),
                            ]),

                        // Tab 6: Clients Section
                        Forms\Components\Tabs\Tab::make('Clients & Partners')
                            ->icon('heroicon-m-user-group')
                            ->schema([
                                Forms\Components\Section::make('Clients & Partners Section')
                                    ->schema([
                                        Forms\Components\Toggle::make('theme.home_sections.clients.is_visible')
                                            ->label('Show Clients Section on Home Page (ON / OFF)')
                                            ->default(true)
                                            ->live(),

                                        Forms\Components\Grid::make(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('theme.home_sections.clients.eyebrow')
                                                    ->label('Eyebrow')
                                                    ->default('Trusted partners'),
                                                Forms\Components\TextInput::make('theme.home_sections.clients.title')
                                                    ->label('Heading')
                                                    ->default('Organizations we work alongside')
                                                    ->required(),
                                            ]),

                                        Forms\Components\Textarea::make('theme.home_sections.clients.description')
                                            ->label('Description')
                                            ->default('Partnering with governments, development agencies, private developers, and local communities.')
                                            ->rows(2),
                                    ]),
                            ]),

                        // Tab 7: Team Section
                        Forms\Components\Tabs\Tab::make('Leadership Team')
                            ->icon('heroicon-m-users')
                            ->schema([
                                Forms\Components\Section::make('Team Section Settings')
                                    ->schema([
                                        Forms\Components\Toggle::make('theme.home_sections.team.is_visible')
                                            ->label('Show Team Section on Home Page (ON / OFF)')
                                            ->default(true)
                                            ->live(),

                                        Forms\Components\Grid::make(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('theme.home_sections.team.eyebrow')
                                                    ->label('Eyebrow')
                                                    ->default('Leadership & Team'),
                                                Forms\Components\TextInput::make('theme.home_sections.team.title')
                                                    ->label('Heading')
                                                    ->default('Experienced engineers & hydrologists')
                                                    ->required(),
                                            ]),

                                        Forms\Components\Textarea::make('theme.home_sections.team.description')
                                            ->label('Description')
                                            ->default('Multidisciplinary experts dedicated to delivering technical precision and community impact.')
                                            ->rows(2),

                                        Forms\Components\Grid::make(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('theme.home_sections.team.cta_text')
                                                    ->label('CTA Button Text')
                                                    ->default('Meet the entire team'),
                                                Forms\Components\TextInput::make('theme.home_sections.team.cta_url')
                                                    ->label('CTA Button URL')
                                                    ->default('/about#team'),
                                            ]),
                                    ]),
                            ]),

                        // Tab 8: Call to Action Banner
                        Forms\Components\Tabs\Tab::make('CTA Banner')
                            ->icon('heroicon-m-megaphone')
                            ->schema([
                                Forms\Components\Section::make('Bottom Call to Action Banner')
                                    ->description('Configure the high-contrast call to action banner above the footer.')
                                    ->schema([
                                        Forms\Components\Toggle::make('theme.home_sections.cta.is_visible')
                                            ->label('Show CTA Banner on Home Page (ON / OFF)')
                                            ->default(true)
                                            ->live(),

                                        Forms\Components\TextInput::make('theme.home_sections.cta.title')
                                            ->label('Banner Headline')
                                            ->default('Have a project in mind?')
                                            ->required(),

                                        Forms\Components\Textarea::make('theme.home_sections.cta.description')
                                            ->label('Banner Text / Copy')
                                            ->default('Climate-smart irrigation, rural WASH, flood resilience, and water-resource GIS across East Africa.')
                                            ->rows(3),

                                        Forms\Components\Grid::make(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('theme.home_sections.cta.button_text')
                                                    ->label('Button Text')
                                                    ->default('Start a conversation'),
                                                Forms\Components\TextInput::make('theme.home_sections.cta.button_url')
                                                    ->label('Button Link')
                                                    ->default('/contact'),
                                            ]),
                                    ]),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function getHeroSlideFormSchema(): array
    {
        return [
            Forms\Components\Grid::make(2)
                ->schema([
                    Forms\Components\TextInput::make('subtitle')
                        ->label('Eyebrow')
                        ->placeholder('e.g. Irrigation · WASH · Resilience')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('title')
                        ->label('Slide Headline')
                        ->placeholder('e.g. Water systems that feed people')
                        ->required()
                        ->maxLength(255),
                ]),
            Forms\Components\Textarea::make('description')
                ->label('Slide Supporting Text')
                ->rows(3)
                ->maxLength(500),
            Forms\Components\FileUpload::make('image')
                ->label('Slide Background Photo')
                ->image()
                ->imageEditor()
                ->disk('public')
                ->directory('hero-slides')
                ->visibility('public')
                ->formatStateUsing(function ($state) {
                    if (blank($state)) {
                        return [];
                    }
                    if (is_string($state)) {
                        $clean = str_replace(url('/storage') . '/', '', $state);
                        $clean = str_replace('/storage/', '', $clean);
                        return [$clean => $clean];
                    }
                    return (array) $state;
                })
                ->dehydrateStateUsing(function ($state) {
                    if (is_array($state)) {
                        $val = array_values($state)[0] ?? null;
                        return is_string($val) ? $val : null;
                    }
                    return is_string($state) ? $state : null;
                })
                ->helperText('Use a wide photo (about 1200×900 or larger).'),
            Forms\Components\Grid::make(3)
                ->schema([
                    Forms\Components\TextInput::make('text_link')
                        ->label('Button Label')
                        ->default('Explore services'),
                    Forms\Components\TextInput::make('button_link')
                        ->label('Button Link')
                        ->default('/our-services'),
                    Forms\Components\Toggle::make('is_visible')
                        ->label('Slide Visibility (ON / OFF)')
                        ->default(true),
                ]),
        ];
    }

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\EditHomePage::route('/'),
        ];
    }
}
