<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MenuLocationResource\Pages;
use App\Filament\Resources\MenuLocationResource\RelationManagers;
use App\Models\MenuLocation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\TextFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class MenuLocationResource extends Resource
{
    protected static ?string $model = MenuLocation::class;
    protected static ?string $navigationGroup = 'Menus';


    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(120)
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('slug', Str::slug($state));
                    }),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(120)
                    ->unique(MenuLocation::class, 'slug', ignoreRecord: true)
                    ->disabled(),
                Forms\Components\Select::make('location')
                    ->options([
                        'navbar' => 'Navbar',
                        'footer' => 'Footer',
                        'sidebar' => 'Sidebar',
                        'custom' => 'Custom',
                    ])
                    ->default('navbar'),
                Forms\Components\Textarea::make('description')
                    ->nullable(),
            ])->columns(1);
            
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Name'),
                Tables\Columns\TextColumn::make('slug')->label('Slug'),
                Tables\Columns\TextColumn::make('location')->label('Location'),
                Tables\Columns\TextColumn::make('description')->label('Description'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('location')
                    ->options([
                        'navbar' => 'Navbar',
                        'footer' => 'Footer',
                        'sidebar' => 'Sidebar',
                    ]),
                    
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMenuLocations::route('/'),
            'create' => Pages\CreateMenuLocation::route('/create'),
            'edit' => Pages\EditMenuLocation::route('/{record}/edit'),
        ];
    }
}
