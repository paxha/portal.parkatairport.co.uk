<?php

namespace App\Filament\Resources\Bookings\Tables;

use App\Enums\BookingStatus;
use App\Filament\Exports\BookingExporter;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportBulkAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class BookingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('reference')
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Customer')
                    ->searchable(),
                TextColumn::make('departure')
                    ->dateTime('M d, Y H:i'),
                TextColumn::make('arrival')
                    ->dateTime('M d, Y H:i'),
                TextColumn::make('amount'),
                TextColumn::make('amount')
                    ->money('GBP')
                    ->summarize(Sum::make()->label('Total')->money('GBP')),
                TextColumn::make('status')
                    ->badge(),
                TextColumn::make('created_at')
                    ->dateTime('M d, Y H:i')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime('M d, Y H:i')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
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
                    ->schema([
                        DateTimePicker::make('from')->label('Departure From'),
                        DateTimePicker::make('until')->label('Departure Until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['from'] ?? null,
                                fn(Builder $q, string $date): Builder => $q->where('departure', '>=', $date),
                            )
                            ->when(
                                $data['until'] ?? null,
                                fn(Builder $q, string $date): Builder => $q->where('departure', '<=', $date),
                            );
                    }),
                Filter::make('arrival')
                    ->label('Arrival')
                    ->schema([
                        DateTimePicker::make('from')->label('Arrival From'),
                        DateTimePicker::make('until')->label('Arrival Until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['from'] ?? null,
                                fn(Builder $q, string $date): Builder => $q->where('arrival', '>=', $date),
                            )
                            ->when(
                                $data['until'] ?? null,
                                fn(Builder $q, string $date): Builder => $q->where('arrival', '<=', $date),
                            );
                    }),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ExportBulkAction::make()
                        ->exporter(BookingExporter::class),
                ]),
            ]);
    }
}
