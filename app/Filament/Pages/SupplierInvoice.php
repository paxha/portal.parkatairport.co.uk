<?php

namespace App\Filament\Pages;

use App\Models\Supplier;
use App\Filament\Exports\SupplierInvoiceExporter;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\ExportAction;
use Filament\Actions\ExportBulkAction;
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
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\BulkAction;
use Filament\Actions\Exports\Models\Export as ExportModel;
use Filament\Notifications\Notification;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Flex;
use Filament\Schemas\Components\Utilities\Get;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class SupplierInvoice extends Page implements HasActions, HasSchemas, HasTable
{
    use InteractsWithActions, InteractsWithSchemas, InteractsWithTable;

    protected string $view = 'filament.pages.supplier-invoice';

    protected ?string $currentFromDate = null;
    protected ?string $currentToDate = null;

    public function table(Table $table): Table
    {
        return $table
            ->query(function () use ($table) {
                $fromState = $table->getFilter('from_date')?->getState();
                $toState = $table->getFilter('to_date')?->getState();
                $fromDate = is_array($fromState) ? ($fromState['from_date'] ?? null) : $fromState;
                $toDate = is_array($toState) ? ($toState['to_date'] ?? null) : $toState;
                $this->currentFromDate = $fromDate;
                $this->currentToDate = $toDate;

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
            ->paginated(false)
            // Replace row actions with header & bulk actions
            ->headerActions([
                ExportAction::make('export_all')
                    ->label('Export All')
                    ->exporter(SupplierInvoiceExporter::class)
                    ->columnMappingColumns(2),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    ExportBulkAction::make()
                        ->label('Export Excel')
                        ->exporter(SupplierInvoiceExporter::class)
                        ->columnMappingColumns(2),
                    BulkAction::make('export_pdf')
                        ->label('Export PDF')
                        ->icon('heroicon-o-arrow-down-tray')
                        ->color('gray')
                        ->schema(function (): array {
                            return [
                                Fieldset::make('Columns')
                                    ->schema(function (): array {
                                        return array_map(
                                            fn ($column): Flex => Flex::make([
                                                Checkbox::make('isEnabled')
                                                    ->hiddenLabel()
                                                    ->default($column->isEnabledByDefault())
                                                    ->live()
                                                    ->grow(false),
                                                TextInput::make('label')
                                                    ->hiddenLabel()
                                                    ->default($column->getLabel())
                                                    ->placeholder($column->getLabel())
                                                    ->disabled(fn (Get $get): bool => ! $get('isEnabled'))
                                                    ->required(fn (Get $get): bool => (bool) $get('isEnabled')),
                                            ])
                                                ->verticallyAlignCenter()
                                                ->statePath($column->getName()),
                                            SupplierInvoiceExporter::getColumns(),
                                        );
                                    })
                                    ->statePath('columnMap'),
                            ];
                        })
                        ->action(function (array $data, $livewire, ?EloquentCollection $records, ?Builder $recordsQuery) {
                            // Load records: selected or all filtered
                            if ($records && $records->isNotEmpty()) {
                                $suppliers = $records; // already hydrated with subselect columns
                            } else {
                                $query = method_exists($livewire, 'getTableQueryForExport') ? $livewire->getTableQueryForExport() : Supplier::query();
                                $suppliers = $query->get();
                            }

                            if ($suppliers->isEmpty()) {
                                Notification::make()->title('No supplier invoices to export')->warning()->send();
                                return null;
                            }

                            // Build column map from form data; fallback to all columns if none explicitly selected
                            $columnMap = collect($data['columnMap'] ?? [])
                                ->filter(fn (array $col): bool => (bool) ($col['isEnabled'] ?? false))
                                ->mapWithKeys(fn (array $col, string $name): array => [$name => $col['label'] ?? $name])
                                ->all();
                            if (empty($columnMap)) {
                                $columnMap = collect(SupplierInvoiceExporter::getColumns())
                                    ->mapWithKeys(fn ($col) => [$col->getName() => $col->getLabel()])
                                    ->all();
                            }

                            $exportModel = app(ExportModel::class);
                            $exportModel->exporter = SupplierInvoiceExporter::class;
                            $exporter = $exportModel->getExporter(columnMap: $columnMap, options: []);

                            $headers = array_values($columnMap);
                            $rows = [];
                            foreach ($suppliers as $supplier) {
                                $rows[] = $exporter($supplier);
                            }

                            // Build summary row aligned to selected columns
                            $countSuppliers = $suppliers->count();
                            $sumTotalBookings = $suppliers->sum('total_bookings');
                            $sumTotalAmount = $suppliers->sum('total_amount');
                            $sumSupplierCost = $suppliers->sum('supplier_cost');
                            $sumPayableAmount = $suppliers->sum('payable_amount');

                            $columnNames = array_keys($columnMap); // preserve order matching headers
                            $summaryRow = [];
                            foreach ($columnNames as $col) {
                                switch ($col) {
                                    case 'name':
                                        $summaryRow[] = 'Totals ('.$countSuppliers.')';
                                        break;
                                    case 'total_bookings':
                                        $summaryRow[] = (string) $sumTotalBookings;
                                        break;
                                    case 'total_amount':
                                        $summaryRow[] = number_format((float) $sumTotalAmount, 2, '.', '');
                                        break;
                                    case 'supplier_cost':
                                        $summaryRow[] = number_format((float) $sumSupplierCost, 2, '.', '');
                                        break;
                                    case 'payable_amount':
                                        $summaryRow[] = number_format((float) $sumPayableAmount, 2, '.', '');
                                        break;
                                    default:
                                        $summaryRow[] = '';
                                }
                            }

                            $generatedAt = now();
                            $cols = count($headers);
                            $paper = $cols <= 8 ? 'a4' : ($cols <= 14 ? 'a3' : 'a2');

                            $dateRangeDisplay = 'All Dates';
                            if ($this->currentFromDate && $this->currentToDate) {
                                $dateRangeDisplay = $this->currentFromDate.' to '.$this->currentToDate;
                            } elseif ($this->currentFromDate) {
                                $dateRangeDisplay = 'From '.$this->currentFromDate;
                            } elseif ($this->currentToDate) {
                                $dateRangeDisplay = 'Until '.$this->currentToDate;
                            }

                            $pdf = Pdf::loadView('exports.supplier-invoices-pdf', [
                                'title' => 'Supplier Invoices Export',
                                'generatedAt' => $generatedAt,
                                'headers' => $headers,
                                'rows' => $rows,
                                'summaryRow' => $summaryRow,
                                'paper' => strtoupper($paper),
                                'dateRange' => $dateRangeDisplay,
                            ])->setPaper($paper, 'landscape');

                            return response()->streamDownload(static function () use ($pdf): void {
                                echo $pdf->output();
                            }, 'supplier-invoices-'.$generatedAt->format('Y-m-d_H-i').'.pdf', ['Content-Type' => 'application/pdf']);
                        })
                        ->deselectRecordsAfterCompletion(),
                ]),
            ]);
    }
}
