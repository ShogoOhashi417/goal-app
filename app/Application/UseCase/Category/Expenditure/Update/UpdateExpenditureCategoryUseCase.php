<?php

namespace App\Application\UseCase\Category\Expenditure\Update;

use App\Domain\Model\Category\Expenditure\ExpenditureCategory;
use App\Domain\Model\Category\Expenditure\ExpenditureCategoryName;
use App\Domain\Model\Category\Expenditure\ExpenditureCategoryRepositoryInterface;

final class UpdateExpenditureCategoryUseCase
{
    private readonly ExpenditureCategoryRepositoryInterface $repository;

    public function __construct(ExpenditureCategoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param UpdateExpenditureCategoryInputData $inputData
     * @return void
     */
    public function handle(UpdateExpenditureCategoryInputData $inputData): void
    {
        $this->repository->edit(
            ExpenditureCategory::reconstruct(
                $inputData->id,
                new ExpenditureCategoryName($inputData->name)
            )
        );
    }
} 