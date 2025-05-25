<?php

declare(strict_types=1);

namespace App\Application\UseCase\FixedIncome;

use App\Application\UseCase\FixedIncome\Input\CreateFixedIncomeInputData;
use App\Domain\Model\FixedIncome\FixedIncome;
use App\Domain\Model\FixedIncome\FixedIncomeRepositoryInterface;
use App\Domain\Model\Income\Income;
use App\Domain\Model\Income\IncomeRepositoryInterface;
use Illuminate\Support\Facades\DB;

final class CreateFixedIncomeUseCase
{
    /**
	 * @param IncomeRepositoryInterface $incomeRepository
	 * @param FixedIncomeRepositoryInterface $fixedIncomeRepository
	 */
    public function __construct(
        private readonly IncomeRepositoryInterface $incomeRepository,
        private readonly FixedIncomeRepositoryInterface $fixedIncomeRepository,
    ) {
    }

    /**
     * @param CreateFixedIncomeInputData $inputData
     * @return void
     */
    public function handle(CreateFixedIncomeInputData $inputData): void
    {
        $income = Income::create(
            $inputData->name,
            $inputData->categoryId,
            $inputData->amount,
            $inputData->startDate,
            $inputData->userId
        );

        $this->incomeRepository->create($income);

        $incomeId = DB::getPdo()->lastInsertId();

        $fixedIncome = FixedIncome::create(
            (int)$incomeId,
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

        $this->fixedIncomeRepository->save($fixedIncome);
    }
}
