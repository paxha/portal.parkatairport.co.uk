<?php

namespace App\Enums;

use BackedEnum;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;

enum BookingStatus: string implements HasColor, HasLabel
{
    case Confirmed = 'confirmed';
    case Cancelled = 'cancelled';

    public function getLabel(): string|Htmlable|null
    {
        return $this->name;
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Confirmed => 'success',
            self::Cancelled => 'danger',
        };
    }

    public static function default(): self
    {
        return self::Confirmed;
    }
}
