<?php

namespace App\Filament\Imports;

use App\Models\Airport;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Number;

class AirportImporter extends Importer
{
    protected static ?string $model = Airport::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('name')
                ->label('Name')
                ->exampleHeader('Name')
                ->example('Hethrow')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('code')
                ->label('Code')
                ->exampleHeader('Code')
                ->example('LHE')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
        ];
    }

    public function resolveRecord(): Airport
    {
        return Airport::firstOrNew([
            'name' => $this->data['name'],
        ]);
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your airport import has completed and ' . Number::format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
