<?php

declare(strict_types=1);

namespace App\Application\UseCase\Category\Income\Fetch;

use App\Models\IncomeCategory;
use App\Application\Service\AuthService;

final class FetchIncomeCategoryUseCase
{
    public function __construct(
        private readonly IncomeCategory $incomeCategory,
        private readonly AuthService $authService
    ) {}

    public function handle(): array
    {
        $userId = $this->authService->getCurrentUserId();
        return $this->incomeCategory->fetchAll($userId);
    }
}
