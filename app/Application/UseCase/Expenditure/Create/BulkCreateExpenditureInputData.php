<?php

namespace App\Application\UseCase\Expenditure\Create;

final class BulkCreateExpenditureInputData
{
    public readonly array $itemList;
    public readonly int $userId;

    public function __construct(
        array $itemList,
        int $userId
    ){
        $this->itemList = $itemList;
        $this->userId = $userId;
    }
}