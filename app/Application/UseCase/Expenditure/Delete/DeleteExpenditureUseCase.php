<?php

declare(strict_types=1);

namespace App\Application\UseCase\Expenditure\Delete;

use App\Domain\Model\Expenditure\Expenditure;
use App\Domain\Model\Expenditure\ExpenditureRepositoryInterface;

final class DeleteExpenditureUseCase
{
    private readonly ExpenditureRepositoryInterface $expenditureRepository;

    public function __construct(
        ExpenditureRepositoryInterface $expenditureRepository
    )
    {
        $this->expenditureRepository = $expenditureRepository;
    }

    /**
     * @param DeleteExpenditureInputData $inputData
     * @return void
     */
    public function handle(DeleteExpenditureInputData $inputData): void
    {
        $expenditureInfoList = $this->expenditureRepository->fetchById($inputData->id);

        $expenditure = Expenditure::reconstruct(
            $inputData->id,
            $expenditureInfoList['name'],
            $expenditureInfoList['amount']
        );
        
        $this->expenditureRepository->remove($expenditure);
    }
}
