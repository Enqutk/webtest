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
                Forms\Components\Section::make('Company & Brand Identity')
                    ->description('Set your company details and toggle their visibility on/off.')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->label('Company name')
                                    ->helperText('Main business / brand name (e.g. “Maji Works”).')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\Toggle::make('theme.show_brand_text')
                                    ->label('Company Name Visibility (ON / OFF)')
                                    ->helperText('Turn company name text display ON or OFF in the header and branding.')
                                    ->default(true),
                            ]),
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('tagline')
                                    ->label('Tagline')
                                    ->helperText('Short line under brand and empty-hero fallback.')
                                    ->maxLength(500),
                                Forms\Components\Toggle::make('theme.show_tagline')
                                    ->label('Tagline Visibility (ON / OFF)')
                                    ->helperText('Turn tagline ON or OFF across the website.')
                                    ->default(true),
                            ]),
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('po_box')
                                    ->label('PO Box')
                                    ->maxLength(100),
                                Forms\Components\Toggle::make('theme.show_po_box')
                                    ->label('PO Box Visibility (ON / OFF)')
                                    ->default(true),
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
                                    ->default(true),
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
                                    ->default(true),
                            ]),
                    ])
                    ->columns(1),

                Forms\Components\Section::make('Header & Navigation Settings')
                    ->description('Toggle header components ON or OFF.')
                    ->schema([
                        Forms\Components\Toggle::make('theme.show_header_logo')
                            ->label('Show Logo in Header (ON / OFF)')
                            ->helperText('Toggle logo image in the header navbar.')
                            ->default(true),
                        Forms\Components\Toggle::make('theme.show_header_cta')
                            ->label('Header Action Button / CTA (ON / OFF)')
                            ->helperText('Toggle the action button (e.g. “Get in touch”) on the right side of the navbar.')
                            ->default(true)
                            ->live(),
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('theme.header_cta_text')
                                    ->label('CTA Button Text')
                                    ->default('Get in touch')
                                    ->placeholder('Get in touch')
                                    ->visible(fn (Forms\Get $get) => (bool) ($get('theme.show_header_cta') ?? true)),
                                Forms\Components\TextInput::make('theme.header_cta_url')
                                    ->label('CTA Button URL')
                                    ->default('/contact')
                                    ->placeholder('/contact')
                                    ->visible(fn (Forms\Get $get) => (bool) ($get('theme.show_header_cta') ?? true)),
                            ]),
                    ])
                    ->columns(2)
                    ->collapsed(false),

                Forms\Components\Section::make('Footer Elements Visibility')
                    ->description('Toggle individual footer sections ON or OFF.')
                    ->schema([
                        Forms\Components\Toggle::make('theme.show_footer_tagline')
                            ->label('Footer Tagline (ON / OFF)')
                            ->default(true),
                        Forms\Components\Toggle::make('theme.show_footer_social')
                            ->label('Footer Social Icons (ON / OFF)')
                            ->default(true),
                        Forms\Components\Toggle::make('theme.show_footer_nav')
                            ->label('Footer Navigation Links (ON / OFF)')
                            ->default(true),
                        Forms\Components\Toggle::make('theme.show_footer_contact')
                            ->label('Footer Contact Details (ON / OFF)')
                            ->default(true),
                        Forms\Components\Toggle::make('theme.show_footer_credit')
                            ->label('Developer Credits (ON / OFF)')
                            ->default(true),
                    ])
                    ->columns(3)
                    ->collapsed(false),

                Forms\Components\Section::make('Contact & Location Details')
                    ->description('Manage address, map, hours, and toggle their visibility ON or OFF.')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('address')
                                    ->label('Address')
                                    ->maxLength(255),
                                Forms\Components\Toggle::make('theme.show_address')
                                    ->label('Address Visibility (ON / OFF)')
                                    ->default(true),
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
                            ->options(Organization::getFontOptions())
                            ->default('Fraunces')
                            ->searchable(),
                        Forms\Components\Select::make('theme.font_body')
                            ->label('Body Font')
                            ->helperText('Applied to body paragraphs, nav links, and UI elements.')
                            ->options(Organization::getFontOptions())
                            ->default('Outfit')
                            ->searchable(),
                    ])
                    ->columns(2)
                    ->collapsed(false),

                Forms\Components\Section::make('Brand colors')
                    ->description('These override the public site theme. Leave blank to keep defaults. Change and save, then hard-refresh the site.')
                    ->schema([
                        Forms\Components\ColorPicker::make('theme.accent')
                            ->label('Accent')
                            ->helperText('Buttons, links, highlights'),
                        Forms\Components\ColorPicker::make('theme.accent_dark')
                            ->label('Accent (hover)')
                            ->helperText('Optional — auto-darkened from accent if empty'),
                        Forms\Components\ColorPicker::make('theme.ink')
                            ->label('Text / ink'),
                        Forms\Components\ColorPicker::make('theme.muted')
                            ->label('Muted text'),
                        Forms\Components\ColorPicker::make('theme.bg')
                            ->label('Page background'),
                        Forms\Components\ColorPicker::make('theme.surface')
                            ->label('Cards / surface'),
                        Forms\Components\ColorPicker::make('theme.line')
                            ->label('Borders / lines'),
                        Forms\Components\ColorPicker::make('theme.dark')
                            ->label('Footer / dark blocks'),
                    ])
                    ->columns(2)
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
