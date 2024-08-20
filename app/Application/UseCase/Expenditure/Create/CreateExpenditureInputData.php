<?php

declare(strict_types=1);

namespace App\Application\UseCase\Expenditure\Create;

final class CreateExpenditureInputData
{
    public readonly string $name;
    public readonly int $amount;

    public function __construct(
        string $name,
        int $amount
    )
    {
        $this->name = $name;
        $this->amount = $amount;
    }
}
