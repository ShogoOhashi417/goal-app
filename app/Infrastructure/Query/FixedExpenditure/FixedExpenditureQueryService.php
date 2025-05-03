<?php

declare(strict_types=1);

namespace App\Infrastructure\Query\FixedExpenditure;

use App\Models\FixedExpenditure AS FixedExpenditureModel;
use App\Application\Query\FixedExpenditure\FixedExpenditureQueryServiceInterface;

final readonly class FixedExpenditureQueryService implements FixedExpenditureQueryServiceInterface
{
    public function __construct(
        private readonly FixedExpenditureModel $fixedExpenditureModel
    )
    {}

    /**
     * @return array
     */
    public function fetchAll(): array
    {
        return $this->fixedExpenditureModel->fetchAll();
    }
} 