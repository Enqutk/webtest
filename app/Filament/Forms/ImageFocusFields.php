<?php

namespace App\Filament\Forms;

use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;

class ImageFocusFields
{
    /** @return array<int, Grid> */
    public static function pair(string $prefix = '', ?string $label = null): array
    {
        $xField = $prefix === '' ? 'image_focus_x' : "{$prefix}_image_focus_x";
        $yField = $prefix === '' ? 'image_focus_y' : "{$prefix}_image_focus_y";
        $heading = $label ?? ($prefix === 'secondary' ? 'Detail image crop focus' : 'Photo crop focus');

        return [
            Grid::make(2)
                ->schema([
                    TextInput::make($xField)
                        ->label("{$heading} (horizontal)")
                        ->numeric()
                        ->minValue(0)
                        ->maxValue(100)
                        ->default(50)
                        ->suffix('%'),
                    TextInput::make($yField)
                        ->label("{$heading} (vertical)")
                        ->numeric()
                        ->minValue(0)
                        ->maxValue(100)
                        ->default(50)
                        ->suffix('%')
                        ->helperText('Lower values keep the top of portrait photos visible. Try 20–35 for headshots.'),
                ])
                ->columnSpanFull(),
        ];
    }
}
