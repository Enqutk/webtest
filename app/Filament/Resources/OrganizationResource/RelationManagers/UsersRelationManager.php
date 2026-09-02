<?php

namespace App\Filament\Resources\OrganizationResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class UsersRelationManager extends RelationManager
{
    protected static string $relationship = 'users';

    protected static ?string $title = 'Organization Members & Staff';

    protected static ?string $icon = 'heroicon-o-users';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('role')
                    ->label('Organization Role')
                    ->options([
                        'owner' => '👑 Owner (Full Control)',
                        'admin' => '🛡️ Admin (Management Access)',
                        'editor' => '✏️ Editor (Content Only)',
                        'viewer' => '👁️ Viewer (Read Only)',
                    ])
                    ->default('admin')
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Member Name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email Address')
                    ->searchable()
                    ->copyable(),
                Tables\Columns\TextColumn::make('pivot.role')
                    ->label('Organization Role')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'owner' => 'warning',
                        'admin' => 'success',
                        'editor' => 'info',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),
                Tables\Columns\TextColumn::make('pivot.created_at')
                    ->label('Joined Date')
                    ->dateTime('M d, Y')
                    ->sortable(),
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->label('Add Existing User')
                    ->form(fn (Tables\Actions\AttachAction $action): array => [
                        $action->getRecordSelect(),
                        Forms\Components\Select::make('role')
                            ->label('Role in this Organization')
                            ->options([
                                'owner' => '👑 Owner',
                                'admin' => '🛡️ Admin',
                                'editor' => '✏️ Editor',
                                'viewer' => '👁️ Viewer',
                            ])
                            ->default('admin')
                            ->required(),
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Change Role')
                    ->form([
                        Forms\Components\Select::make('role')
                            ->label('Organization Role')
                            ->options([
                                'owner' => '👑 Owner',
                                'admin' => '🛡️ Admin',
                                'editor' => '✏️ Editor',
                                'viewer' => '👁️ Viewer',
                            ])
                            ->required(),
                    ]),
                Tables\Actions\DetachAction::make()
                    ->label('Remove Access'),
            ]);
    }
}
