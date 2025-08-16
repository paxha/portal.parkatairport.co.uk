<?php

namespace App\Filament\Resources\Brands\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class BrandInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextEntry::make('name'),
                Grid::make(6)
                    ->schema([
                        ...collect(range(start: 1, end: 30))->map(function ($day) {
                            return TextEntry::make("day_$day")
                                ->numeric()
                                ->prefix('£');
                        })->toArray(),
                        TextEntry::make('after_30')
                            ->numeric()
                            ->prefix('£'),

                    ])
                    ->columnSpanFull(),

                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),

            ]);

    }
}
