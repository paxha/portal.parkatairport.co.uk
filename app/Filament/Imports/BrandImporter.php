<?php

namespace App\Filament\Imports;

use App\Models\Brand;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Number;

class BrandImporter extends Importer
{
    protected static ?string $model = Brand::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('name')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('day_1')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('day_2')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('day_3')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('day_4')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('day_5')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('day_6')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('day_7')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('day_8')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('day_9')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('day_10')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('day_11')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('day_12')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('day_13')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('day_14')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('day_15')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('day_16')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('day_17')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('day_18')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('day_19')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('day_20')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('day_21')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('day_22')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('day_23')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('day_24')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('day_25')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('day_26')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('day_27')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('day_28')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('day_29')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('day_30')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('after_30')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('active')
                ->requiredMapping()
                ->boolean()
                ->rules(['required', 'boolean']),
        ];
    }

    public function resolveRecord(): Brand
    {
        return Brand::firstOrNew([
            'name' => $this->data['name'],
        ]);
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your brand import has completed and ' . Number::format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
