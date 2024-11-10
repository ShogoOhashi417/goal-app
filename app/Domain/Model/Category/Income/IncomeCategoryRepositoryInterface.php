<?php

namespace App\Domain\Model\Category\Income;

interface IncomeCategoryRepositoryInterface
{
    public function save(IncomeCategory $incomeCategory): void;
}
