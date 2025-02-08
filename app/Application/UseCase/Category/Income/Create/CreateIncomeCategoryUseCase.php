<?php

namespace App\Application\UseCase\Category\Income\Create;

use App\Domain\Model\Category\Income\IncomeCategory;
use App\Domain\Model\Category\Income\IncomeCategoryName;
use App\Domain\Model\Category\Income\IncomeCategoryRepositoryInterface;

final class CreateIncomeCategoryUseCase
{
    private readonly IncomeCategoryRepositoryInterface $repository;

    public function __construct(
        IncomeCategoryRepositoryInterface $repository
    )
    {
        $this->repository = $repository;
    }

    public function handle(CreateIncomeCategoryInputData $inputData)
    {
        $incomeCategory = IncomeCategory::create(
            new IncomeCategoryName($inputData->name)
        );

        $this->repository->save($incomeCategory);
    }
}
