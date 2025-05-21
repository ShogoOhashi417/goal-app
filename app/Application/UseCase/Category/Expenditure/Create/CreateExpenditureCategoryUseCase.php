<?php

namespace App\Application\UseCase\Category\Expenditure\Create;

use App\Domain\Model\Category\Expenditure\ExpenditureCategory;
use App\Domain\Model\Category\Expenditure\ExpenditureCategoryName;
use App\Domain\Model\Category\Expenditure\ExpenditureCategoryRepositoryInterface;
use App\Application\UseCase\Category\Expenditure\Create\CreateExpenditureCategoryInputData;
use App\Domain\Model\User\UserId;

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
     * @return array
     */
    public function handle(CreateExpenditureCategoryInputData $inputData): array
    {
        $expenditureCategory = ExpenditureCategory::create(
            new ExpenditureCategoryName($inputData->name),
            new UserId($inputData->userId)
        );

        return $this->repository->save($expenditureCategory);
    }
}
