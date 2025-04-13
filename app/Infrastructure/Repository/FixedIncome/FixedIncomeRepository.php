<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository\FixedIncome;

use App\Domain\Model\FixedIncome\FixedIncome;
use App\Models\FixedIncome AS FixedIncomeModel;
use App\Domain\Model\FixedIncome\FixedIncomeRepositoryInterface;

final class FixedIncomeRepository implements FixedIncomeRepositoryInterface
{
    private readonly FixedIncomeModel $fixedIncomeModel;

    public function __construct(
        FixedIncomeModel $fixedIncomeModel
    )
    {
        $this->fixedIncomeModel = $fixedIncomeModel;
    }

    /**
     * @param integer $id
     * @return array
     */
    public function fetchById(int $id): array
    {
        return $this->fixedIncomeModel->fetchById($id);
    }

    /**
     * @param FixedIncome $fixedIncome
     * @return void
     */
    public function create(FixedIncome $fixedIncome): void
    {
        $this->fixedIncomeModel->createFixedIncome(
            $fixedIncome->getIncomeId(),
            $fixedIncome->getCycleUnit()->value,
            $fixedIncome->getPaymentDay()->getValue(),
            $fixedIncome->getPaymentMonth() ? $fixedIncome->getPaymentMonth()->getValue() : null,
            $fixedIncome->getStartDate()->getValue(),
            $fixedIncome->getEndDate() ? $fixedIncome->getEndDate()->getValue() : null,
        );
    }

    /**
     * @param FixedIncome $fixedIncome
     * @return void
     */
    public function update(FixedIncome $fixedIncome): void
    {
        $this->fixedIncomeModel->updateById(
            $fixedIncome->getIncomeId(),
            $fixedIncome->getCycleUnit()->value,
            $fixedIncome->getPaymentDay()->getValue(),
            $fixedIncome->getPaymentMonth() ? $fixedIncome->getPaymentMonth()->getValue() : null,
            $fixedIncome->getStartDate()->getValue(),
            $fixedIncome->getEndDate() ? $fixedIncome->getEndDate()->getValue() : null,
        );
    }

    /**
     * @param FixedIncome $fixedIncome
     * @return void
     */
    public function remove(FixedIncome $fixedIncome): void
    {
        $this->fixedIncomeModel->deleteById(
            $fixedIncome->getId(),
        );
    }
}
