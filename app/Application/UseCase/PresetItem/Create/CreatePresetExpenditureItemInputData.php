<?php

namespace App\Application\UseCase\PresetItem\Create;

final readonly class CreatePresetExpenditureItemInputData 
{
    public array $expenditure_item_map_list;

    public function __construct(
        array $expenditure_item_map_list
    ){
        $this->expenditure_item_map_list = $expenditure_item_map_list;
    }
}