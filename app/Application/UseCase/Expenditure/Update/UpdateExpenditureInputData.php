<?php

declare(strict_types=1);

namespace App\Application\UseCase\Expenditure\Update;

final class UpdateExpenditureInputData
{
    public readonly int $id;
    public readonly string $name;
    public readonly int $categoryId;
    public readonly int $amount;

    public function __construct(
        int $id,
        string $name,
        int $categoryId,
        int $amount
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->categoryId = $categoryId;
        $this->amount = $amount;
    }
}
