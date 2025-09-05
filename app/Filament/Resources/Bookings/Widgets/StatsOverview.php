<?php

namespace App\Filament\Resources\Bookings\Widgets;

use App\Enums\BookingStatus;
use App\Models\Booking;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $today = Carbon::today();
        $dates = collect(range(0, 6))
            ->map(fn ($i) => $today->copy()->subDays(6 - $i));

        $departureChart = $dates->map(fn ($date) => Booking::whereDate('departure', $date)->count())->toArray();

        $arrivalChart = $dates->map(fn ($date) => Booking::whereDate('arrival', $date)->count())->toArray();

        $today = Carbon::today();
        $yesterday = $today->copy()->subDay();

        $todayDepartures = Booking::whereDate('departure', $today)->count();

        $yesterdayDepartures = Booking::whereDate('departure', $yesterday)->count();

        $departureDiff = $todayDepartures - $yesterdayDepartures;
        $departureIcon = $departureDiff >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down';
        $departureColor = $departureDiff >= 0 ? 'success' : 'danger';
        $departureDesc = abs($departureDiff).($departureDiff >= 0 ? ' increase' : ' decrease');

        $todayArrivals = Booking::whereDate('arrival', $today)->count();

        $yesterdayArrivals = Booking::whereDate('arrival', $yesterday)->count();

        $arrivalDiff = $todayArrivals - $yesterdayArrivals;
        $arrivalIcon = $arrivalDiff >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down';
        $arrivalColor = $arrivalDiff >= 0 ? 'success' : 'danger';
        $arrivalDesc = abs($arrivalDiff).($arrivalDiff >= 0 ? ' increase' : ' decrease');

        $upcomingDepartures = Booking::where('status', BookingStatus::Confirmed->value)
            ->whereDate('departure', '>', today())
            ->count();

        return [
            Stat::make('Today\'s Departures', $todayDepartures)
                ->description($departureDesc)
                ->descriptionIcon($departureIcon)
                ->color($departureColor)
                ->chart($departureChart),
            Stat::make('Today\'s Arrivals', $todayArrivals)
                ->description($arrivalDesc)
                ->descriptionIcon($arrivalIcon)
                ->color($arrivalColor)
                ->chart($arrivalChart),
            Stat::make('Upcoming Departures', $upcomingDepartures)
                ->description('All future departures')
                ->color('primary'),
        ];
    }
}
