<?php

namespace App\Filament\Exports;

use App\Models\BrandPrice;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class BrandPriceExporter extends Exporter
{
    protected static ?string $model = BrandPrice::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('service.name'),
            ExportColumn::make('month'),
            ExportColumn::make('year'),
            ExportColumn::make('day_1'),
            ExportColumn::make('day_2'),
            ExportColumn::make('day_3'),
            ExportColumn::make('day_4'),
            ExportColumn::make('day_5'),
            ExportColumn::make('day_6'),
            ExportColumn::make('day_7'),
            ExportColumn::make('day_8'),
            ExportColumn::make('day_9'),
            ExportColumn::make('day_10'),
            ExportColumn::make('day_11'),
            ExportColumn::make('day_12'),
            ExportColumn::make('day_13'),
            ExportColumn::make('day_14'),
            ExportColumn::make('day_15'),
            ExportColumn::make('day_16'),
            ExportColumn::make('day_17'),
            ExportColumn::make('day_18'),
            ExportColumn::make('day_19'),
            ExportColumn::make('day_20'),
            ExportColumn::make('day_21'),
            ExportColumn::make('day_22'),
            ExportColumn::make('day_23'),
            ExportColumn::make('day_24'),
            ExportColumn::make('day_25'),
            ExportColumn::make('day_26'),
            ExportColumn::make('day_27'),
            ExportColumn::make('day_28'),
            ExportColumn::make('day_29'),
            ExportColumn::make('day_30'),
            ExportColumn::make('day_31'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your brand price export has completed and ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
