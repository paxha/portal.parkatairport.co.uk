<?php

namespace App\Filament\Resources\BrandPrices\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class BrandPriceInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('service.name')
                    ->numeric(),
                TextEntry::make('month')
                    ->numeric(),
                TextEntry::make('year')
                    ->numeric(),
                TextEntry::make('day_1')
                    ->numeric(),
                TextEntry::make('day_2')
                    ->numeric(),
                TextEntry::make('day_3')
                    ->numeric(),
                TextEntry::make('day_4')
                    ->numeric(),
                TextEntry::make('day_5')
                    ->numeric(),
                TextEntry::make('day_6')
                    ->numeric(),
                TextEntry::make('day_7')
                    ->numeric(),
                TextEntry::make('day_8')
                    ->numeric(),
                TextEntry::make('day_9')
                    ->numeric(),
                TextEntry::make('day_10')
                    ->numeric(),
                TextEntry::make('day_11')
                    ->numeric(),
                TextEntry::make('day_12')
                    ->numeric(),
                TextEntry::make('day_13')
                    ->numeric(),
                TextEntry::make('day_14')
                    ->numeric(),
                TextEntry::make('day_15')
                    ->numeric(),
                TextEntry::make('day_16')
                    ->numeric(),
                TextEntry::make('day_17')
                    ->numeric(),
                TextEntry::make('day_18')
                    ->numeric(),
                TextEntry::make('day_19')
                    ->numeric(),
                TextEntry::make('day_20')
                    ->numeric(),
                TextEntry::make('day_21')
                    ->numeric(),
                TextEntry::make('day_22')
                    ->numeric(),
                TextEntry::make('day_23')
                    ->numeric(),
                TextEntry::make('day_24')
                    ->numeric(),
                TextEntry::make('day_25')
                    ->numeric(),
                TextEntry::make('day_26')
                    ->numeric(),
                TextEntry::make('day_27')
                    ->numeric(),
                TextEntry::make('day_28')
                    ->numeric(),
                TextEntry::make('day_29')
                    ->numeric(),
                TextEntry::make('day_30')
                    ->numeric(),
                TextEntry::make('day_31')
                    ->numeric(),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
