<?php

namespace App\Filament\Resources\Bookings\Tables;

use App\Enums\BookingStatus;
use App\Filament\Exports\BookingExporter;
use App\Models\Booking;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportBulkAction;
use Filament\Actions\Exports\Models\Export as ExportModel;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Flex;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class BookingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('airport.name')
                    ->label('Airport')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('supplier.name')
                    ->label('Supplier')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('service.name')
                    ->label('Service')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('reference')
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Customer')
                    ->searchable(),
                TextColumn::make('phone')
                    ->label('Phone')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('departure')
                    ->dateTime('M d, Y H:i'),
                TextColumn::make('arrival')
                    ->dateTime('M d, Y H:i'),
                TextColumn::make('departureTerminal.name')
                    ->label('Departure Terminal')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                TextColumn::make('arrivalTerminal.name')
                    ->label('Arrival Terminal')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('departure_flight_number')
                    ->label('Departure Flight Number')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('arrival_flight_number')
                    ->label('Arrival Flight Number')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('registration_number')
                    ->label('Registration Number')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('make')
                    ->label('Make')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('model')
                    ->label('Model')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('color')
                    ->label('Color')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('passengers')
                    ->label('Passengers')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('amount')
                    ->label('Amount')
                    ->money('GBP')
                    ->summarize(Sum::make()->label('Total')->money('GBP')),
                TextColumn::make('supplier_cost')
                    ->label('Supplier Cost')
                    ->money('GBP')
                    ->summarize(Sum::make()->label('Total')->money('GBP'))
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('status')
                    ->badge(),
                TextColumn::make('created_at')
                    ->dateTime('M d, Y H:i')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime('M d, Y H:i')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('id', 'desc')
            ->reorderableColumns()
            ->filters([
                SelectFilter::make('supplier_id')
                    ->label('Supplier')
                    ->relationship('supplier', 'name')
                    ->multiple(),
                SelectFilter::make('status')
                    ->label('Status')
                    ->options(BookingStatus::class)
                    ->multiple(),
                Filter::make('departure')
                    ->label('Departure')
                    ->schema([
                        DatePicker::make('from')->label('Departure From'),
                        DatePicker::make('until')->label('Departure Until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['from'] ?? null, fn (Builder $q, string $date): Builder => $q->whereDate('departure', '>=', $date))
                            ->when($data['until'] ?? null, fn (Builder $q, string $date): Builder => $q->whereDate('departure', '<=', $date));
                    }),
                Filter::make('arrival')
                    ->label('Arrival')
                    ->schema([
                        DatePicker::make('from')->label('Arrival From'),
                        DatePicker::make('until')->label('Arrival Until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['from'] ?? null, fn (Builder $q, string $date): Builder => $q->whereDate('arrival', '>=', $date))
                            ->when($data['until'] ?? null, fn (Builder $q, string $date): Builder => $q->whereDate('arrival', '<=', $date));
                    }),
            ], layout: FiltersLayout::AboveContentCollapsible)
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ExportBulkAction::make()
                        ->label('Export Excel')
                        ->exporter(BookingExporter::class)
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
                                            BookingExporter::getColumns(),
                                        );
                                    })
                                    ->statePath('columnMap'),
                            ];
                        })
                        ->action(function (array $data, $livewire, ?EloquentCollection $records, ?Builder $recordsQuery) {
                            $relations = ['airport', 'supplier', 'service', 'departureTerminal', 'arrivalTerminal'];

                            if ($records && $records->isNotEmpty()) {
                                $bookings = $records->loadMissing($relations);
                            } else {
                                $query = method_exists($livewire, 'getTableQueryForExport') ? $livewire->getTableQueryForExport() : Booking::query();
                                $bookings = $query->with($relations)->get();
                            }

                            if ($bookings->isEmpty()) {
                                Notification::make()->title('No bookings to export')->warning()->send();

                                return null;
                            }

                            // Build column map from form data; fallback to all columns if none selected
                            $columnMap = collect($data['columnMap'] ?? [])
                                ->filter(fn (array $col): bool => (bool) ($col['isEnabled'] ?? false))
                                ->mapWithKeys(fn (array $col, string $name): array => [$name => $col['label'] ?? $name])
                                ->all();

                            if (empty($columnMap)) {
                                $columnMap = collect(BookingExporter::getColumns())
                                    ->mapWithKeys(fn ($col) => [$col->getName() => $col->getLabel()])
                                    ->all();
                            }

                            $exportModel = app(ExportModel::class);
                            $exportModel->exporter = BookingExporter::class;
                            $exporter = $exportModel->getExporter(columnMap: $columnMap, options: []);

                            $headers = array_values($columnMap);
                            $rows = [];
                            foreach ($bookings as $booking) {
                                $rows[] = $exporter($booking);
                            }

                            $generatedAt = now();

                            // Dynamically choose paper size based on number of columns
                            $cols = count($headers);
                            $paper = $cols <= 12 ? 'a4' : ($cols <= 20 ? 'a3' : 'a2');

                            $pdf = Pdf::loadView('exports.bookings-pdf', [
                                'title' => 'Bookings Export',
                                'generatedAt' => $generatedAt,
                                'headers' => $headers,
                                'rows' => $rows,
                                'paper' => strtoupper($paper),
                            ])->setPaper($paper, 'landscape');

                            return response()->streamDownload(static function () use ($pdf): void {
                                echo $pdf->output();
                            }, 'bookings-'.$generatedAt->format('Y-m-d_H-i').'.pdf', ['Content-Type' => 'application/pdf']);
                        })
                        ->deselectRecordsAfterCompletion(),
                ]),
            ]);
    }
}
