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
        $dayImportColumns = [];
        for ($i = 1; $i <= 30; $i++) {
            $dayImportColumns[] = ImportColumn::make("day_$i")
                ->label("Day $i Rate")
                ->exampleHeader("Day $i Rate")
                ->example([45.44 + ($i + 3), 30.44 + ($i + 2.33)])
                ->requiredMapping()
                ->numeric()
                ->rules(['required']);
        }
        $dayImportColumns[] = ImportColumn::make('after_30')
            ->label('After 30 Days Rate')
            ->exampleHeader('After 30 Days Rate')
            ->example([2.22, 1.11])
            ->requiredMapping()
            ->numeric()
            ->rules(['required']);

        return [
            ImportColumn::make('name')
                ->label('Name')
                ->exampleHeader('Name')
                ->example(['A', 'B'])
                ->requiredMapping()
                ->rules(['required', 'max:255']),

            ...$dayImportColumns,
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
        $body = 'Your brand import has completed and '.Number::format($import->successful_rows).' '.str('row')->plural($import->successful_rows).' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' '.Number::format($failedRowsCount).' '.str('row')->plural($failedRowsCount).' failed to import.';
        }

        return $body;
    }
}
