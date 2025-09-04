<?php

namespace App\Filament\Imports;

use App\Enums\UserStatus;
use App\Models\User;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Number;
use Illuminate\Validation\Rules\Enum;

class UserImporter extends Importer
{
    protected static ?string $model = User::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('first_name')
                ->label('First Name')
                ->exampleHeader('First Name')
                ->example(['John', 'Jane'])
                ->rules(['required', 'string', 'max:255']),
            ImportColumn::make('last_name')
                ->label('Last Name')
                ->exampleHeader('Last Name')
                ->example(['Doe', 'Smith'])
                ->requiredMapping()
                ->rules(['required', 'string', 'max:255']),
            ImportColumn::make('phone')
                ->label('Phone')
                ->exampleHeader('Phone')
                ->example(['123-456-7890', '987-654-3210'])
                ->requiredMapping()
                ->rules(['required', 'integer', 'max:20']),
            ImportColumn::make('email')
                ->label('Email')
                ->exampleHeader('Email')
                ->example(['john@example.com', 'jane@example.com'])
                ->requiredMapping()
                ->rules(['required', 'string', 'max:255']),


        ];
    }

    public function resolveRecord(): User
    {
       return User::firstOrNew([
            'email' => $this->data['email'],
        ]);
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your user import has completed and ' . Number::format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
