<?php

declare(strict_types=1);

namespace App\Domain\LifeInsurance;

enum PaymentType: int {
    case Monthly = 1;
    case HarfYearly = 2;
    case Yearly = 3;
    case LumpSum = 4;

    public function toString()
    {
        return match ($this) {
            self::Monthly => '月払い',
            self::HarfYearly => '半年払い',
            self::Yearly => '年払い',
            self::LumpSum => '一時払'
        };
    }
}