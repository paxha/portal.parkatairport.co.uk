<?php

namespace App\Filament\Resources\Brands\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BrandForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make()
                    ->schema([
                        TextInput::make('name')
                            ->required(),
                        Grid::make(6)
                            ->schema([
                                ...collect(range(start: 1, end: 30))->map(function ($day) {
                                    return TextInput::make("day_$day")
                                        ->numeric()
                                        ->prefix('£')
                                        ->required();
                                })->toArray(),
                                TextInput::make('after_30')
                                    ->numeric()
                                    ->prefix('£')
                                    ->required(),
                            ])
                            ->columnSpanFull(),

                        Toggle::make('active')
                            ->required(),
                    ])
                    ->columns()
                    ->columnSpanFull(),
            ]);
    }
}
