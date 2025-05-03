<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Model\FixedIncome\FixedIncomeRepositoryInterface;
use App\Models\FixedIncome AS FixedIncomeModel;
use App\Domain\Model\FixedIncome\FixedIncome;

final readonly class FixedIncomeRepository implements FixedIncomeRepositoryInterface
{
    public function __construct(
        private readonly FixedIncomeModel $fixedIncomeModel
    ) {
    }

    public function findById(int $id): ?FixedIncome
    {
        return $this->fixedIncomeModel->fetchById($id);
    }

    public function save(FixedIncome $fixedIncome): void
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

    public function delete(FixedIncome $fixedIncome): void
    {
        // $fixedIncome->delete();
    }
} 