<?php

namespace App\Filament\Exports;

use App\Enums\BookingStatus;
use App\Models\Booking;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class BookingExporter extends Exporter
{
    protected static ?string $model = Booking::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID')
                ->enabledByDefault(false),
            ExportColumn::make('airport.name')
                ->enabledByDefault(false),
            ExportColumn::make('supplier.name')
                ->enabledByDefault(false),
            ExportColumn::make('service.name')
                ->enabledByDefault(false),
            ExportColumn::make('reference'),
            ExportColumn::make('status')
                ->formatStateUsing(fn (BookingStatus $state): string => $state->getLabel())
                ->enabledByDefault(false),
            ExportColumn::make('name'),
            ExportColumn::make('email')
                ->enabledByDefault(false),
            ExportColumn::make('phone'),
            ExportColumn::make('departure'),
            ExportColumn::make('arrival'),
            ExportColumn::make('departureTerminal.name')
                ->enabledByDefault(false),
            ExportColumn::make('arrivalTerminal.name')
                ->enabledByDefault(false),
            ExportColumn::make('departure_flight_number')
                ->enabledByDefault(false),
            ExportColumn::make('arrival_flight_number')
                ->enabledByDefault(false),
            ExportColumn::make('registration_number'),
            ExportColumn::make('make'),
            ExportColumn::make('model'),
            ExportColumn::make('color'),
            ExportColumn::make('passengers'),
            ExportColumn::make('amount')
                ->enabledByDefault(false),
            ExportColumn::make('supplier_cost')
                ->enabledByDefault(false),
            ExportColumn::make('created_at')
                ->enabledByDefault(false),
            ExportColumn::make('updated_at')
                ->enabledByDefault(false),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your booking export has completed and '.Number::format($export->successful_rows).' '.str('row')->plural($export->successful_rows).' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' '.Number::format($failedRowsCount).' '.str('row')->plural($failedRowsCount).' failed to export.';
        }

        return $body;
    }
}
