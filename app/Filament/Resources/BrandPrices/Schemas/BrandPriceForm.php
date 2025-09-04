<?php

namespace App\Filament\Resources\BrandPrices\Schemas;

use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class BrandPriceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make()
                    ->schema([
                        Grid::make()
                            ->schema([
                                Select::make('service_id')
                                    ->relationship('service', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                                Grid::make()
                                ->schema([
                                    Select::make('month')
                                    ->options([
                                        1 => 'January',
                                        2 => 'February',
                                        3 => 'March',
                                        4 => 'April',
                                        5 => 'May',
                                        6 => 'June',
                                        7 => 'July',
                                        8 => 'August',
                                        9 => 'September',
                                        10 => 'October',
                                        11 => 'November',
                                        12 => 'December',
                                    ])
                                    ->required()
                                    ->searchable()
                                    ->preload()
                                    ->reactive(),
                                Select::make('year')
                                    ->options(
                                        collect(range(date('Y'), (int) date('Y') + 10))
                                            ->mapWithKeys(fn($year) => [$year => $year])
                                            ->toArray()
                                    )
                                    ->required()
                                    ->searchable()
                                    ->preload()
                                    ->reactive(),
                                    ])
                                    ->columnSpanFull(),
                            ])
                            ->columnSpanFull(),
                        Grid::make(5)
                            ->schema([
                                ...collect(range(1, 31))->map(function ($day) {
                                    return Select::make("day_$day")
                                        ->label("Day $day")
                                        ->relationship("day{$day}Brand", 'name')
                                        ->required()
                                        ->visible(function ($get) use ($day) {
                                            $month = $get('month');
                                            $year = $get('year');
                                            if (! $month || ! $year) {
                                                return false;
                                            }
                                            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

                                            return $day <= $daysInMonth;
                                        });
                                })->toArray(),

                            ])
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
