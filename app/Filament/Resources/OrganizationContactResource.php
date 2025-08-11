<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrganizationContactResource\Pages;
use App\Filament\Resources\OrganizationContactResource\RelationManagers;
use App\Models\OrganizationContact;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrganizationContactResource extends Resource
{
    protected static ?string $model = OrganizationContact::class;
    protected static ?string $navigationGroup = 'Setting';
    protected static ?int $navigationSort = 4;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('type')
                    ->label('Contact Type')
                    ->required()
                    ->options([
                        'phone' => 'Phone',
                        'fax' => 'Fax',
                        'email' => 'Email',
                    ]),
                Forms\Components\TextInput::make('value')
                    ->label('Contact Value')
                    ->required()
                    ->maxLength(255),
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('type')
                    ->label('Contact Type')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('value')
                    ->label('Contact Value')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
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
            'index' => Pages\ListOrganizationContacts::route('/'),
            'create' => Pages\CreateOrganizationContact::route('/create'),
            'edit' => Pages\EditOrganizationContact::route('/{record}/edit'),
        ];
    }
}
