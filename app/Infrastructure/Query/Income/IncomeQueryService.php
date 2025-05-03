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
     * @return array
     */
    public function fetchAll(): array
    {
        return $this->incomeModel->fetchAll();
    }

    /**
     * @param string $startDate
     * @param string $endDate
     * @return array
     */
    public function fetchOneTimeIncome(string $startDate, string $endDate): array
    {
        return $this->incomeModel->fetchOneTimeIncome($startDate, $endDate);
    }

    /**
     * @return array
     */
    public function fetchFixedIncome(): array
    {
        return $this->incomeModel->fetchFixedIncome();
    }
}
