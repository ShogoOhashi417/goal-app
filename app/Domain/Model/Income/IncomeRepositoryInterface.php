<?php

declare(strict_types=1);

namespace App\Domain\Model\Income;

interface IncomeRepositoryInterface
{
    public function create(Income $income): void;

    public function fetchById(int $id): array;
}
