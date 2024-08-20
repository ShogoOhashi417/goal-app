<?php

declare(strict_types=1);

namespace App\Domain\Model\Expenditure;

use InvalidArgumentException;

final class ExpenditureAmount
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
            throw new InvalidArgumentException('支出は1円以上です。');
        }
    }
}
