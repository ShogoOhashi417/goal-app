<?php

declare(strict_types=1);

namespace App\Application\UseCase\FixedExpenditure\Create;

final class CreateFixedExpenditureInputData
{
    /**
     * @param string $name
     * @param integer $categoryId
     * @param integer $amount
     * @param string $cycleUnit
     * @param integer $paymentDay
     * @param integer|null $paymentMonth
     * @param string $startDate
     * @param string|null $endDate
     */
    public function __construct(
		public readonly string $name,
		public readonly int $categoryId,
		public readonly int $amount,
        public readonly string $cycleUnit,
        public readonly int $paymentDay,
        public readonly ?int $paymentMonth,
        public readonly string $startDate,
        public readonly ?string $endDate,
    )
    {
    }
} 