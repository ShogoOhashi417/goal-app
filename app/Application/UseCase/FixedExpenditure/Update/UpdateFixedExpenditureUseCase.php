<?php

declare(strict_types=1);

namespace App\Application\UseCase\FixedExpenditure\Update;

use App\Domain\Model\FixedExpenditure\FixedExpenditure;
use App\Domain\Model\FixedExpenditure\FixedExpenditureRepositoryInterface;
use App\Domain\Model\Expenditure\Expenditure;
use App\Domain\Model\Expenditure\ExpenditureRepositoryInterface;

final class UpdateFixedExpenditureUseCase
{
    /**
     * @param FixedExpenditureRepositoryInterface $fixedExpenditureRepository
     * @param ExpenditureRepositoryInterface $expenditureRepository
     */
    public function __construct(
        private readonly FixedExpenditureRepositoryInterface $fixedExpenditureRepository,
        private readonly ExpenditureRepositoryInterface $expenditureRepository
    )
    {
    }

    /**
     * @param UpdateFixedExpenditureInputData $inputData
     * @return void
     */
    public function handle(UpdateFixedExpenditureInputData $inputData): void
    {
        $fixedExpenditureInfo = $this->fixedExpenditureRepository->fetchById($inputData->id);
        $expenditureId = $fixedExpenditureInfo['expenditure_id'] ?? 0;

		if (!$expenditureId) {
			return;
		}

        $expenditure = Expenditure::reconstruct(
            $expenditureId,
            $inputData->name,
            $inputData->categoryId,
            $inputData->amount,
            $inputData->startDate,
            $inputData->userId
        );

        $this->expenditureRepository->update($expenditure);

        $fixedExpenditure = FixedExpenditure::reconstruct(
            $inputData->id,
            $inputData->name,
            $inputData->categoryId,
            $inputData->amount,
            $inputData->cycleUnit,
            $inputData->paymentDay,
            $inputData->paymentMonth,
            $inputData->startDate,
            $inputData->endDate,
            $expenditureId,
            $inputData->userId
        );

        $this->fixedExpenditureRepository->update($fixedExpenditure);
    }
} 