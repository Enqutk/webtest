<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Enums\StatusEnum;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Illuminate\Support\Str;
use Filament\Forms\Set;

class PostResource extends Resource {
    protected static ?string $model = Post::class;
    protected static ?string $navigationGroup = 'Blog';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function form( Form $form ): Form {
        return $form
        ->schema( [
            Forms\Components\TextInput::make( 'title' )
            ->required()
            ->maxLength( 400 )
            ->live( onBlur: true )
            ->afterStateUpdated(
                fn ( Set $set, ?string $state ) => $set( 'slug', Str::slug( $state ) )
            ),
            Forms\Components\Select::make( 'category_id' )
            ->relationship( 'category', 'name' )
            ->required()
            ->searchable()
            ->preload(),
            Forms\Components\Textarea::make( 'short_description' )
            ->required()
            ->maxLength( 1000 )
            ->rows( 3 ),
            Forms\Components\RichEditor::make( 'content' )
            ->columnSpanFull()
            ->toolbarButtons( [
                'bold',
                'italic',
                'underline',
                'strike',
                'link',
                'bulletList',
                'orderedList',
                'h2',
                'h3',
                'h4',
                'blockquote',
                'codeBlock',
            ] ),
            Forms\Components\TextInput::make( 'tags' )
            ->maxLength( 255 )
            ->helperText( 'Comma-separated tags' ),
            Forms\Components\TextInput::make( 'slug' )
            ->maxLength( 255 )
            ->unique( ignoreRecord: true )
            ->helperText( 'Leave empty to auto-generate from title' ),
            Forms\Components\Toggle::make( 'is_active' )
            ->default( true )
            ->label( 'Active' ),
            Forms\Components\SpatieMediaLibraryFileUpload::make( 'main_image' )
            ->collection( 'main_image' )
            ->image()
            ->imagePreviewHeight( '200' )
            ->label( 'Main Image' )
            ->required(),
            Forms\Components\SpatieMediaLibraryFileUpload::make( 'gallery' )
            ->collection( 'gallery' )
            ->multiple()
            ->image()
            ->imagePreviewHeight( '100' )
            ->label( 'Gallery Images' ),
        ] );
    }

    public static function table( Table $table ): Table {
        return $table
        ->columns( [
            Tables\Columns\TextColumn::make( 'id' )->sortable(),
            Tables\Columns\TextColumn::make( 'title' )->searchable()->sortable()->limit( 50 ),
            Tables\Columns\TextColumn::make( 'category.name' )->searchable()->sortable(),
            Tables\Columns\SpatieMediaLibraryImageColumn::make( 'main_image' )
            ->collection( 'main_image' )
            ->square()
            ->size( 50 ),
            Tables\Columns\TextColumn::make( 'short_description' )->limit( 50 )->tooltip( fn( $record ) => $record->short_description ),
            Tables\Columns\IconColumn::make( 'is_active' )
            ->boolean()
            ->sortable(),
            Tables\Columns\TextColumn::make( 'created_at' )->dateTime()->sortable()->toggleable( isToggledHiddenByDefault: true ),
            Tables\Columns\TextColumn::make( 'updated_at' )->dateTime()->sortable()->toggleable( isToggledHiddenByDefault: true ),
            Tables\Columns\TextColumn::make( 'deleted_at' )
            ->dateTime()
            ->sortable()
            ->toggleable( isToggledHiddenByDefault: true ),
        ] )
        ->filters( [
            Tables\Filters\TrashedFilter::make(),
            Tables\Filters\SelectFilter::make( 'category_id' )
            ->relationship( 'category', 'name' )
            ->label( 'Category' ),
            Tables\Filters\TernaryFilter::make( 'is_active' )
            ->label( 'Active Status' ),
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
        ->defaultSort( 'created_at', 'desc' );
    }

    public static function getRelations(): array {
        return [
            //
        ];
    }

    public static function getEloquentQuery(): Builder {
        return parent::getEloquentQuery()->withoutGlobalScopes( [
            SoftDeletingScope::class,
        ] );
    }

    public static function getPages(): array {
        return [
            'index' => Pages\ListPosts::route( '/' ),
            'create' => Pages\CreatePost::route( '/create' ),
            'edit' => Pages\EditPost::route( '/{record}/edit' ),
        ];
    }
}
