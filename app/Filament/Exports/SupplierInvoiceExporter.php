<?php

namespace App\Filament\Exports;

use App\Models\Supplier;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class SupplierInvoiceExporter extends Exporter
{
    protected static ?string $model = Supplier::class;

    /**
     * @return array<int, ExportColumn>
     */
    public static function getColumns(): array
    {
        return [
            ExportColumn::make('name')->label('Supplier Name'),
            ExportColumn::make('total_bookings')->label('Total Bookings'),
            ExportColumn::make('total_amount')->label('Total Amount'),
            ExportColumn::make('supplier_cost')->label('Supplier Cost'),
            ExportColumn::make('payable_amount')->label('Payable Amount'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        return 'Supplier invoices export completed successfully.';
    }
}

