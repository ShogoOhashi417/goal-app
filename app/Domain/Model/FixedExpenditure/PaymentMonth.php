<?php

declare(strict_types=1);

namespace App\Domain\Model\FixedExpenditure;

final class PaymentMonth
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
        if ($value < 1 || $value > 12) {
            throw new \InvalidArgumentException("Payment month must be between 1 and 12, got: {$value}");
        }
    }
} 