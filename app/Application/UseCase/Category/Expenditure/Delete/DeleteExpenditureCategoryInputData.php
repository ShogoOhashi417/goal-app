<?php

namespace App\Application\UseCase\Category\Expenditure\Delete;

final readonly class DeleteExpenditureCategoryInputData
{
    public int $id;
    public int $userId;

    public function __construct(
        int $id,
        int $userId
    )
    {
        $this->id = $id;
        $this->userId = $userId;
    }
}
