<?php

namespace App\Domain\Model\Category\Expenditure;

use App\Domain\Model\Category\Expenditure\ExpenditureCategory;

interface ExpenditureCategoryRepositoryInterface
{
    public function fetchById(int $id, int $userId): array;
    public function save(ExpenditureCategory $expenditureCategory): array;
    public function edit(ExpenditureCategory $expenditureCategory): array;
    public function remove(ExpenditureCategory $expenditureCategory): void;
}
