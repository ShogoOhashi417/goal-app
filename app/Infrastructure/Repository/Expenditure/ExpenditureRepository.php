<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository\Expenditure;

use App\Domain\Model\Expenditure\Expenditure;
use App\Domain\Model\Expenditure\ExpenditureHolder;
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
            $expenditure->getAmount()->getValue(),
            $expenditure->getCalendarDate()->getValue(),
        );
    }

    /**
     * @param ExpenditureHolder $expenditureHolder
     * @return void
     */
    public function saveBulk(ExpenditureHolder $expenditureHolder): void
    {
        $saveDataList = [];

        foreach ($expenditureHolder->getExpenditureList() as $expenditure) {
            $saveDataList[] = [
                'name' => $expenditure->getName()->getValue(),
                'category_id' => $expenditure->getCategoryId()->getValue(),
                'amount' => $expenditure->getAmount()->getValue(),
                'calendar_date' => $expenditure->getCalendarDate()->getValue()
            ];
        }

        $this->expenditureModel->saveBulk($saveDataList);
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
            $expenditure->getAmount()->getValue(),
            $expenditure->getCalendarDate()->getValue()
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

    /**
     * @return integer
     */
    public function getLastInsertId(): int
    {
        return $this->expenditureModel->getLastInsertId();
    }
}
