<?php

declare(strict_types=1);

namespace App\Application\UseCase\Expenditure\Fetch;

use App\Application\Query\Expenditure\ExpenditureQueryServiceInterface;
use App\Application\Service\AuthService;

final class FetchExpenditureUseCase
{
    public function __construct(
        private readonly ExpenditureQueryServiceInterface $query,
        private readonly AuthService $authService
    ) {}

    /**
     * @return array
     */
    public function handle(): array
    {
        $userId = $this->authService->getCurrentUserId();
        return $this->query->fetchAll($userId);
    }
}
