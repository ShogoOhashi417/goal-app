<?php

declare(strict_types=1);

namespace App\Domain\LifeInsurance;

enum PaymentType: int {
    case Monthly = 1;
    case HalfYearly = 2;
    case Yearly = 3;
    case LumpSum = 4;

    public static function fromString(string $string)
    {
        return match ($string) {
            '月払い' => self::Monthly,
            '半年払い' => self::HalfYearly,
            '年払い' => self::Yearly,
            '一時払い' => self::LumpSum
        };
    }

    public function toString()
    {
        return match ($this) {
            self::Monthly => '月払い',
            self::HalfYearly => '半年払い',
            self::Yearly => '年払い',
            self::LumpSum => '一時払い'
        };
    }

    /**
     *
     * @return boolean
     */
    public function isMonthly(): bool
    {
        return $this === self::Monthly;
    }

    /**
     *
     * @return boolean
     */
    public function isHalfYearly(): bool
    {
        return $this === self::HalfYearly;
    }

    /**
     *
     * @return boolean
     */
    public function isYealy(): bool
    {
        return $this === self::Yearly;
    }

    /**
     *
     * @return boolean
     */
    public function isAlreadyPaied(): bool
    {
        return $this === self::LumpSum;
    }
}