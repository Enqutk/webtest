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
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MenuLocationResource extends Resource
{
    protected static ?string $model = MenuLocation::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                 Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('location')
                    ->required()
                    ->options([
                        'header' => 'Header',
                        'footer' => 'Footer',
                        'sidebar' => 'Sidebar',
                    ]),
                Forms\Components\Textarea::make('description')
                    ->required()
                    ->maxLength(500),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('slug'),
                Tables\Columns\TextColumn::make('location'),
                Tables\Columns\TextColumn::make('description'),
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
