<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository\Income;

use App\Domain\Model\Income\Income;
use App\Models\Income AS IncomeModel;
use App\Domain\Model\Income\IncomeRepositoryInterface;

final class IncomeRepository implements IncomeRepositoryInterface
{
    private readonly IncomeModel $incomeModel;

    public function __construct(
        IncomeModel $incomeModel
    )
    {
        $this->incomeModel = $incomeModel;
    }

    /**
     * @param integer $id
     * @return array
     */
    public function fetchById(int $id): array
    {
        return $this->incomeModel->fetchById($id);
    }

    /**
     * @return void
     */
    public function create(Income $income): void
    {
        $this->incomeModel->createIncome(
            $income->getName()->getValue(),
            $income->getAmount()->getValue()
        );
    }
}
