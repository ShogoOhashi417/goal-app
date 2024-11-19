<?php

declare(strict_types=1);

namespace App\Application\UseCase\Income\Delete;

use App\Domain\Model\Income\Income;
use App\Domain\Model\Income\IncomeRepositoryInterface;
use App\Infrastructure\Repository\Income\IncomeRepository;

final class DeleteIncomeUseCase
{
    private readonly IncomeRepositoryInterface $incomeRepository;

    public function __construct(
        IncomeRepositoryInterface $incomeRepository
    )
    {
        $this->incomeRepository = $incomeRepository;
    }

    /**
     * @param DeleteIncomeInputData $inputData
     * @return void
     */
    public function handle(DeleteIncomeInputData $inputData): void
    {
        $incomeInfoList = $this->incomeRepository->fetchById($inputData->id);

        $income = Income::reconstruct(
            $inputData->id,
            $incomeInfoList['name'],
            $incomeInfoList['category_id'],
            $incomeInfoList['amount'],
            $incomeInfoList['calendar_date']
        );
        
        $this->incomeRepository->remove($income);
    }
}
