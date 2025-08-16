<?php

namespace App\Filament\Resources;

use App\Enums\StatusEnum;
use App\Filament\Resources\OrganizationResource\Pages;
use App\Models\Organization;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;

class OrganizationResource extends Resource
{
    protected static ?string $model = Organization::class;
    protected static ?string $navigationGroup = 'Setting';
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Title')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('po_box')
                            ->label('PO Box')
                            ->maxLength(100),
                    ]),
                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\TextInput::make('address')
                            ->label('Address')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('map_url')
                            ->label('Map URL')
                            ->nullable()
                            ->maxLength(4024),
                    ]),
                Forms\Components\Repeater::make('opening_hours')
                    ->label('Opening Hours')
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
