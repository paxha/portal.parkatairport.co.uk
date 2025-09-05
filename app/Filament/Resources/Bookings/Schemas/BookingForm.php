<?php

namespace App\Filament\Resources\Bookings\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class BookingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('airport_id')
                    ->relationship('airport', 'name')
                    ->required(),
                Select::make('supplier_id')
                    ->relationship('supplier', 'name')
                    ->required(),
                Select::make('service_id')
                    ->relationship('service', 'name')
                    ->required(),
                TextInput::make('reference')
                    ->required(),
                TextInput::make('status')
                    ->required(),
                TextInput::make('name'),
                TextInput::make('email')
                    ->label('Email address')
                    ->email(),
                TextInput::make('phone')
                    ->tel(),
                DateTimePicker::make('departure'),
                DateTimePicker::make('arrival'),
                Select::make('departure_terminal_id')
                    ->relationship('departureTerminal', 'name'),
                Select::make('arrival_terminal_id')
                    ->relationship('arrivalTerminal', 'name'),
                TextInput::make('departure_flight_number'),
                TextInput::make('arrival_flight_number'),
                TextInput::make('registration_number'),
                TextInput::make('make'),
                TextInput::make('model'),
                TextInput::make('color'),
                TextInput::make('passengers')
                    ->numeric(),
                TextInput::make('amount')
                    ->required()
                    ->numeric(),
                TextInput::make('supplier_cost')
                    ->numeric(),
            ]);
    }
}
