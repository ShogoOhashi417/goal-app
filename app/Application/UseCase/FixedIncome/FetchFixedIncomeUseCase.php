<?php

declare(strict_types=1);

namespace App\Application\UseCase\FixedIncome;

use App\Application\Query\FixedIncome\FixedIncomeQueryServiceInterface;

final readonly class FetchFixedIncomeUseCase
{
    public function __construct(
        private FixedIncomeQueryServiceInterface $fixedIncomeQueryService
    ) {}

    public function handle(): array
    {
        return $this->fixedIncomeQueryService->fetchAll();
    }
}
