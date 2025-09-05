<?php

namespace App\Filament\Resources\BrandPrices\Tables;

use App\Filament\Exports\BrandPriceExporter;
use App\Filament\Imports\BrandPriceImporter;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportBulkAction;
use Filament\Actions\ImportAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\RecordActionsPosition;
use Filament\Tables\Table;

class BrandPricesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('service.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('month')
                    ->label('Month')
                    ->formatStateUsing(fn ($state) => [
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
                    ][$state] ?? $state)
                    ->sortable(),
                TextColumn::make('year')
                    ->sortable(),
                ...collect(range(1, 31))->map(function ($day) {
                    return TextColumn::make("day{$day}Brand.name")
                        ->label("Day $day");
                })->toArray(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->headerActions([
                ImportAction::make()
                    ->importer(BrandPriceImporter::class),
            ])
            ->recordActionsPosition(RecordActionsPosition::BeforeCells)
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
                        ->exporter(BrandPriceExporter::class),
                ]),
            ]);
    }
}
