<?php

namespace App\Enums;

enum MaritalStatus: string
{
    case SINGLE = 'single';
    case MARRIED = 'married';

    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }
}
