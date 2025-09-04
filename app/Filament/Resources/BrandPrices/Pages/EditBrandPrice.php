<?php

namespace App\Filament\Resources\BrandPrices\Pages;

use App\Filament\Resources\BrandPrices\BrandPriceResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditBrandPrice extends EditRecord
{
    protected static string $resource = BrandPriceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
