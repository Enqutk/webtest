<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Filament\Resources\ServiceResource\RelationManagers;
use App\Models\Service;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ServiceResource extends Resource {
    protected static ?string $model = Service::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form( Form $form ): Form {
        return $form
        ->schema( [
            Forms\Components\TextInput::make( 'slug' )
            ->required()
            ->unique(),
            Forms\Components\TextInput::make( 'title' )
            ->required(),
            Forms\Components\Textarea::make( 'svg_path' )
            ->rows( 2 ),
            Forms\Components\Textarea::make( 'image_1_path' )
            ->rows( 2 ),
            Forms\Components\Textarea::make( 'image_2_path' )
            ->rows( 2 ),
            Forms\Components\Textarea::make( 'short_description' )
            ->rows( 3 ),
            Forms\Components\Textarea::make( 'quote' )
            ->rows( 2 ),
            Forms\Components\Textarea::make( 'description' )
            ->rows( 5 ),
            Forms\Components\Textarea::make( 'features' )
            ->rows( 3 ),
            Forms\Components\TextInput::make( 'order' )
            ->numeric()
            ->default( 1 ),
            Forms\Components\Select::make( 'status' )
            ->options( \App\Enums\StatusEnum::class )
            ->required(),
        ] );
    }

    public static function table( Table $table ): Table {
        return $table
        ->columns( [
            Tables\Columns\TextColumn::make( 'id' )->sortable(),
            Tables\Columns\TextColumn::make( 'slug' )->searchable()->sortable(),
            Tables\Columns\TextColumn::make( 'title' )->searchable(),
            Tables\Columns\TextColumn::make( 'short_description' )->limit( 50 ),
            Tables\Columns\TextColumn::make( 'order' )->sortable(),
            Tables\Columns\TextColumn::make( 'status' )->badge(),
            Tables\Columns\TextColumn::make( 'created_by' )->label( 'Creator' )->sortable(),
            Tables\Columns\TextColumn::make( 'updated_by' )->label( 'Updater' )->sortable(),
            Tables\Columns\TextColumn::make( 'created_at' )->dateTime()->sortable(),
            Tables\Columns\TextColumn::make( 'updated_at' )->dateTime()->sortable(),
        ] )
        ->filters( [
            Tables\Filters\SelectFilter::make( 'status' )
            ->options( \App\Enums\StatusEnum::class ),
        ] )
        ->actions( [
            Tables\Actions\EditAction::make(),
        ] )
        ->bulkActions( [
            Tables\Actions\BulkActionGroup::make( [
                Tables\Actions\DeleteBulkAction::make(),
            ] ),
        ] );
    }

    public static function getRelations(): array {
        return [
            //
        ];
    }

    public static function getPages(): array {
        return [
            'index' => Pages\ListServices::route( '/' ),
            'create' => Pages\CreateService::route( '/create' ),
            'edit' => Pages\EditService::route( '/{record}/edit' ),
        ];
    }
}
