<?php

declare(strict_types=1);

namespace App\Application\UseCase\Income\Create;

use App\Domain\Model\Income\Income;
use App\Domain\Model\Income\IncomeRepositoryInterface;

final class CreateIncomeUseCase
{
    private readonly IncomeRepositoryInterface $incomeRepository;

    public function __construct(
        IncomeRepositoryInterface $incomeRepository
    )
    {
        $this->incomeRepository = $incomeRepository;
    }

    /**
     * @param CreateIncomeInputData $inputData
     * @return void
     */
    public function handle(CreateIncomeInputData $inputData): void
    {
        $income = Income::create(
            $inputData->name,
            $inputData->categoryId,
            $inputData->amount
        );

        $this->incomeRepository->create($income);
    }
}
