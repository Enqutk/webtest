<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrganizationResource\Pages;
use App\Filament\Resources\OrganizationResource\RelationManagers;
use App\Models\Organization;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

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
                            ->label('Short Title')
                            ->maxLength(100),
                    ]),
                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\TextInput::make('address')
                            ->label('System Creator')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('map_url')
                            ->label('Creator Website')
                            ->url()
                            ->maxLength(255),
                    ]),
                Forms\Components\Textarea::make('opening_hours')
                    ->label('Meta Keywords')
                    ->rows(2)
                    ->helperText('Comma-separated list of keywords'),
                Forms\Components\Textarea::make('status')
                    ->label('Meta Description')
                    ->rows(2),
                Forms\Components\TextInput::make('created_at')
                    ->label('System Version')
                    ->default('1.0.0')
                    ->required(),
            ])
            ->columns(1)
            ->statePath('organization');
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

    public static function getRecord(): ?\App\Models\Organization
    {
        // Always return the first (and only) organization
        return \App\Models\Organization::first();
    }
}
