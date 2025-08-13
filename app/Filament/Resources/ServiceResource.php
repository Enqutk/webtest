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
use Filament\Forms\Set;
use Illuminate\Support\Str;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;
    protected static ?string $navigationGroup = 'Other';
    protected static ?int $navigationSort = 4;
    protected static ?string $navigationLabel = 'Services';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn(Set $set, ?string $state) => $set('slug', Str::slug($state))),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true),

                Forms\Components\SpatieMediaLibraryFileUpload::make('svg')
                    ->collection('svg')
                    ->image()
                    ->acceptedFileTypes(['image/svg+xml'])
                    ->imagePreviewHeight(150),
                Forms\Components\SpatieMediaLibraryFileUpload::make('main_image')
                    ->collection('main_image')
                    ->image()
                    ->imagePreviewHeight(150),
                Forms\Components\SpatieMediaLibraryFileUpload::make('secondary_image')
                    ->collection('secondary_image')
                    ->image()
                    ->imagePreviewHeight(150),
                Forms\Components\Textarea::make('short_description')
                    ->maxLength(2000)
                    ->nullable(),
                Forms\Components\Textarea::make('quote')
                    ->rows(2)
                    ->maxLength(65535)
                    ->nullable(),

                Forms\Components\RichEditor::make('description')
                    ->columnSpanFull()
                    ->toolbarButtons([
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
                    ]),

                Forms\Components\RichEditor::make('features')
                    ->columnSpanFull()
                    ->toolbarButtons([
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
                    ]),
                Forms\Components\TextInput::make('order')
                    ->numeric()
                    ->default(1)
                    ->minValue(1)
                    ->unique(ignoreRecord: true)
                    ->required(),
                Forms\Components\Select::make('status')
                    ->options(StatusEnum::class)
                    ->default(StatusEnum::active),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('title')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('slug')->searchable()->sortable(),
                Tables\Columns\SpatieMediaLibraryImageColumn::make('svg')
                    ->collection('svg')
                    ->label('SVG')
                    ->size(50),
                Tables\Columns\SpatieMediaLibraryImageColumn::make('main_image')
                    ->collection('main_image')
                    ->label('Image 1')
                    ->size(50),
                Tables\Columns\SpatieMediaLibraryImageColumn::make('secondary_image')
                    ->collection('secondary_image')
                    ->label('Image 2')
                    ->size(50),
                Tables\Columns\TextColumn::make('short_description')->limit(50),
                Tables\Columns\TextColumn::make('order')->sortable(),
                Tables\Columns\TextColumn::make('status')->badge(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('creator.name')->label('Created By')->sortable()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updater.name')->label('Updated By')->sortable()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(StatusEnum::class),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])
            ->defaultSort('order');
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
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
