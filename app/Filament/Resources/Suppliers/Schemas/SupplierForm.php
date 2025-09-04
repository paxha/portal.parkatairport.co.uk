<?php

namespace App\Filament\Resources\Suppliers\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SupplierForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('airport_id')
                    ->relationship('airport', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('code')
                    ->required(),
                TextInput::make('email')
                    ->required(),
                TextInput::make('phone'),
                TextInput::make('postal_code'),
                TextInput::make('address'),
                TextInput::make('commission')
                    ->numeric()
                    ->required(),
            ]);
    }
}
