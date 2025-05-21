<?php

namespace App\Application\UseCase\Category\Income\Create;

use App\Domain\Model\Category\Income\IncomeCategory;
use App\Domain\Model\Category\Income\IncomeCategoryName;
use App\Domain\Model\Category\Income\IncomeCategoryRepositoryInterface;
use App\Domain\Model\User\UserId;

final class CreateIncomeCategoryUseCase
{
    private readonly IncomeCategoryRepositoryInterface $repository;

    public function __construct(
        IncomeCategoryRepositoryInterface $repository
    )
    {
        $this->repository = $repository;
    }

    public function handle(CreateIncomeCategoryInputData $inputData): array
    {
        $incomeCategory = IncomeCategory::create(
            new IncomeCategoryName($inputData->name),
            new UserId($inputData->userId)
        );

        return $this->repository->save($incomeCategory);
    }
}
