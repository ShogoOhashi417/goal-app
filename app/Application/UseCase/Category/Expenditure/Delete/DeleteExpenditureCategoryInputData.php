<?php

namespace App\Application\UseCase\Category\Expenditure\Delete;

final readonly class DeleteExpenditureCategoryInputData
{
    public int $id;

    public function __construct(
        int $id
    )
    {
        $this->id = $id;
    }
}
