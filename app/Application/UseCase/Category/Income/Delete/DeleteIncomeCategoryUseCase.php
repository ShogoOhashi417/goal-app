<?php

namespace App\Application\UseCase\Category\Income\Delete;

use App\Domain\Model\User\UserId;
use App\Domain\Model\Category\Income\IncomeCategory;
use App\Domain\Model\Category\Income\IncomeCategoryName;
use App\Domain\Model\Category\Income\IncomeCategoryRepositoryInterface;

final readonly class DeleteIncomeCategoryUseCase
{
    private readonly IncomeCategoryRepositoryInterface $repository;

    public function __construct(
        IncomeCategoryRepositoryInterface $repository
    )
    {
        $this->repository = $repository;
    }

    /**
     * @return void
     */
    public function handle(DeleteIncomeCategoryInputData $inputData): void
    {
        $IncomeCategoryInfoList = $this->repository->fetchById(
            $inputData->id,
            $inputData->userId
        );

        $this->repository->remove(
            IncomeCategory::reconstruct(
                $inputData->id,
                new IncomeCategoryName($IncomeCategoryInfoList[0]['name'] ?? ''),
                new UserId($inputData->userId)
            )
        );
    }
}
