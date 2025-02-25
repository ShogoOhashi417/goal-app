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
     * @param integer $id
     * @return array
     */
    public function fetchById(int $id): array
    {
        return $this->expenditureCategoryModel->fetchById($id);
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

    /**
     * @param ExpenditureCategory $expenditureCategory
     * @return void
     */
    public function edit(ExpenditureCategory $expenditureCategory): void
    {
        $this->expenditureCategoryModel->updateById(
            $expenditureCategory->getId(),
            $expenditureCategory->getName()->value()
        );
    }

    /**
     * @param ExpenditureCategory $expenditureCategory
     * @return void
     */
    public function remove(ExpenditureCategory $expenditureCategory): void
    {
        $this->expenditureCategoryModel->deleteById(
            $expenditureCategory->getId()
        );
    }
}
