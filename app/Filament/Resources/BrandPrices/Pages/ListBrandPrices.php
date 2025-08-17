<?php

namespace App\Filament\Resources\BrandPrices\Pages;

use App\Filament\Resources\BrandPrices\BrandPriceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBrandPrices extends ListRecords
{
    protected static string $resource = BrandPriceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
