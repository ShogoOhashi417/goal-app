<?php

namespace App\Infrastructure\Repository\PresetExpenditureItem;

use App\Models\PresetExpenditureItem;
use App\Domain\Model\Expenditure\ExpenditureHolder;
use App\Domain\Model\PresetExpenditureItem\PresetExpenditureItemRepositoryInterface;

readonly class PresetExpenditureItemRepository implements PresetExpenditureItemRepositoryInterface
{
    private readonly PresetExpenditureItem $presetExpenditureItem;

    public function __construct(
        PresetExpenditureItem $presetExpenditureItem
    ){
        $this->presetExpenditureItem = $presetExpenditureItem;
    }

    /**
     * @param ExpenditureHolder $expenditureHolder
     * @return void
     */
    public function create(ExpenditureHolder $expenditureHolder): void
    {
        $saveDataList = [];

        foreach ($expenditureHolder->getExpenditureList() as $expenditure) {
            $saveDataList[] = [
                'name' => $expenditure->getName()->getValue(),
                'category_id' => $expenditure->getCategoryId()->getValue(),
            ];
        }

        $this->presetExpenditureItem->upsert(
            $saveDataList,
            ['name'],
            ['category_id']
        );
    }
}