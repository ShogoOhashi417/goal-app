<?php

namespace App\Domain\Model\Category\Expenditure;

use App\Domain\Model\Category\Expenditure\ExpenditureCategory;

interface ExpenditureCategoryRepositoryInterface
{
    public function fetchById(int $id): array;
    public function save(ExpenditureCategory $expenditureCategory): void;
    public function remove(ExpenditureCategory $expenditureCategory): void;
}
