<?php

declare(strict_types=1);

namespace App\Domain\Model\Income;

final class Income
{
    private readonly int $id;
    private readonly IncomeName $name;
    private readonly IncomeAmount $amount;

    private function __construct(
        int $id,
        IncomeName $name,
        IncomeAmount $amount
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->amount = $amount;
    }
}
