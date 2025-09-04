<?php

namespace App\Filament\Resources\BrandPrices\Pages;

use App\Filament\Resources\BrandPrices\BrandPriceResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewBrandPrice extends ViewRecord
{
    protected static string $resource = BrandPriceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
