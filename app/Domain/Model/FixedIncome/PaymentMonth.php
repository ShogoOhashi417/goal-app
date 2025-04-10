<?php

declare(strict_types=1);

namespace App\Domain\Model\FixedIncome;

final class PaymentMonth
{
    private readonly int $value;

    public function __construct(int $value)
    {
        if ($value < 1 || $value > 12) {
            throw new \InvalidArgumentException('支払月は1から12の間で指定してください。');
        }
        $this->value = $value;
    }

    public function getValue(): int
    {
        return $this->value;
    }
}
