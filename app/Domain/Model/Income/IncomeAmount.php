<?php

declare(strict_types=1);

namespace App\Domain\Model\Income;

use InvalidArgumentException;

final class IncomeAmount
{
    private const MINIMUM_AMOUNT = 1;

    private readonly int $amount;

    public function __construct(
        int $amount
    )
    {
        $this->assertMinimum($amount);
        $this->amount = $amount;
    }

    /**
     * @return integer
     */
    public function getValue(): int
    {
        return $this->amount;
    }

    /**
     * @param integer $amount
     * @return void
     */
    private function assertMinimum(int $amount): void
    {
        if ($amount < self::MINIMUM_AMOUNT) {
            throw new InvalidArgumentException('収入は1円以上です。');
        }
    }
}
