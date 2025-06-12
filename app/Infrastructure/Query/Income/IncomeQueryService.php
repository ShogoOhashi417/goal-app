<?php

declare(strict_types=1);

namespace App\Infrastructure\Query\Income;

use App\Models\Income AS IncomeModel;
use App\Application\Query\Income\IncomeQueryServiceInterface;

final class IncomeQueryService implements IncomeQueryServiceInterface
{
    private readonly IncomeModel $incomeModel;

    public function __construct(
        IncomeModel $incomeModel
    )
    {
        $this->incomeModel = $incomeModel;
    }

    /**
     * @param int $userId
     * @return array
     */
    public function fetchAll(int $userId): array
    {
        return $this->incomeModel->fetchAll($userId);
    }

    /**
     * @param string $startDate
     * @param string $endDate
     * @param int $userId
     * @return array
     */
    public function fetchOneTimeIncome(string $startDate, string $endDate, int $userId): array
    {
        return $this->incomeModel->fetchOneTimeIncome($startDate, $endDate, $userId);
    }

    /**
     * @param int $userId
     * @return array
     */
    public function fetchFixedIncome(int $userId): array
    {
        return $this->incomeModel->fetchFixedIncome($userId);
    }
}
