<?php

namespace App\Application\UseCase\Category\Income\Update;

use App\Domain\Model\User\UserId;
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
     * @return array
     */
    public function handle(UpdateIncomeCategoryInputData $inputData): array
    {
        $incomeCategory = IncomeCategory::reconstruct(
            $inputData->id,
            new IncomeCategoryName($inputData->name),
            new UserId($inputData->userId)
        );
        
        return $this->repository->edit($incomeCategory);
    }
} 