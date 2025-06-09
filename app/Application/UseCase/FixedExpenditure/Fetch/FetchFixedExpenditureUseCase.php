<?php

declare(strict_types=1);

namespace App\Application\UseCase\FixedExpenditure\Fetch;

use App\Application\Query\FixedExpenditure\FixedExpenditureQueryServiceInterface;
use App\Application\Service\AuthService;
use App\Domain\Model\FixedExpenditure\CycleUnit;

final class FetchFixedExpenditureUseCase
{
    public function __construct(
        private readonly FixedExpenditureQueryServiceInterface $query,
        private readonly AuthService $authService
    ) {}

    /**
     * @return array
     */
    public function handle(): array
    {
        $userId = $this->authService->getCurrentUserId();
        $result = $this->query->fetchAll($userId);

        foreach ($result as $index => $fixedExpenditureData) {
            $result[$index]['cycle_unit_string'] = CycleUnit::toString((int)$fixedExpenditureData['cycle_unit']);
        }

        return $result;
    }
} 