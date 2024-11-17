<?php

declare(strict_types=1);

namespace App\Application\UseCase\Expenditure\Update;

use App\Domain\Model\Expenditure\Expenditure;
use App\Domain\Model\Expenditure\ExpenditureRepositoryInterface;

final class UpdateExpenditureUseCase
{
    private readonly ExpenditureRepositoryInterface $expenditureRepository;

    public function __construct(
        ExpenditureRepositoryInterface $expenditureRepository
    )
    {
        $this->expenditureRepository = $expenditureRepository;
    }

    public function handle(UpdateExpenditureInputData $inputData)
    {
        $expenditure = Expenditure::reconstruct(
            $inputData->id,
            $inputData->name,
            $inputData->categoryId,
            $inputData->amount
        );

        $this->expenditureRepository->update($expenditure);
    }
}
