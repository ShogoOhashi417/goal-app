<?php

declare(strict_types=1);

namespace App\Application\UseCase\Income\Fetch;

use App\Application\Query\Income\IncomeQueryServiceInterface;
use App\Application\Service\AuthService;

final class FetchIncomeUseCase
{
    public function __construct(
        private readonly IncomeQueryServiceInterface $query,
        private readonly AuthService $authService
    ) {}

    /**
     * @return void
     */
    public function handle(): array
    {
        $userId = $this->authService->getCurrentUserId();
        return $this->query->fetchAll($userId);
    }
}
