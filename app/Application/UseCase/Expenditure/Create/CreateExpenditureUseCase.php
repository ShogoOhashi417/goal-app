<?php

declare(strict_types=1);

namespace App\Application\UseCase\Expenditure\Create;

use App\Domain\Model\Expenditure\Expenditure;
use App\Domain\Model\Expenditure\ExpenditureRepositoryInterface;

final class CreateExpenditureUseCase
{
    private readonly ExpenditureRepositoryInterface $expenditureRepository;

    public function __construct(
        ExpenditureRepositoryInterface $expenditureRepository
    )
    {
        $this->expenditureRepository = $expenditureRepository;
    }

    /**
     * @param CreateExpenditureInputData $inputData
     * @return void
     */
    public function handle(CreateExpenditureInputData $inputData): void
    {
        $expenditure = Expenditure::create(
            $inputData->name,
            $inputData->amount
        );

        $this->expenditureRepository->create($expenditure);
    }
}
