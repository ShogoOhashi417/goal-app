<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository\FixedExpenditure;

use App\Domain\Model\FixedExpenditure\FixedExpenditure;
use App\Models\FixedExpenditure AS FixedExpenditureModel;
use App\Domain\Model\FixedExpenditure\FixedExpenditureRepositoryInterface;

final class FixedExpenditureRepository implements FixedExpenditureRepositoryInterface
{
    private readonly FixedExpenditureModel $fixedExpenditureModel;

    public function __construct(
        FixedExpenditureModel $fixedExpenditureModel
    )
    {
        $this->fixedExpenditureModel = $fixedExpenditureModel;
    }

    /**
     * @param integer $id
     * @return array
     */
    public function fetchById(int $id): array
    {
        $fixedExpenditure = $this->fixedExpenditureModel->fetchById($id);

        if (!$fixedExpenditure) {
            return [];
        }

        return $fixedExpenditure->toArray();
    }

    /**
     * @param FixedExpenditure $fixedExpenditure
     * @return void
     */
    public function create(FixedExpenditure $fixedExpenditure): void
    {
        $this->fixedExpenditureModel->createFixedExpenditure(
            $fixedExpenditure->getExpenditureId(),
            $fixedExpenditure->getCycleUnit()->value,
            $fixedExpenditure->getPaymentDay()->getValue(),
            $fixedExpenditure->getPaymentMonth() ? $fixedExpenditure->getPaymentMonth()->getValue() : null,
            $fixedExpenditure->getStartDate()->getValue(),
            $fixedExpenditure->getEndDate() ? $fixedExpenditure->getEndDate()->getValue() : null,
            $fixedExpenditure->getUserId()
        );
    }

    /**
     * @param FixedExpenditure $fixedExpenditure
     * @return void
     */
    public function update(FixedExpenditure $fixedExpenditure): void
    {
        $this->fixedExpenditureModel->updateById(
            $fixedExpenditure->getId(),
            $fixedExpenditure->getExpenditureId(),
            $fixedExpenditure->getCycleUnit()->value,
            $fixedExpenditure->getPaymentDay()->getValue(),
            $fixedExpenditure->getPaymentMonth() ? $fixedExpenditure->getPaymentMonth()->getValue() : null,
            $fixedExpenditure->getStartDate()->getValue(),
            $fixedExpenditure->getEndDate() ? $fixedExpenditure->getEndDate()->getValue() : null,
            $fixedExpenditure->getUserId()
        );
    }

    /**
     * @param FixedExpenditure $fixedExpenditure
     * @return void
     */
    public function remove(FixedExpenditure $fixedExpenditure): void
    {
        $this->fixedExpenditureModel->deleteById(
            $fixedExpenditure->getId(),
            $fixedExpenditure->getUserId()
        );
    }
} 