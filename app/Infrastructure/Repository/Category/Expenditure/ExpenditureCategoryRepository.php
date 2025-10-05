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
     * @param integer $userId
     * @return array
     */
    public function fetchById(int $id, int $userId): array
    {
        return $this->expenditureCategoryModel->fetchById($id);
    }

    /**
     * @param ExpenditureCategory $expenditureCategory
     * @return array
     */
    public function save(ExpenditureCategory $expenditureCategory): array
    {
        return $this->expenditureCategoryModel->createExpenditureCategory(
            $expenditureCategory->getName()->value(),
            $expenditureCategory->getUserId()->value()
        );
    }

    /**
     * @param ExpenditureCategory $expenditureCategory
     * @return array
     */
    public function edit(ExpenditureCategory $expenditureCategory): array
    {
        $this->expenditureCategoryModel->updateById(
            $expenditureCategory->getId(),
            $expenditureCategory->getName()->value()
        );
        
        return $this->fetchById($expenditureCategory->getId(), $expenditureCategory->getUserId()->value())[0] ?? [];
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
