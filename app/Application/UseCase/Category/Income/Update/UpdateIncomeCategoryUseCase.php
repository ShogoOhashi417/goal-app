<?php

namespace App\Application\UseCase\Category\Income\Update;

use App\Domain\Model\Category\Income\IncomeCategory;
use App\Domain\Model\Category\Income\IncomeCategoryName;
use App\Domain\Model\Category\Income\IncomeCategoryRepositoryInterface;

final class UpdateIncomeCategoryUseCase
{
    private readonly IncomeCategoryRepositoryInterface $repository;

    public function __construct(IncomeCategoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param UpdateIncomeCategoryInputData $inputData
     * @return void
     */
    public function handle(UpdateIncomeCategoryInputData $inputData): void
    {
        $this->repository->edit(
            IncomeCategory::reconstruct(
                $inputData->id,
                new IncomeCategoryName($inputData->name)
            )
        );
    }
} 