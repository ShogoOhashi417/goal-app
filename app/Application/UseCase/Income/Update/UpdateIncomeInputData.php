<?php

declare(strict_types=1);

namespace App\Application\UseCase\Income\Update;

final class UpdateIncomeInputData
{
    public readonly int $id;
    public readonly string $name;
    public readonly int $amount;

    public function __construct(
        int $id,
        string $name,
        int $amount
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->amount = $amount;
    }
}
