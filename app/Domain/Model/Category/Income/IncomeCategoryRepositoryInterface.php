<?php

namespace App\Domain\Model\Category\Income;

interface IncomeCategoryRepositoryInterface
{
    public function fetchById(int $id, int $userId): array;
    public function save(IncomeCategory $incomeCategory): void;
    public function edit(IncomeCategory $incomeCategory): void;
    public function remove(IncomeCategory $incomeCategory): void;
}
