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
     * @return array
     */
    public function fetchAll(): array
    {
        return $this->expenditureModel->fetchAll();
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
}
