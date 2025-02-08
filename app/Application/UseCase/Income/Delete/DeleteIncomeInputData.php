<?php

declare(strict_types=1);

namespace App\Application\UseCase\Income\Delete;

final class DeleteIncomeInputData
{
    public readonly int $id;

    public function __construct(
        int $id
    )
    {
        $this->id = $id;
    }
}
