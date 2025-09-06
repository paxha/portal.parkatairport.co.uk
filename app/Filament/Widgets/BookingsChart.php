<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Filament\Widgets\ChartWidget;

class BookingsChart extends ChartWidget
{
    protected ?string $heading = 'Bookings Chart';

    protected int|string|array $columnSpan = 'full';

    protected function getData(): array
    {
        $startDate = ! is_null($this->filters['startDate'] ?? null)
            ? Carbon::parse($this->filters['startDate'])->startOfDay()
            : now()->startOfDay();

        $endDate = ! is_null($this->filters['endDate'] ?? null)
            ? Carbon::parse($this->filters['endDate'])->endOfDay()
            : now()->copy()->addMonth()->endOfDay();

        if ($endDate->lt($startDate)) {
            [$startDate, $endDate] = [$endDate->copy()->startOfDay(), $startDate->copy()->endOfDay()];
        }

        // Aggregate departures per calendar date
        $departureMap = Booking::query()
            ->whereBetween('departure', [$startDate, $endDate])
            ->selectRaw('DATE(departure) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date');

        // Aggregate arrivals per calendar date
        $arrivalMap = Booking::query()
            ->whereBetween('arrival', [$startDate, $endDate])
            ->selectRaw('DATE(arrival) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date');

        $labels = [];
        $departureCounts = [];
        $arrivalCounts = [];

        $period = CarbonPeriod::create($startDate->copy()->startOfDay(), $endDate->copy()->startOfDay());

        foreach ($period as $date) {
            $key = $date->toDateString();
            $labels[] = $date->format('d-m-Y');
            $departureCounts[] = (int) ($departureMap[$key] ?? 0);
            $arrivalCounts[] = (int) ($arrivalMap[$key] ?? 0);
        }

        return [
            'datasets' => [
                [
                    'label' => 'Departures',
                    'data' => $departureCounts,
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.2)',
                ],
                [
                    'label' => 'Arrivals',
                    'data' => $arrivalCounts,
                    'borderColor' => '#10b981',
                    'backgroundColor' => 'rgba(16, 185, 129, 0.2)',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
