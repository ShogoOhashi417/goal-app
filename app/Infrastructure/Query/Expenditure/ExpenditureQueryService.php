<?php

declare(strict_types=1);

namespace App\Infrastructure\Query\Expenditure;

use App\Models\Expenditure AS ExpenditureModel;
use App\Application\Query\Expenditure\ExpenditureQueryServiceInterface;

class ExpenditureQueryService implements ExpenditureQueryServiceInterface
{
    private readonly ExpenditureModel $expenditureModel;

    public function __construct(
        ExpenditureModel $expenditureModel
    )
    {
        $this->expenditureModel = $expenditureModel;
    }

    /**
     * @param int $userId
     * @return array
     */
    public function fetchAll(int $userId): array
    {
        return $this->expenditureModel->fetchAll($userId);
    }

    /**
     * @param string $startDate
     * @param string $endDate
     * @return array
     */
    public function fetchByDateRange(string $startDate, string $endDate): array
    {
        return $this->expenditureModel->fetchByDateRange($startDate, $endDate);
    }

    /**
     * @param string $startDate
     * @param string $endDate
     * @param int $userId
     * @return array
     */
    public function fetchOneTimeExpenditure(string $startDate, string $endDate, int $userId): array
    {
        return $this->expenditureModel->fetchOneTimeExpenditure($startDate, $endDate, $userId);
    }

    /**
     * @param int $userId
     * @return array
     */
    public function fetchFixedExpenditure(int $userId): array
    {
        return $this->expenditureModel->fetchFixedExpenditure($userId);
    }
}
