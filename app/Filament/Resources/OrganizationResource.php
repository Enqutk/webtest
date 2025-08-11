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
            Forms\Components\Textarea::make('opening_hours')
                ->label('Opening Hours')
                ->rows(2),
            Forms\Components\Textarea::make('status')
                ->label('Status')
                ->rows(2),
            Forms\Components\TextInput::make('created_at')
                ->label('Created At')
                ->required()
                ->disabled(),

            // Phone Contact
            Forms\Components\Fieldset::make('Phone Contact')
                ->schema([
                    Forms\Components\TextInput::make('phone_contact')
                        ->label('Phone')
                        ->maxLength(100),
                ]),

            // Fax Contact
            Forms\Components\Fieldset::make('Fax Contact')
                ->schema([
                    Forms\Components\TextInput::make('fax_contact')
                        ->label('Fax')
                        ->maxLength(100),
                ]),

            // Email Contact
            Forms\Components\Fieldset::make('Email Contact')
                ->schema([
                    Forms\Components\TextInput::make('email_contact')
                        ->label('Email')
                        ->email()
                        ->maxLength(100),
                ]),
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
