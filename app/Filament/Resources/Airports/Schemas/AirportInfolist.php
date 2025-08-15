<?php

namespace App\Filament\Resources\Airports\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class AirportInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('code'),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
