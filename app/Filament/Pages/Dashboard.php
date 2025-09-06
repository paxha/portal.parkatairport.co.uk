<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\DatePicker;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class Dashboard extends BaseDashboard
{
    use BaseDashboard\Concerns\HasFiltersForm;

    public function filtersForm(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make()
                    ->schema([
                        DatePicker::make('startDate')
                            ->default(now()),
                        DatePicker::make('endDate')
                            ->default(now()->addMonth())
                            ->minDate(fn (Get $get) => $get('startDate') ?: now()),
                    ])
                    ->columns()
                    ->columnSpanFull(),
            ]);
    }
}
