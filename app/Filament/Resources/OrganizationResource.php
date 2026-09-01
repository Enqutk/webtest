<?php

namespace App\Filament\Resources;

use App\Enums\StatusEnum;
use App\Filament\Resources\OrganizationResource\Pages;
use App\Models\Organization;
use Filament\Forms;
use Filament\Forms\Form;
use App\Filament\Concerns\AuthorizesWithPermission;
use Filament\Resources\Resource;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class OrganizationResource extends Resource
{
    use AuthorizesWithPermission;

    protected static string $permissionKey = 'organization';
    protected static ?string $model = Organization::class;
    protected static ?string $navigationGroup = 'Setting';
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Live Visual Preview')
                    ->description('Instant live preview of your header, brand typography, navigation, action button, tagline, and contact info as you edit them below.')
                    ->schema([
                        Forms\Components\ViewField::make('live_preview')
                            ->view('filament.components.theme-preview')
                            ->dehydrated(false),
                    ])
                    ->collapsible()
                    ->collapsed(false)
                    ->extraAttributes([
                        'class' => 'sticky top-16 z-20 shadow-md',
                    ]),

                Forms\Components\Section::make('Company & Brand Identity')
                    ->description('Set your company details, visibility toggles, and individual text styles.')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->label('Company name')
                                    ->helperText('Main business / brand name (e.g. “Maji Works”).')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(debounce: 300),
                                Forms\Components\Toggle::make('theme.show_brand_text')
                                    ->label('Company Name Visibility (ON / OFF)')
                                    ->helperText('Turn company name text display ON or OFF.')
                                    ->default(true)
                                    ->live(),
                            ]),
                        Forms\Components\Fieldset::make('Company Name Typography & Styling')
                            ->schema([
                                Forms\Components\Select::make('theme.brand_font_family')
                                    ->label('Brand Font')
                                    ->options(Organization::getFontOptionsWithPreview())
                                    ->allowHtml()
                                    ->placeholder('Inherit Display Font')
                                    ->searchable()
                                    ->live(),
                                Forms\Components\Select::make('theme.brand_font_weight')
                                    ->label('Font Weight')
                                    ->options(Organization::getFontWeightOptions())
                                    ->default('700')
                                    ->live(),
                                Forms\Components\TextInput::make('theme.brand_letter_spacing')
                                    ->label('Letter Spacing')
                                    ->placeholder('-0.03em')
                                    ->default('-0.03em')
                                    ->live(debounce: 300),
                            ])
                            ->columns(3),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('tagline')
                                    ->label('Tagline')
                                    ->helperText('Short line under brand and empty-hero fallback.')
                                    ->maxLength(500)
                                    ->live(debounce: 300),
                                Forms\Components\Toggle::make('theme.show_tagline')
                                    ->label('Tagline Visibility (ON / OFF)')
                                    ->helperText('Turn tagline ON or OFF across the website.')
                                    ->default(true)
                                    ->live(),
                            ]),
                        Forms\Components\Fieldset::make('Tagline Typography & Styling')
                            ->schema([
                                Forms\Components\Select::make('theme.tagline_font_family')
                                    ->label('Tagline Font')
                                    ->options(Organization::getFontOptionsWithPreview())
                                    ->allowHtml()
                                    ->placeholder('Inherit Body Font')
                                    ->searchable()
                                    ->live(),
                                Forms\Components\Select::make('theme.tagline_font_style')
                                    ->label('Font Style')
                                    ->options(Organization::getFontStyleOptions())
                                    ->default('normal')
                                    ->live(),
                                Forms\Components\Select::make('theme.tagline_font_weight')
                                    ->label('Font Weight')
                                    ->options(Organization::getFontWeightOptions())
                                    ->default('400')
                                    ->live(),
                            ])
                            ->columns(3),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('po_box')
                                    ->label('PO Box')
                                    ->maxLength(100)
                                    ->live(debounce: 300),
                                Forms\Components\Toggle::make('theme.show_po_box')
                                    ->label('PO Box Visibility (ON / OFF)')
                                    ->default(true)
                                    ->live(),
                            ]),

                        Forms\Components\Textarea::make('meta_description')
                            ->label('Default SEO description')
                            ->helperText('Used as the site-wide meta description when a page does not set its own.')
                            ->rows(2)
                            ->maxLength(500),
                    ]),

                Forms\Components\Section::make('Brand Images')
                    ->description('Upload your brand logo and favicon, and control their visibility.')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('logo')
                                    ->label('Logo')
                                    ->collection('logo')
                                    ->image()
                                    ->imageEditor()
                                    ->helperText('PNG or SVG with transparent background works best.'),
                                Forms\Components\Toggle::make('theme.show_logo')
                                    ->label('Logo Image Visibility (ON / OFF)')
                                    ->helperText('Turn uploaded logo image display ON or OFF.')
                                    ->default(true)
                                    ->live(),
                            ]),
                        Forms\Components\Grid::make(2)
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('favicon')
                                    ->label('Favicon')
                                    ->collection('favicon')
                                    ->image()
                                    ->helperText('Browser tab icon (PNG/ICO, square).'),
                                Forms\Components\Toggle::make('theme.show_favicon')
                                    ->label('Favicon Visibility (ON / OFF)')
                                    ->default(true)
                                    ->live(),
                            ]),
                    ])
                    ->columns(1),

                Forms\Components\Section::make('Header & Navigation Settings')
                    ->description('Manage header logo, action CTA button, typography, and customize each navbar link (rename, turn ON / OFF, reorder, or add new).')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Toggle::make('theme.show_header_logo')
                                    ->label('Show Logo in Header (ON / OFF)')
                                    ->helperText('Toggle logo image in the top header navbar.')
                                    ->default(true)
                                    ->live(),
                                Forms\Components\Toggle::make('theme.show_header_cta')
                                    ->label('Header Action Button / CTA (ON / OFF)')
                                    ->helperText('Toggle the action button (e.g. “Get in touch”) on the right side of navbar.')
                                    ->default(true)
                                    ->live(),
                            ]),

                        Forms\Components\Grid::make(2)
                            ->visible(fn (Forms\Get $get) => (bool) ($get('theme.show_header_cta') ?? true))
                            ->schema([
                                Forms\Components\TextInput::make('theme.header_cta_text')
                                    ->label('CTA Button Text')
                                    ->default('Get in touch')
                                    ->placeholder('Get in touch')
                                    ->live(debounce: 300),
                                Forms\Components\TextInput::make('theme.header_cta_url')
                                    ->label('CTA Button URL')
                                    ->default('/contact')
                                    ->placeholder('/contact'),
                            ]),

                        Forms\Components\Fieldset::make('Navigation Links Typography & Spacing')
                            ->schema([
                                Forms\Components\Select::make('theme.nav_font_family')
                                    ->label('Nav Font')
                                    ->options(Organization::getFontOptionsWithPreview())
                                    ->allowHtml()
                                    ->placeholder('Inherit Body Font')
                                    ->searchable()
                                    ->live(),
                                Forms\Components\Select::make('theme.nav_font_weight')
                                    ->label('Nav Font Weight')
                                    ->options(Organization::getFontWeightOptions())
                                    ->default('500')
                                    ->live(),
                                Forms\Components\TextInput::make('theme.nav_spacing')
                                    ->label('Nav Item Padding / Spacing')
                                    ->placeholder('0.55rem 0.9rem')
                                    ->default('0.55rem 0.9rem')
                                    ->live(debounce: 300),
                            ])
                            ->columns(3),

                        Forms\Components\Repeater::make('theme.nav_items')
                            ->label('Navbar Menu Links (Order, Name & ON / OFF Visibility)')
                            ->helperText('Manage each link in your top navbar. Turn links ON or OFF, change their displayed names, set destinations, or drag to reorder.')
                            ->default([
                                ['label' => 'Home', 'url' => '/', 'is_visible' => true, 'target' => '_self'],
                                ['label' => 'About', 'url' => '/about', 'is_visible' => true, 'target' => '_self'],
                                ['label' => 'Services', 'url' => '/our-services', 'is_visible' => true, 'target' => '_self'],
                                ['label' => 'Portfolio', 'url' => '/portfolio', 'is_visible' => true, 'target' => '_self'],
                                ['label' => 'Contact', 'url' => '/contact', 'is_visible' => true, 'target' => '_self'],
                            ])
                            ->schema([
                                Forms\Components\TextInput::make('label')
                                    ->label('Link Name / Label')
                                    ->placeholder('e.g. Services')
                                    ->required()
                                    ->live(debounce: 300),
                                Forms\Components\TextInput::make('url')
                                    ->label('URL / Route')
                                    ->placeholder('e.g. /our-services or https://...')
                                    ->required(),
                                Forms\Components\Toggle::make('is_visible')
                                    ->label('Visibility (ON / OFF)')
                                    ->default(true)
                                    ->live(),
                                Forms\Components\Select::make('target')
                                    ->label('Open In')
                                    ->options([
                                        '_self' => 'Same Window',
                                        '_blank' => 'New Tab',
                                    ])
                                    ->default('_self'),
                            ])
                            ->columns(4)
                            ->reorderable()
                            ->collapsible()
                            ->cloneable()
                            ->itemLabel(fn (array $state): ?string => ($state['label'] ?? 'Link') . ((isset($state['is_visible']) && ! $state['is_visible']) ? ' (OFF - Hidden)' : ' (ON - Visible)'))
                            ->live(),
                    ])
                    ->columns(1)
                    ->collapsed(false),

                Forms\Components\Section::make('Contact & Location Details')
                    ->description('Manage address, map, hours, and toggle their visibility ON or OFF.')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('address')
                                    ->label('Address')
                                    ->maxLength(255)
                                    ->live(debounce: 300),
                                Forms\Components\Toggle::make('theme.show_address')
                                    ->label('Address Visibility (ON / OFF)')
                                    ->default(true)
                                    ->live(),
                            ]),
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('map_url')
                                    ->label('Map Embed URL / Iframe')
                                    ->nullable()
                                    ->maxLength(4024),
                                Forms\Components\Toggle::make('theme.show_map')
                                    ->label('Map Embed Visibility (ON / OFF)')
                                    ->default(true),
                            ]),
                        Forms\Components\Grid::make(4)
                            ->schema([
                                Forms\Components\Toggle::make('theme.show_email')
                                    ->label('Email List (ON / OFF)')
                                    ->default(true),
                                Forms\Components\Toggle::make('theme.show_phone')
                                    ->label('Phone List (ON / OFF)')
                                    ->default(true),
                                Forms\Components\Toggle::make('theme.show_social_links')
                                    ->label('Social Media (ON / OFF)')
                                    ->default(true),
                                Forms\Components\Toggle::make('theme.show_opening_hours')
                                    ->label('Opening Hours (ON / OFF)')
                                    ->default(true)
                                    ->live(),
                            ]),
                        Forms\Components\Repeater::make('opening_hours')
                            ->label('Opening Hours')
                            ->visible(fn (Forms\Get $get) => (bool) ($get('theme.show_opening_hours') ?? true))
                            ->schema([
                                Forms\Components\Select::make('days')
                                    ->label('Days')
                                    ->multiple()
                                    ->options(Organization::getDayOptions()),
                                Forms\Components\TimePicker::make('from')
                                    ->label('From'),
                                Forms\Components\TimePicker::make('to')
                                    ->label('To')
                            ])
                            ->columns(3)
                            ->minItems(1)
                            ->addActionLabel('Add Opening Hours'),
                    ]),

                Forms\Components\Section::make('Typography & Fonts')
                    ->description('Customize website typography. Google Fonts will automatically load based on your selection.')
                    ->schema([
                        Forms\Components\Select::make('theme.font_display')
                            ->label('Display / Heading Font')
                            ->helperText('Applied to brand text, main headings (H1-H4), and hero titles.')
                            ->options(Organization::getFontOptionsWithPreview())
                            ->allowHtml()
                            ->default('Fraunces')
                            ->searchable()
                            ->live(),
                        Forms\Components\Select::make('theme.font_body')
                            ->label('Body Font')
                            ->helperText('Applied to body paragraphs, nav links, and UI elements.')
                            ->options(Organization::getFontOptionsWithPreview())
                            ->allowHtml()
                            ->default('Outfit')
                            ->searchable()
                            ->live(),
                    ])
                    ->columns(2)
                    ->collapsed(false),

                Forms\Components\Section::make('Design System & Brand Colors')
                    ->description('Universal color tokens applied across the entire website (buttons, navbar, cards, texts, borders, hero, and footer).')
                    ->schema([
                        Forms\Components\ColorPicker::make('theme.accent')
                            ->label('Main Accent / Primary')
                            ->helperText('Primary buttons, active links, badges, highlights, slider dots.')
                            ->live(),
                        Forms\Components\ColorPicker::make('theme.accent_dark')
                            ->label('Primary Dark (Hover)')
                            ->helperText('Hover state for buttons and dark highlights.')
                            ->live(),
                        Forms\Components\ColorPicker::make('theme.ink')
                            ->label('Main Text / Ink')
                            ->helperText('Primary headings, titles, and main body text.')
                            ->live(),
                        Forms\Components\ColorPicker::make('theme.muted')
                            ->label('Muted / Secondary Text')
                            ->helperText('Subtitles, descriptions, helper labels, captions.')
                            ->live(),
                        Forms\Components\ColorPicker::make('theme.bg')
                            ->label('Page Canvas Background')
                            ->helperText('Main body background and light section canvas.')
                            ->live(),
                        Forms\Components\ColorPicker::make('theme.surface')
                            ->label('Surface / Card Background')
                            ->helperText('Header navbar, content cards, dropdowns, forms.')
                            ->live(),
                        Forms\Components\ColorPicker::make('theme.line')
                            ->label('Border / Line Color')
                            ->helperText('Outlines, card borders, dividers, subtle separators.')
                            ->live(),
                        Forms\Components\ColorPicker::make('theme.dark')
                            ->label('Dark Theme / Footer')
                            ->helperText('Website footer background and dark contrast blocks.')
                            ->live(),
                    ])
                    ->columns(4)
                    ->collapsed(false),

                Forms\Components\Select::make('status')
                    ->options(StatusEnum::class)
                    ->default(StatusEnum::active)
                    ->required(),
                Forms\Components\TextInput::make('created_at')
                    ->label('Created At')
                    ->disabled(),
                Forms\Components\TextInput::make('updated_at')
                    ->label('Updated At')
                    ->disabled()
            ]);
    }

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\EditOrganization::route('/'),
        ];
    }

      public static function getRecord(): Organization
    {
        // Always return the first organization, creating it if it doesn't exist.
        return Organization::firstOrCreate([], [
            'title' => 'Your Organization',
            'status' => 'active',
        ]);
    }
}
