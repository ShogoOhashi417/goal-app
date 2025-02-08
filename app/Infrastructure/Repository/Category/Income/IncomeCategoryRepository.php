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
    public function fetchById(int $id): array
    {
        return $this->incomeCategoryModel->fetchById($id);
    }

    /**
     * @param IncomeCategory $incomeCategory
     * @return void
     */
    public function save(IncomeCategory $incomeCategory): void
    {
        $this->incomeCategoryModel->createIncomeCategory(
            $incomeCategory->getName()->value()
        );
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
