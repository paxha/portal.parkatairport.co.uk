<?php

namespace App\Filament\Resources\Bookings\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class BookingInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('airport.name'),
                TextEntry::make('supplier.name'),
                TextEntry::make('service.name'),
                TextEntry::make('reference'),
                TextEntry::make('status')
                    ->badge(),
                TextEntry::make('name'),
                TextEntry::make('email')
                    ->label('Email address'),
                TextEntry::make('phone'),
                TextEntry::make('departure')
                    ->dateTime(),
                TextEntry::make('arrival')
                    ->dateTime(),
                TextEntry::make('departureTerminal.name'),
                TextEntry::make('arrivalTerminal.name'),
                TextEntry::make('departure_flight_number'),
                TextEntry::make('arrival_flight_number'),
                TextEntry::make('registration_number'),
                TextEntry::make('make'),
                TextEntry::make('model'),
                TextEntry::make('color'),
                TextEntry::make('passengers')
                    ->numeric(),
                TextEntry::make('amount')
                    ->numeric(),
                TextEntry::make('supplier_cost')
                    ->numeric(),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
