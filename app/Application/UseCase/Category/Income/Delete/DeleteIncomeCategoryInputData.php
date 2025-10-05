<?php

namespace App\Application\UseCase\Category\Income\Delete;

class DeleteIncomeCategoryInputData
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
