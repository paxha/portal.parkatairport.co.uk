<?php

namespace App\Filament\Resources\Terminals\Pages;

use App\Filament\Resources\Terminals\TerminalResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTerminal extends CreateRecord
{
    protected static string $resource = TerminalResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
