<?php

declare(strict_types=1);

namespace App\Application\UseCase\FixedIncome\Input;

final readonly class CreateFixedIncomeInputData
{
    public function __construct(
        public string $name,
        public int $categoryId,
        public int $amount,
        public int $cycleUnit,
        public int $paymentDay,
        public ?int $paymentMonth,
        public ?string $startDate,
        public ?string $endDate,
        public int $userId
    ) {
    }
}
