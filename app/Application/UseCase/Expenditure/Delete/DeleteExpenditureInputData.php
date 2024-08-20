<?php

declare(strict_types=1);

namespace App\Application\UseCase\Expenditure\Delete;

final class DeleteExpenditureInputData
{
    public readonly int $id;

    public function __construct(
        int $id
    )
    {
        $this->id = $id;
    }
}
