<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository\Expenditure;

use App\Domain\Model\Expenditure\Expenditure;
use App\Models\Expenditure AS ExpenditureModel;
use App\Domain\Model\Expenditure\ExpenditureRepositoryInterface;

final class ExpenditureRepository implements ExpenditureRepositoryInterface
{
    private readonly ExpenditureModel $expenditureModel;

    public function __construct(
        ExpenditureModel $expenditureModel
    )
    {
        $this->expenditureModel = $expenditureModel;
    }

    /**
     * @param integer $id
     * @return array
     */
    public function fetchById(int $id): array
    {
        return $this->expenditureModel->fetchById($id);
    }

    /**
     * @return void
     */
    public function create(Expenditure $expenditure): void
    {
        $this->expenditureModel->createExpenditure(
            $expenditure->getName()->getValue(),
            $expenditure->getCategoryId()->getValue(),
            $expenditure->getAmount()->getValue()
        );
    }

    /**
     * @param Expenditure $expenditure
     * @return void
     */
    public function update(Expenditure $expenditure): void
    {
        $this->expenditureModel->updateById(
            $expenditure->getId(),
            $expenditure->getName()->getValue(),
            $expenditure->getCategoryId()->getValue(),
            $expenditure->getAmount()->getValue()
        );
    }

    /**
     * @param Expenditure $expenditure
     * @return void
     */
    public function remove(Expenditure $expenditure): void
    {
        $this->expenditureModel->deleteById(
            $expenditure->getId(),
        );
    }
}
