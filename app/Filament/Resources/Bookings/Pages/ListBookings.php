<?php

namespace App\Filament\Resources\Bookings\Pages;

use App\Filament\Resources\Bookings\BookingResource;
use App\Models\Booking;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;

class ListBookings extends ListRecords
{
    protected static string $resource = BookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return BookingResource::getWidgets();
    }

    public function getTabs(): array
    {
        return [
            Tab::make('All'),
            Tab::make('Today\'s Departures')
                ->query(fn ($query) => $query->whereDate('departure', today())->orderBy('departure'))
                ->badge(fn () => Booking::query()->whereDate('departure', today())->count()),
            Tab::make('Today\'s Arrivals')
                ->query(fn ($query) => $query->whereDate('arrival', today())->orderBy('arrival'))
                ->badge(fn () => Booking::query()->whereDate('arrival', today())->count()),
        ];
    }
}
