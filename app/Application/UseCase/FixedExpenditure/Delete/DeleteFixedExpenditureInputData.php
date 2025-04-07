<?php

declare(strict_types=1);

namespace App\Application\UseCase\FixedExpenditure\Delete;

final class DeleteFixedExpenditureInputData
{
    /**
     * @param int $id
     */
    public function __construct(
        public readonly int $id
    )
    {
    }
} 