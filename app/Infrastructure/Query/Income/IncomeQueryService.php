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
}
