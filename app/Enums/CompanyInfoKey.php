<?php

namespace App\Enums;

use Illuminate\Support\Collection;

enum CompanyInfoKey: string
{
    case PHONE = 'phone';
    case EMAIL = 'email';
    case ADDRESS = 'address';
    case LEGAL_NAME = 'legal_name';
    case CAPITAL = 'capital';
    case LEGAL_FORM = 'legal_form';
    case  RC = 'rc';
    case ICE = 'ice';
    case STATUS = 'status';
    case CREATION_DATE = 'creation_date';
    case FULL_NAME = 'full_name';

    public static function values(): array
    {
        return array_map(
            static fn (self $key): string => $key->value,
            self::cases()
        );
    }

    public static function valuesCollection(): Collection
    {
        return collect(self::values());
    }
}
