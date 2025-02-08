<?php

namespace App\Application\UseCase\PresetItem\Create;

use App\Models\PresetExpenditureItem;

readonly class CreatePresetExpenditureItemUseCase
{
    private PresetExpenditureItem $presetExpenditureItem;

    public function __construct(
        PresetExpenditureItem $presetExpenditureItem
    ){
        $this->presetExpenditureItem = $presetExpenditureItem;
    }

    public function handle(CreatePresetExpenditureItemInputData $inputData)
    {
        $this->presetExpenditureItem->upsert(
            $inputData->expenditure_item_map_list,
            ['name'],
            ['category_id']
        );
    }
}