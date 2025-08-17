<?php

namespace App\Filament\Resources\BrandPrices\Pages;

use App\Filament\Resources\BrandPrices\BrandPriceResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBrandPrice extends CreateRecord
{
    protected static string $resource = BrandPriceResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
