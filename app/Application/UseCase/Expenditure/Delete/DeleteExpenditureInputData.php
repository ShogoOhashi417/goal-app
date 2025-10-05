<?php

declare(strict_types=1);

namespace App\Application\UseCase\Expenditure\Delete;

final class DeleteExpenditureInputData
{
    public readonly int $id;
    public readonly int $userId;

    public function __construct(
        int $id,
        int $userId
    )
    {
        $this->id = $id;
        $this->userId = $userId;
    }
}
