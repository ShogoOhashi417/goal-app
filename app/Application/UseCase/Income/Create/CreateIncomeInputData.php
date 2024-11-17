<?php

declare(strict_types=1);

namespace App\Application\UseCase\Income\Create;

final class CreateIncomeInputData
{
    public readonly string $name;
    public readonly int $categoryId;
    public readonly int $amount;

    public function __construct(
        string $name,
        int $categoryId,
        int $amount
    )
    {
        $this->name = $name;
        $this->categoryId = $categoryId;
        $this->amount = $amount;
    }
}
