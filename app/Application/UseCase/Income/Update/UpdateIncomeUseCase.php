<?php

declare(strict_types=1);

namespace App\Application\UseCase\Income\Update;

use App\Domain\Model\Income\Income;
use App\Domain\Model\Income\IncomeRepositoryInterface;

final class UpdateIncomeUseCase
{
    private readonly IncomeRepositoryInterface $incomeRepository;

    public function __construct(
        IncomeRepositoryInterface $incomeRepository
    )
    {
        $this->incomeRepository = $incomeRepository;
    }

    public function handle(UpdateIncomeInputData $inputData)
    {
        $income = Income::reconstruct(
            $inputData->id,
            $inputData->name,
            $inputData->categoryId,
            $inputData->amount,
            $inputData->calendarDate
        );

        $this->incomeRepository->update($income);
    }
}
