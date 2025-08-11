<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrganizationResource\Pages;
use App\Models\Organization;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;

class OrganizationResource extends Resource
{
    protected static ?string $model = Organization::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('map_url')
                        ->label('Map URL')
                        ->url()
                        ->maxLength(255),
                ]),
            Forms\Components\Repeater::make('opening_hours')
                ->label('Opening Hours')
                ->schema([
                    Forms\Components\Select::make('days')
                        ->label('Days')
                        ->multiple()
                        ->options([
                            'mon' => 'Monday',
                            'tue' => 'Tuesday',
                            'wed' => 'Wednesday',
                            'thu' => 'Thursday',
                            'fri' => 'Friday',
                            'sat' => 'Saturday',
                            'sun' => 'Sunday',
                        ])
                        ->required(),
                    Forms\Components\TimePicker::make('from')
                        ->label('From')
                        ->required(),
                    Forms\Components\TimePicker::make('to')
                        ->label('To')
                        ->required(),
                ])
                ->columns(3)
                ->minItems(1)
                ->addActionLabel('Add Opening Hours'),

            Forms\Components\Select::make('status')
                ->label('Status')
                ->options([
                    'active' => 'Active',
                    'inactive' => 'Inactive',
                ])
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
            'edit' => Pages\EditOrganization::route('/1/edit'),
        ];
    }

    public static function getRecord(): ?\App\Models\Organization
    {
        // Always return the first (and only) organization
        return Organization::first();
    }
}
