<?php

namespace App\Filament\Imports;

use App\Models\Supplier;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Number;

class SupplierImporter extends Importer
{
    protected static ?string $model = Supplier::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('airport')
                ->relationship('airport', 'code')
                ->label('Airport')
                ->exampleHeader('Airport')
                ->example('LHE')
                ->requiredMapping()
                ->rules(['required']),
            ImportColumn::make('name')
                ->label('Name')
                ->exampleHeader('Name')
                ->example('Looking 4 Parking')
                ->requiredMapping()
                ->rules(['required']),
            ImportColumn::make('code')
                ->label('Code')
                ->exampleHeader('Code')
                ->example('L4P')
                ->requiredMapping()
                ->rules(['required']),
            ImportColumn::make('email')
                ->label('Email')
                ->exampleHeader('Email')
                ->example('reports@looking4.com')
                ->requiredMapping()
                ->rules(['required', 'email']),
            ImportColumn::make('phone')
                ->label('Phone')
                ->exampleHeader('Phone')
                ->example('123-456-7890')
                ->requiredMapping(),
            ImportColumn::make('postal_code')
                ->label('Postal Code')
                ->exampleHeader('Postal Code')
                ->example('12345')
                ->requiredMapping(),
            ImportColumn::make('address')
                ->label('Address')
                ->exampleHeader('Address')
                ->example('Dummy Address'),
            ImportColumn::make('commission')
                ->label('Commission')
                ->exampleHeader('Commission')
                ->example(20)
                ->requiredMapping()
                ->numeric()
                ->rules(['required']),
        ];
    }

    public function resolveRecord(): Supplier
    {
        return Supplier::firstOrNew([
            'email' => $this->data['email'],
        ]);
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your supplier import has completed and '.Number::format($import->successful_rows).' '.str('row')->plural($import->successful_rows).' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' '.Number::format($failedRowsCount).' '.str('row')->plural($failedRowsCount).' failed to import.';
        }

        return $body;
    }
}
