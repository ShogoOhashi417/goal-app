<?php

declare(strict_types=1);

namespace App\Domain\Model\FixedIncome;

enum CycleUnit: int
{
    case MONTH = 1;
    case YEAR = 2;
    
    public static function toString(int $value): string
    {
        return match($value) {
            self::MONTH->value => '月',
            self::YEAR->value => '年',
            default => '',
        };
    }
}
