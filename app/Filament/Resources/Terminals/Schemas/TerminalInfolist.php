<?php

namespace App\Filament\Resources\Terminals\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class TerminalInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('airport.name'),
                TextEntry::make('name'),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
