<?php

namespace App\Infrastructure\Repository\Category\Income;

use App\Domain\Model\Category\Income\IncomeCategory;
use App\Models\IncomeCategory AS IncomeCategoryModel;
use App\Domain\Model\Category\Income\IncomeCategoryRepositoryInterface;

final class IncomeCategoryRepository implements IncomeCategoryRepositoryInterface
{
    private readonly IncomeCategoryModel $incomeCategoryModel;

    public function __construct(
        IncomeCategoryModel $incomeCategoryModel
    ){
        $this->incomeCategoryModel = $incomeCategoryModel;
    }

    /**
     * @param integer $id
     * @return array
     */
    public function fetchById(int $id, int $userId): array
    {
        return $this->incomeCategoryModel->fetchById($id, $userId);
    }

    /**
     * @param IncomeCategory $incomeCategory
     * @return array
     */
    public function save(IncomeCategory $incomeCategory): array
    {
        return $this->incomeCategoryModel->createIncomeCategory(
            $incomeCategory->getName()->value(),
            $incomeCategory->getUserId()->value()
        );
    }

    /**
     * @param IncomeCategory $incomeCategory
     * @return array
     */
    public function edit(IncomeCategory $incomeCategory): array
    {
        $this->incomeCategoryModel->updateIncomeCategory(
            $incomeCategory->getId(),
            $incomeCategory->getName()->value()
        );
        
        return $this->fetchById($incomeCategory->getId(), $incomeCategory->getUserId()->value())[0] ?? [];
    }

    /**
     * @param IncomeCategory $incomeCategory
     * @return void
     */
    public function remove(IncomeCategory $incomeCategory): void
    {
        $this->incomeCategoryModel->deleteById(
            $incomeCategory->getId()
        );
    }
}
