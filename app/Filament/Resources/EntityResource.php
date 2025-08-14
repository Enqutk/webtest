<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EntityResource\Pages;
use App\Models\Entity;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Enums\EntityTypeEnum;
use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;

class EntityResource extends Resource
{
    protected static ?string $model = Entity::class;
    protected static ?string $navigationGroup = 'Other';
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationLabel = 'Entity';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Select::make('type')
                    ->options(EntityTypeEnum::class)
                    ->required(),
                TextInput::make('link')
                    ->maxLength(255)
                    ->url()
                    ->nullable(),
                SpatieMediaLibraryFileUpload::make('image')
                    ->collection('image')
                    ->image()
                    ->imagePreviewHeight('150'),
                Textarea::make('description')
                    ->maxLength(65535)
                    ->nullable(),
                TextInput::make('order')
                    ->numeric()
                    ->default(1)
                    ->minValue(1)
                    ->unique(ignoreRecord: true)
                    ->required(),
                Select::make('status')
                    ->options(StatusEnum::class)
                    ->default(StatusEnum::active),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
               TextColumn::make('id')->sortable(),
               TextColumn::make('name')->searchable()->sortable(),
               TextColumn::make('type')->badge()->sortable(),
               SpatieMediaLibraryImageColumn::make('image')->collection('image')->circular()->size(50),
               TextColumn::make('link')->url(fn($record) => $record->link)->openUrlInNewTab(true)->searchable(),
               TextColumn::make('order')->sortable(),
               TextColumn::make('status')->badge()
                    ->color(fn(StatusEnum $state): string => match ($state) {
                        StatusEnum::active => 'success',
                        StatusEnum::inactive => 'danger',
                    }) ->sortable(),
               TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
               TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
               TextColumn::make('deleted_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
               TextColumn::make('creator.name')->label('Created By')->sortable()->toggleable(isToggledHiddenByDefault: true),
               TextColumn::make('updater.name')->label('Updated By')->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                Tables\Filters\SelectFilter::make('type')
                    ->options(EntityTypeEnum::class),
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
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withoutGlobalScopes([
            SoftDeletingScope::class,
        ]);
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEntities::route('/'),
            'create' => Pages\CreateEntity::route('/create'),
            'edit' => Pages\EditEntity::route('/{record}/edit'),
        ];
    }
}
