<?php

namespace App\Filament\Resources\BrandPrices;

use App\Filament\Resources\BrandPrices\Pages\CreateBrandPrice;
use App\Filament\Resources\BrandPrices\Pages\EditBrandPrice;
use App\Filament\Resources\BrandPrices\Pages\ListBrandPrices;
use App\Filament\Resources\BrandPrices\Pages\ViewBrandPrice;
use App\Filament\Resources\BrandPrices\Schemas\BrandPriceForm;
use App\Filament\Resources\BrandPrices\Schemas\BrandPriceInfolist;
use App\Filament\Resources\BrandPrices\Tables\BrandPricesTable;
use App\Models\BrandPrice;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BrandPriceResource extends Resource
{
    protected static ?string $model = BrandPrice::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return BrandPriceForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return BrandPriceInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BrandPricesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBrandPrices::route('/'),
            'create' => CreateBrandPrice::route('/create'),
            'view' => ViewBrandPrice::route('/{record}'),
            'edit' => EditBrandPrice::route('/{record}/edit'),
        ];
    }
}
