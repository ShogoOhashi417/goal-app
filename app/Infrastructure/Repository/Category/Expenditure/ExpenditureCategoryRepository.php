<?php

namespace App\Infrastructure\Repository\Category\Expenditure;

use App\Domain\Model\Category\Expenditure\ExpenditureCategory;
use App\Models\ExpenditureCategory AS ExpenditureCategoryModel;
use App\Domain\Model\Category\Expenditure\ExpenditureCategoryRepositoryInterface;

final class ExpenditureCategoryRepository implements ExpenditureCategoryRepositoryInterface
{
    private readonly ExpenditureCategoryModel $expenditureCategoryModel;

    public function __construct(
        ExpenditureCategoryModel $expenditureCategoryModel
    ){
        $this->expenditureCategoryModel = $expenditureCategoryModel;
    }

    /**
     * @param ExpenditureCategory $expenditureCategory
     * @return void
     */
    public function save(ExpenditureCategory $expenditureCategory): void
    {
        $this->expenditureCategoryModel->createExpenditureCategory(
            $expenditureCategory->getName()->value()
        );
    }
}
