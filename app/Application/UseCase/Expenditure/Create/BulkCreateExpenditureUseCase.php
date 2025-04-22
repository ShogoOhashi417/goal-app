<?php

namespace App\Application\UseCase\Expenditure\Create;

use App\Domain\Model\Expenditure\Expenditure;
use App\Domain\Model\Expenditure\ExpenditureHolder;
use App\Domain\Model\Expenditure\ExpenditureRepositoryInterface;
use App\Domain\Model\PresetExpenditureItem\PresetExpenditureItemRepositoryInterface;

readonly class BulkCreateExpenditureUseCase
{
    private readonly ExpenditureRepositoryInterface $expenditureRepository;
    private readonly PresetExpenditureItemRepositoryInterface $presetExpenditureItemRepository;

    public function __construct(
        ExpenditureRepositoryInterface $expenditureRepository,
        PresetExpenditureItemRepositoryInterface $presetExpenditureItemRepository
    )
    {
        $this->expenditureRepository = $expenditureRepository;
        $this->presetExpenditureItemRepository = $presetExpenditureItemRepository;
    }

    /**
     * @param BulkCreateExpenditureInputData $inputData
     * @return void
     */
    public function handle(BulkCreateExpenditureInputData $inputData): void
    {
        $expenditureHolder = new ExpenditureHolder();
        $updateExpenditureHolder = new ExpenditureHolder();

        foreach ($inputData->itemList as $item) {
            $isOverwrite = isset($item['id']) && $item['id'] !== '';

            if ($isOverwrite) {
                $updateExpenditureHolder->appendExpenditure(
                    Expenditure::reconstruct(
                        (int)$item['id'],
                        $item['name'],
                        $item['category_id'],
                        $item['amount'],
                        $item['calendar_date']
                    )
                );

                continue;
            }

            $expenditureHolder->appendExpenditure(
                Expenditure::create(
                    $item['name'],
                    $item['category_id'],
                    $item['amount'],
                    $item['calendar_date']
                )
            );
        }

        if ($expenditureHolder->getExpenditureList() !== []) {
            $this->expenditureRepository->saveBulk($expenditureHolder);
            $this->presetExpenditureItemRepository->create($expenditureHolder);
        }

        if ($updateExpenditureHolder->getExpenditureList() !== []) {
            foreach ($updateExpenditureHolder->getExpenditureList() as $expenditure) {
                $this->expenditureRepository->update($expenditure);
            }
        }
    }
}