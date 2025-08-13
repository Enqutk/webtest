<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Models\Service;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Enums\StatusEnum;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;

class ServiceResource extends Resource {
    protected static ?string $model = Service::class;
    protected static ?string $navigationGroup = 'Other';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationLabel = 'Services';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form( Form $form ): Form {
        return $form
        ->schema( [
            Forms\Components\TextInput::make( 'slug' )
            ->required()
            ->unique( ignoreRecord: true ),
            Forms\Components\TextInput::make( 'title' )
            ->required(),
            Forms\Components\SpatieMediaLibraryFileUpload::make( 'svg' )
            ->collection( 'svg' )
            ->image()
            ->acceptedFileTypes( [ 'image/svg+xml' ] )
            ->imagePreviewHeight( 150 ),
            Forms\Components\SpatieMediaLibraryFileUpload::make( 'image_1' )
            ->collection( 'image_1' )
            ->image()
            ->imagePreviewHeight( 150 ),
            Forms\Components\SpatieMediaLibraryFileUpload::make( 'image_2' )
            ->collection( 'image_2' )
            ->image()
            ->imagePreviewHeight( 150 ),
            Forms\Components\Textarea::make( 'short_description' )
            ->maxLength( 65535 )
            ->nullable(),
            Forms\Components\Textarea::make( 'quote' )
            ->rows( 2 )
            ->maxLength( 65535 )
            ->nullable(),
            Forms\Components\Textarea::make( 'description' )
            ->maxLength( 65535 )
            ->nullable(),
            Forms\Components\Textarea::make( 'features' )
            ->maxLength( 65535 )
            ->nullable(),
            Forms\Components\TextInput::make( 'order' )
            ->numeric()
            ->default( 1 )
            ->minValue( 1 )
            ->unique( ignoreRecord: true )
            ->required(),
            Forms\Components\Select::make( 'status' )
            ->options( StatusEnum::class )
            ->default( StatusEnum::active ),
        ] );
    }

    public static function table( Table $table ): Table {
        return $table
        ->columns( [
            Tables\Columns\TextColumn::make( 'id' )->sortable(),
            Tables\Columns\TextColumn::make( 'slug' )->searchable()->sortable(),
            Tables\Columns\TextColumn::make( 'title' )->searchable(),
            Tables\Columns\SpatieMediaLibraryImageColumn::make( 'svg' )
            ->collection( 'svg' )
            ->label( 'SVG' )
            ->size( 50 ),
            Tables\Columns\SpatieMediaLibraryImageColumn::make( 'image_1' )
            ->collection( 'image_1' )
            ->label( 'Image 1' )
            ->size( 50 ),
            Tables\Columns\SpatieMediaLibraryImageColumn::make( 'image_2' )
            ->collection( 'image_2' )
            ->label( 'Image 2' )
            ->size( 50 ),
            Tables\Columns\TextColumn::make( 'short_description' )->limit( 50 ),
            Tables\Columns\TextColumn::make( 'order' )->sortable(),
            Tables\Columns\TextColumn::make( 'status' )->badge(),
            Tables\Columns\TextColumn::make( 'created_at' )->dateTime()->sortable()->toggleable( isToggledHiddenByDefault: true ),
            Tables\Columns\TextColumn::make( 'updated_at' )->dateTime()->sortable()->toggleable( isToggledHiddenByDefault: true ),
            Tables\Columns\TextColumn::make( 'creator.name' )->label( 'Created By' )->sortable()->toggleable( isToggledHiddenByDefault: true ),
            Tables\Columns\TextColumn::make( 'updater.name' )->label( 'Updated By' )->sortable()->toggleable( isToggledHiddenByDefault: true ),
            Tables\Columns\TextColumn::make( 'deleted_at' )->dateTime()->sortable()->toggleable( isToggledHiddenByDefault: true ),
        ] )
        ->filters( [
            Tables\Filters\SelectFilter::make( 'status' )
            ->options( \App\Enums\StatusEnum::class ),
        ] )
        ->actions( [
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
            Tables\Actions\ForceDeleteAction::make(),
            Tables\Actions\RestoreAction::make(),
        ] )
        ->bulkActions( [
            Tables\Actions\BulkActionGroup::make( [
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\ForceDeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
            ] ),
        ] )
        ->defaultSort( 'order' );
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
