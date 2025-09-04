<?php

namespace App\Filament\Resources\Terminals\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TerminalForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('airport_id')
                    ->relationship('airport', 'name')
                    ->searchable()
                    ->preload(),

                TextInput::make('name')
                    ->required(),
            ]);
    }
}
