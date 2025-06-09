<?php

declare(strict_types=1);

namespace App\Application\UseCase\Category\Expenditure\Fetch;

use App\Models\ExpenditureCategory;
use App\Application\Service\AuthService;

final class FetchExpenditureCategoryUseCase
{
    public function __construct(
        private readonly ExpenditureCategory $expenditureCategory,
        private readonly AuthService $authService
    ) {}

    /**
     * @return array
     */
    public function handle(): array
    {
        $userId = $this->authService->getCurrentUserId();
        return $this->expenditureCategory->fetchAll($userId);
    }
}
