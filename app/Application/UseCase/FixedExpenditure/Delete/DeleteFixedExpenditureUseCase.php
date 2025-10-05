<?php

declare(strict_types=1);

namespace App\Application\UseCase\FixedExpenditure\Delete;

use App\Domain\Model\FixedExpenditure\FixedExpenditure;
use App\Domain\Model\FixedExpenditure\FixedExpenditureRepositoryInterface;
use App\Domain\Model\Expenditure\Expenditure;
use App\Domain\Model\Expenditure\ExpenditureRepositoryInterface;

final class DeleteFixedExpenditureUseCase
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
     * @param DeleteFixedExpenditureInputData $inputData
     * @return void
     */
    public function handle(DeleteFixedExpenditureInputData $inputData): void
    {
		if (!$inputData->id) {
			return;
		}

		$expenditureInfoList = $this->expenditureRepository->fetchFixedExpenditureById($inputData->id);

        if (!$expenditureInfoList) {
            return;
        }

        $fixedExpenditure = FixedExpenditure::reconstruct(
            $expenditureInfoList['fixed_expenditure_id'],
            $expenditureInfoList['name'] ?? '',
            $expenditureInfoList['category_id'],
            $expenditureInfoList['amount'],
            (int)$expenditureInfoList['cycle_unit'],
            $expenditureInfoList['payment_day'],
            $expenditureInfoList['payment_month'],
            $expenditureInfoList['start_date'],
            $expenditureInfoList['end_date'],
            $inputData->id,
            $inputData->userId
        );

        $this->fixedExpenditureRepository->remove($fixedExpenditure);

        $expenditure = Expenditure::reconstruct(
            $inputData->id,
            $expenditureInfoList['name'] ?? '',
            $expenditureInfoList['category_id'],
            $expenditureInfoList['amount'],
            $expenditureInfoList['start_date'],
            $inputData->userId
        );
        $this->expenditureRepository->remove($expenditure);
    }
} 