<?php

namespace App\Filament\Imports;

use App\Models\BrandPrice;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Number;

class BrandPriceImporter extends Importer
{
    protected static ?string $model = BrandPrice::class;

    public static function getColumns(): array
    {
        $brandImportColumns = [];
        for ($i = 1; $i <= 31; $i++) {
            $brandImportColumns[] = ImportColumn::make("day_$i")
                ->relationship("day{$i}Brand", resolveUsing: 'name')
                ->example(['A', 'B'])
                ->label("Day $i Brand Name")
                ->exampleHeader("Day $i Brand Name");
        }

        return [
            ImportColumn::make('service')
                ->relationship(resolveUsing: 'name')
                ->requiredMapping()
                ->rules(['required'])
                ->example(['Park and Ride', 'Meet and Greet'])
                ->label('Service Name')
                ->exampleHeader('Service Name'),

            ImportColumn::make('month')
                ->requiredMapping()
                ->integer()
                ->rules(['required', 'integer', 'min:1', 'max:12'])
                ->example([7, 8])
                ->label('Month')
                ->exampleHeader('Month'),

            ImportColumn::make('year')
                ->requiredMapping()
                ->integer()
                ->rules(['required', 'integer', 'min:2020', 'max:2030'])
                ->example([2025, 2025])
                ->label('Year')
                ->exampleHeader('Year'),

            ...$brandImportColumns,
        ];
    }

    public function resolveRecord(): ?BrandPrice
    {
        // Find existing record by product, month and year. The `product` column
        // will be cast to either a Product model or its id depending on the
        // ImportColumn configuration; normalize both cases.
        $serviceValue = $this->data['service'] ?? null;

        if (is_object($serviceValue) && method_exists($serviceValue, 'getKey')) {
            $serviceId = $serviceValue->getKey();
        } else {
            $serviceId = $serviceValue;
        }

        if (! $serviceId || ! isset($this->data['month']) || ! isset($this->data['year'])) {
            return null;
        }

        return BrandPrice::firstOrNew([
            'service_id' => $serviceId,
            'month' => $this->data['month'],
            'year' => $this->data['year'],
        ]);
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your brand price import has completed and '.Number::format($import->successful_rows).' '.str('row')->plural($import->successful_rows).' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' '.Number::format($failedRowsCount).' '.str('row')->plural($failedRowsCount).' failed to import.';
        }

        return $body;
    }
}
