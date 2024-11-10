<?php

namespace App\Domain\Model\Category\Expenditure;

use App\Domain\Model\Category\Expenditure\ExpenditureCategory;

interface ExpenditureCategoryRepositoryInterface
{
    public function save(ExpenditureCategory $expenditureCategory): void;
}
