<?php

declare(strict_types=1);

namespace App\Domain\Model\FixedExpenditure;

final class PaymentDay
{
    /**
     * @param integer $value
     */
    public function __construct(
        private readonly int $value
    )
    {
        $this->validate($value);
    }

    /**
     * @return integer
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * @param integer $value
     * @return void
     */
    private function validate(int $value): void
    {
        if ($value < 1 || $value > 31) {
            throw new \InvalidArgumentException("Payment day must be between 1 and 31, got: {$value}");
        }
    }
} 