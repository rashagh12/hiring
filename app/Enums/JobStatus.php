<?php

namespace App\Enums;

enum JobStatus: string
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';

    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }
}
