<?php

declare(strict_types=1);

namespace App\Application\UseCase\FixedIncome;

use App\Domain\Model\Income\Income;
use App\Domain\Model\FixedIncome\FixedIncome;
use App\Domain\Model\Income\IncomeRepositoryInterface;
use App\Domain\Model\FixedIncome\FixedIncomeRepositoryInterface;
use App\Application\UseCase\FixedIncome\Input\DeleteFixedIncomeInputData;

final readonly class DeleteFixedIncomeUseCase
{
    public function __construct(
		private readonly IncomeRepositoryInterface $incomeRepository,
        private readonly FixedIncomeRepositoryInterface $fixedIncomeRepository
    ) {
    }

    public function handle(DeleteFixedIncomeInputData $inputData): void
    {
        $incomeInfoList = $this->incomeRepository->fetchById($inputData->id, $inputData->userId);

        if (!$incomeInfoList) {
            throw new \RuntimeException('固定収入が見つかりませんでした。');
        }

		$income = Income::reconstruct(
            $inputData->id,
            $incomeInfoList['name'],
            $incomeInfoList['category_id'],
            $incomeInfoList['amount'],
            $incomeInfoList['calendar_date'],
            $inputData->userId
        );

		$fixedIncome = FixedIncome::reconstruct(
			$inputData->id,
			$incomeInfoList['name'],
			$incomeInfoList['category_id'],
			$incomeInfoList['amount'],
			(int)$incomeInfoList['cycle_unit'],
			(int)$incomeInfoList['payment_day'],
			(int)$incomeInfoList['payment_month'],
			$incomeInfoList['start_date'],
			$incomeInfoList['end_date'],
			$inputData->userId
		);

		$this->incomeRepository->remove($income);
        $this->fixedIncomeRepository->delete($fixedIncome);
    }
}
