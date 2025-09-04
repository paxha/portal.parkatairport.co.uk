<?php

namespace App\Filament\Imports;

use App\Models\Service;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Number;

class ServiceImporter extends Importer
{
    protected static ?string $model = Service::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('name')
                ->label('Name')
                ->exampleHeader('Name')
                ->example('Park and Ride')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('description')
                ->label('Description')
                ->exampleHeader('Description')
                ->example('lorem ipsum dolor sit amet, consectetur adipiscing elit.')
                ->requiredMapping()
                ->rules(['nullable', 'max:255']),
            ImportColumn::make('badge')
                ->label('Badge')
                ->exampleHeader('Badge')
                ->example('Most Popular')
                ->requiredMapping()
                ->rules(['nullable', 'max:255']),
            ImportColumn::make('features')
                ->label('Features')
                ->exampleHeader('Features')
                ->example('Lorem ipsum dolor sit amet, consectetur adipiscing elit.')
                ->requiredMapping()
                ->rules(['nullable', 'max:255']),
        ];
    }

    public function resolveRecord(): Service
    {
        return Service::firstOrNew([
            'name' => $this->data['name'],
        ]);
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your service import has completed and '.Number::format($import->successful_rows).' '.str('row')->plural($import->successful_rows).' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' '.Number::format($failedRowsCount).' '.str('row')->plural($failedRowsCount).' failed to import.';
        }

        return $body;
    }
}
