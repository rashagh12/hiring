<?php

namespace App\Enums;

enum WorkingTime: string
{
    case PART_TIME = 'part-time';
    case FULL_TIME = 'full-time';
    case REMOTE = 'remote';
    case ON_SITE = 'on-site';

    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }
}
