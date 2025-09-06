<?php

namespace App\Filament\Pages;

use App\Models\Supplier;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\DatePicker;
use Filament\Pages\Page;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class SupplierInvoice extends Page implements HasActions, HasSchemas, HasTable
{
    use InteractsWithActions, InteractsWithSchemas, InteractsWithTable;

    protected string $view = 'filament.pages.supplier-invoice';

    public function table(Table $table): Table
    {
        return $table
            ->query(function () use ($table) {
                $fromState = $table->getFilter('from_date')?->getState();
                $toState = $table->getFilter('to_date')?->getState();
                $fromDate = is_array($fromState) ? ($fromState['from_date'] ?? null) : $fromState;
                $toDate = is_array($toState) ? ($toState['to_date'] ?? null) : $toState;

                $query = Supplier::query()->select('suppliers.*');

                // total_bookings
                $query->selectSub(function ($sub) use ($fromDate, $toDate) {
                    $sub->from('bookings')
                        ->selectRaw('COUNT(*)')
                        ->whereColumn('bookings.supplier_id', 'suppliers.id');
                    if ($fromDate) { $sub->whereDate('bookings.created_at', '>=', $fromDate); }
                    if ($toDate) { $sub->whereDate('bookings.created_at', '<=', $toDate); }
                }, 'total_bookings');
                // total_amount
                $query->selectSub(function ($sub) use ($fromDate, $toDate) {
                    $sub->from('bookings')
                        ->selectRaw('COALESCE(SUM(amount),0)')
                        ->whereColumn('bookings.supplier_id', 'suppliers.id');
                    if ($fromDate) { $sub->whereDate('bookings.created_at', '>=', $fromDate); }
                    if ($toDate) { $sub->whereDate('bookings.created_at', '<=', $toDate); }
                }, 'total_amount');
                // supplier_cost
                $query->selectSub(function ($sub) use ($fromDate, $toDate) {
                    $sub->from('bookings')
                        ->selectRaw('COALESCE(SUM(supplier_cost),0)')
                        ->whereColumn('bookings.supplier_id', 'suppliers.id');
                    if ($fromDate) { $sub->whereDate('bookings.created_at', '>=', $fromDate); }
                    if ($toDate) { $sub->whereDate('bookings.created_at', '<=', $toDate); }
                }, 'supplier_cost');
                // payable_amount (recompute expression so summarizer can work directly on column)
                $query->selectSub(function ($sub) use ($fromDate, $toDate) {
                    $sub->from('bookings')
                        ->selectRaw('COALESCE(SUM(amount),0) - COALESCE(SUM(supplier_cost),0)')
                        ->whereColumn('bookings.supplier_id', 'suppliers.id');
                    if ($fromDate) { $sub->whereDate('bookings.created_at', '>=', $fromDate); }
                    if ($toDate) { $sub->whereDate('bookings.created_at', '<=', $toDate); }
                }, 'payable_amount');

                // filter out suppliers without bookings in range
                $query->whereExists(function ($sub) use ($fromDate, $toDate) {
                    $sub->selectRaw('1')
                        ->from('bookings')
                        ->whereColumn('bookings.supplier_id', 'suppliers.id');
                    if ($fromDate) { $sub->whereDate('bookings.created_at', '>=', $fromDate); }
                    if ($toDate) { $sub->whereDate('bookings.created_at', '<=', $toDate); }
                });

                return $query;
            })
            ->columns([
                TextColumn::make('name')
                    ->label('Supplier Name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('total_bookings')
                    ->label('Total Bookings')
                    ->summarize(Sum::make()->label(''))
                    ->sortable(),
                TextColumn::make('total_amount')
                    ->label('Total Amount')
                    ->money('GBP')
                    ->summarize(Sum::make()->label('')->money('GBP'))
                    ->sortable(),
                TextColumn::make('supplier_cost')
                    ->label('Supplier Cost')
                    ->money('GBP')
                    ->summarize(Sum::make()->label('')->money('GBP'))
                    ->sortable(),
                TextColumn::make('payable_amount')
                    ->label('Payable Amount')
                    ->money('GBP')
                    ->summarize(Sum::make()->label('')->money('GBP'))
                    ->sortable(),
            ])
            ->defaultSort('total_bookings', 'desc')
            ->filters([
                SelectFilter::make('suppliers')
                    ->label('Supplier')
                    ->options(fn() => Supplier::query()->orderBy('name')->pluck('name', 'id')->toArray())
                    ->multiple()
                    ->searchable()
                    ->preload()
                    ->columnSpan(2)
                    ->query(function (Builder $query, array $state) {
                        $raw = $state['values'] ?? $state; // Filament supplies ['values'=>[]] for multiple
                        if (!is_array($raw)) {
                            $raw = [$raw];
                        }
                        $ids = array_values(array_unique(array_filter(array_map(static fn($v) => (int)$v, $raw), static fn($v) => $v > 0)));
                        if ($ids) {
                            $query->whereIn('suppliers.id', $ids);
                        }
                        return $query;
                    }),
                Filter::make('from_date')
                    ->schema([
                        DatePicker::make('from_date')->label('From Date'),
                    ]),
                Filter::make('to_date')
                    ->schema([
                        DatePicker::make('to_date')->label('To Date'),
                    ]),
            ])
            ->filtersLayout(FiltersLayout::AboveContent)
            ->paginated(false);
    }
}
