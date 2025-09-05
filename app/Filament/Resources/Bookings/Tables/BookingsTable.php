<?php

namespace App\Filament\Resources\Bookings\Tables;

use App\Filament\Exports\BookingExporter;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

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
                //
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
