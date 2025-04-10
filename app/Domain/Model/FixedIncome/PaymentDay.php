<?php

declare(strict_types=1);

namespace App\Domain\Model\FixedIncome;

final class PaymentDay
{
    private readonly int $value;

    public function __construct(int $value)
    {
        if ($value < 1 || $value > 31) {
            throw new \InvalidArgumentException('支払日は1から31の間で指定してください。');
        }
        $this->value = $value;
    }

    public function getValue(): int
    {
        return $this->value;
    }
}
