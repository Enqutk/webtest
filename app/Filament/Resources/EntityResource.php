<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EntityResource\Pages;
use App\Models\Entity;
use Filament\Forms\Form;
use App\Filament\Concerns\AuthorizesWithPermission;
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
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;

class EntityResource extends Resource
{
    use AuthorizesWithPermission;

    protected static string $permissionKey = 'entity';
    protected static ?string $model = Entity::class;
    protected static ?string $navigationGroup = 'Website';
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationLabel = 'Portfolio & entities';
    protected static ?string $modelLabel = 'Entity';
    protected static ?string $pluralModelLabel = 'Portfolio & entities';
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Entity details')
                    ->description('Use type “Project” for portfolio items. Clients and partners appear in the logo strip.')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Select::make('type')
                            ->options(EntityTypeEnum::options())
                            ->required()
                            ->live(),
                        TextInput::make('category')
                            ->maxLength(120)
                            ->nullable()
                            ->visible(fn ($get) => $get('type') === EntityTypeEnum::project->value)
                            ->helperText('Portfolio filter label, e.g. Engineering, Infrastructure, Consulting.'),
                        TextInput::make('link')
                            ->label('External URL')
                            ->maxLength(2048)
                            ->url()
                            ->nullable(),
                        Textarea::make('description')
                            ->rows(5)
                            ->maxLength(65535)
                            ->nullable()
                            ->columnSpanFull(),
                        SpatieMediaLibraryFileUpload::make('image')
                            ->label('Image')
                            ->collection('image')
                            ->image()
                            ->imagePreviewHeight('180')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Publishing')
                    ->schema([
                        TextInput::make('order')
                            ->numeric()
                            ->default(1)
                            ->minValue(1)
                            ->required()
                            ->helperText('Lower numbers appear first.'),
                        Select::make('status')
                            ->options(StatusEnum::class)
                            ->default(StatusEnum::active)
                            ->required(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('image')
                    ->collection('image')
                    ->size(48),
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('type')->badge()->sortable(),
                TextColumn::make('category')->toggleable(),
                TextColumn::make('order')->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (StatusEnum $state): string => match ($state) {
                        StatusEnum::active => 'success',
                        StatusEnum::inactive => 'danger',
                    })
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->reorderable('order')
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                Tables\Filters\SelectFilter::make('type')
                    ->options(EntityTypeEnum::options()),
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
        return [];
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
