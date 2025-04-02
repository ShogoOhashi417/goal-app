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
        return $this->fixedExpenditureModel->fetchById($id);
    }

    /**
     * @param FixedExpenditure $fixedExpenditure
     * @return void
     */
    public function create(FixedExpenditure $fixedExpenditure): void
    {
        $this->fixedExpenditureModel->createFixedExpenditure(
            $fixedExpenditure->getExpenditureId(),
            $fixedExpenditure->getCycleUnit()->getValue(),
            $fixedExpenditure->getPaymentDay()->getValue(),
            $fixedExpenditure->getPaymentMonth() ? $fixedExpenditure->getPaymentMonth()->getValue() : null,
            $fixedExpenditure->getStartDate()->getValue(),
            $fixedExpenditure->getEndDate() ? $fixedExpenditure->getEndDate()->getValue() : null,
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
            $fixedExpenditure->getCycleUnit()->getValue(),
            $fixedExpenditure->getPaymentDay()->getValue(),
            $fixedExpenditure->getPaymentMonth() ? $fixedExpenditure->getPaymentMonth()->getValue() : null,
            $fixedExpenditure->getStartDate()->getValue(),
            $fixedExpenditure->getEndDate() ? $fixedExpenditure->getEndDate()->getValue() : null,
            $fixedExpenditure->getStartDate()->getValue()
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
        );
    }
} 