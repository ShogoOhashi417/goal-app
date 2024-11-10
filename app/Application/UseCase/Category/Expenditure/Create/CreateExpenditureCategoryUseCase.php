<?php

namespace App\Application\UseCase\Category\Expenditure\Create;

use App\Domain\Model\Category\Expenditure\ExpenditureCategory;
use App\Domain\Model\Category\Expenditure\ExpenditureCategoryName;
use App\Domain\Model\Category\Expenditure\ExpenditureCategoryRepositoryInterface;

final class CreateExpenditureCategoryUseCase
{
    private readonly ExpenditureCategoryRepositoryInterface $repository;

    public function __construct(
        ExpenditureCategoryRepositoryInterface $repository
    )
    {
        $this->repository = $repository;
    }

    /**
     * @param CreateExpenditureCategoryInputData $inputData
     * @return void
     */
    public function handle(CreateExpenditureCategoryInputData $inputData): void
    {
        $expenditureCategory = new ExpenditureCategory(
            new ExpenditureCategoryName($inputData->name)
        );

        $this->repository->save($expenditureCategory);
    }
}
