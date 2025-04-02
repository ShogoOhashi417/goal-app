<?php

declare(strict_types=1);

namespace App\Application\UseCase\FixedExpenditure\Create;

use App\Domain\Model\FixedExpenditure\FixedExpenditure;
use App\Domain\Model\FixedExpenditure\FixedExpenditureRepositoryInterface;
use App\Domain\Model\Expenditure\Expenditure;
use App\Domain\Model\Expenditure\ExpenditureRepositoryInterface;

final class CreateFixedExpenditureUseCase
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
     * @param CreateFixedExpenditureInputData $inputData
     * @return void
     */
    public function handle(CreateFixedExpenditureInputData $inputData): void
    {
        $expenditure = Expenditure::create(
            $inputData->name,
            $inputData->categoryId,
            $inputData->amount,
            $inputData->startDate
        );

        $this->expenditureRepository->create($expenditure);

        $expenditureId = $this->expenditureRepository->getLastInsertId();

        $fixedExpenditure = FixedExpenditure::create(
            $inputData->name,
            $inputData->categoryId,
            $inputData->amount,
            $inputData->cycleUnit,
            $inputData->paymentDay,
            $inputData->paymentMonth,
            $inputData->startDate,
            $inputData->endDate,
            $expenditureId
        );

        $this->fixedExpenditureRepository->create($fixedExpenditure);
    }
} 