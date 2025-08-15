<?php

namespace App\Enums;

use BackedEnum;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;

enum UserStatus: string implements HasLabel, HasColor, HasIcon
{
    case Active = 'active';
    case Blocked = 'blocked';

    public function getLabel(): string|Htmlable|null
    {
        return $this->name;
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Active => 'success',
            self::Blocked => 'danger',
        };
    }

    public function getIcon(): string|BackedEnum|null
    {
        return match ($this) {
            self::Active => Heroicon::CheckBadge,
            self::Blocked => Heroicon::NoSymbol,
        };
    }

    public static function default(): self
    {
        return self::Active;
    }
}
