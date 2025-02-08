<?php

namespace App\Application\UseCase\Category\Income\Delete;

class DeleteIncomeCategoryInputData
{
    public int $id;

    public function __construct(
        int $id
    )
    {
        $this->id = $id;
    }
}
