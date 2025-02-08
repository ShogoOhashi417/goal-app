<?php

namespace App\Application\UseCase\Category\Expenditure\Create;

use App\Domain\Model\Category\Expenditure\ExpenditureCategory;
use App\Domain\Model\Category\Expenditure\ExpenditureCategoryName;
use App\Domain\Model\Category\Expenditure\ExpenditureCategoryRepositoryInterface;
use App\Application\UseCase\Category\Expenditure\Create\CreateExpenditureCategoryInputData;

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
        $expenditureCategory = ExpenditureCategory::create(
            new ExpenditureCategoryName($inputData->name)
        );

        $this->repository->save($expenditureCategory);
    }
}
