<?php

declare(strict_types=1);

namespace App\Application\UseCase\FixedIncome\Input;

final readonly class DeleteFixedIncomeInputData
{
    public function __construct(
        public readonly int $id,
		public readonly int $userId
    ) {
    }
}
