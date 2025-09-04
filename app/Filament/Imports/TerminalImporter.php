<?php

namespace App\Filament\Imports;

use App\Models\Terminal;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Number;

class TerminalImporter extends Importer
{
    protected static ?string $model = Terminal::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('airport')
                ->relationship('airport', 'code')
                ->label('Airport Code')
                ->exampleHeader('Airport Code')
                ->example(['LHE', 'LHE', 'LHE', 'LHE'])
                ->requiredMapping()
                ->rules(['required', 'string', 'max:255']),
            ImportColumn::make('name')
                ->label('Terminal Name')
                ->exampleHeader('Terminal Name')
                ->example(['Terminal 2', 'Terminal 3', 'Terminal 4', 'Terminal 5'])
                ->requiredMapping()
                ->rules(['required', 'string', 'max:255']),
        ];
    }

    public function resolveRecord(): Terminal
    {
        return new Terminal();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your terminal import has completed and ' . Number::format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
