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

class EntityResource extends Resource
{
    protected static ?string $model = Entity::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('type')
                    ->options(EntityTypeEnum::class)
                    ->required(),
                Forms\Components\TextInput::make('link')
                    ->maxLength(255)
                    ->url()
                    ->nullable(),
                Forms\Components\SpatieMediaLibraryFileUpload::make('images')
                    ->image('thumb') 
                    ->imagePreviewHeight('150')
                    ->required(),
                Forms\Components\Textarea::make('description')
                    ->maxLength(65535)
                    ->nullable(),
                Forms\Components\TextInput::make('order')
                    ->numeric()
                    ->default(1)
                    ->minValue(1)
                    ->unique(ignoreRecord: true)
                    ->required(),
                Forms\Components\Select::make('status')
                    ->options(StatusEnum::class)
                    ->default(StatusEnum::active)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('type')->badge()->sortable(),
                Tables\Columns\SpatieMediaLibraryImageColumn::make('images')
                    ->square()
                    ->size(50)
                    ->url(fn($record) => $record->getFirstMediaUrl('images', 'thumb') ?: null),

                Tables\Columns\TextColumn::make('link')->url(fn($record) => $record->link)->openUrlInNewTab(true)->searchable(),
                Tables\Columns\TextColumn::make('order')->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn(StatusEnum $state): string => match ($state) {
                        StatusEnum::active => 'success',
                        StatusEnum::inactive => 'danger',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                Tables\Filters\SelectFilter::make('type')
                    ->options(EntityTypeEnum::class),
                Tables\Filters\SelectFilter::make('status')
                    ->options(
                        (StatusEnum::class),
                    ),
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
