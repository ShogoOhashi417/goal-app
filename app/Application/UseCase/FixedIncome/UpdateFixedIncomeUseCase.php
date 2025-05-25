<?php

declare(strict_types=1);

namespace App\Application\UseCase\FixedIncome;

use App\Domain\Model\Income\IncomeRepositoryInterface;
use App\Domain\Model\FixedIncome\FixedIncomeRepositoryInterface;
use App\Application\UseCase\FixedIncome\Input\UpdateFixedIncomeInputData;
use App\Domain\Model\Income\Income;
use App\Domain\Model\FixedIncome\FixedIncome;

final readonly class UpdateFixedIncomeUseCase
{
    public function __construct(
		private readonly IncomeRepositoryInterface $incomeRepository,
        private readonly FixedIncomeRepositoryInterface $fixedIncomeRepository
    ) {
    }

    public function handle(UpdateFixedIncomeInputData $inputData): void
    {
        $fixedIncome = $this->incomeRepository->fetchById($inputData->id, $inputData->userId);
        
        if (!$fixedIncome) {
            return;
        }

        $income = Income::reconstruct(
            $inputData->id,
            $inputData->name,
            $inputData->categoryId,
            $inputData->amount,
            $inputData->startDate,
            $inputData->userId
        );
        
        $fixedIncome = FixedIncome::reconstruct(
            $inputData->id,
            $inputData->name,
            $inputData->categoryId,
            $inputData->amount,
            $inputData->cycleUnit,
            $inputData->paymentDay,
            $inputData->paymentMonth,
            $inputData->startDate,
            $inputData->endDate,
            $inputData->userId
        );

        $this->incomeRepository->update($income);
        $this->fixedIncomeRepository->update($fixedIncome);
    }
}
