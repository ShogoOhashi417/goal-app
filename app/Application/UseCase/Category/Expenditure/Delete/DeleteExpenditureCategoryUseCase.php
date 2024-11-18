<?php

namespace App\Application\UseCase\Category\Expenditure\Delete;

use App\Domain\Model\Category\Expenditure\ExpenditureCategory;
use App\Domain\Model\Category\Expenditure\ExpenditureCategoryName;
use App\Domain\Model\Category\Expenditure\ExpenditureCategoryRepositoryInterface;

final class DeleteExpenditureCategoryUseCase
{
    private readonly ExpenditureCategoryRepositoryInterface $repository;

    public function __construct(
        ExpenditureCategoryRepositoryInterface $repository
    )
    {
        $this->repository = $repository;
    }

    /**
     * @return void
     */
    public function handle(DeleteExpenditureCategoryInputData $inputData): void
    {
        $expenditureCategoryInfoList = $this->repository->fetchById(
            $inputData->id
        );

        $this->repository->remove(
            ExpenditureCategory::reconstruct(
                $inputData->id,
                new ExpenditureCategoryName($expenditureCategoryInfoList[0]['name'])
            )
        );
    }
}
