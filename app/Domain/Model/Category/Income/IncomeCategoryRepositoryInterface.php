<?php

namespace App\Domain\Model\Category\Income;

interface IncomeCategoryRepositoryInterface
{
    public function fetchById(int $id, int $userId): array;
    public function save(IncomeCategory $incomeCategory): array;
    public function edit(IncomeCategory $incomeCategory): array;
    public function remove(IncomeCategory $incomeCategory): void;
}
