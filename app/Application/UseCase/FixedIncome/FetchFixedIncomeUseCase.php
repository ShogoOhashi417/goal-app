<?php

declare(strict_types=1);

namespace App\Application\UseCase\FixedIncome;

use App\Application\Query\FixedIncome\FixedIncomeQueryServiceInterface;
use App\Application\Service\AuthService;

final class FetchFixedIncomeUseCase
{
    public function __construct(
        private readonly FixedIncomeQueryServiceInterface $fixedIncomeQueryService,
        private readonly AuthService $authService
    ) {}

    public function handle(): array
    {
        $userId = $this->authService->getCurrentUserId();
        return $this->fixedIncomeQueryService->fetchAll($userId);
    }
}
