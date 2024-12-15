<?php

namespace App\Application\UseCase\Expenditure\Create;

final class BulkCreateExpenditureInputData
{
    public readonly array $itemList;

    public function __construct(
        array $itemList
    ){
        $this->itemList = $itemList;
    }
}