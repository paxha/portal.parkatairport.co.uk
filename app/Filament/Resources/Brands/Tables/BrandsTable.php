<?php

namespace App\Filament\Resources\Brands\Tables;

use App\Filament\Exports\BrandExporter;
use App\Filament\Imports\BrandImporter;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportBulkAction;
use Filament\Actions\ImportAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\RecordActionsPosition;
use Filament\Tables\Table;

class BrandsTable
{
    public static function configure(Table $table): Table
    {

        $dayColumns = [];
        for ($i = 1; $i <= 30; $i++) {
            $dayColumns[] = TextColumn::make("day_$i")
                ->numeric()
                ->sortable();
        }
        $dayColumns[] = TextColumn::make('after_30')
            ->numeric()
            ->sortable();

        return $table
            ->columns([
                IconColumn::make('active')->boolean(),
                TextColumn::make('name')->searchable(),
                ...$dayColumns,
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
                    ->importer(BrandImporter::class),
            ])
            ->defaultSort('created_at', 'desc')
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
                        ->exporter(BrandExporter::class),
                ]),
            ]);
    }
}
