<?php

declare(strict_types=1);

namespace App\Application\UseCase\Income\Update;

final class UpdateIncomeInputData
{
    public readonly int $id;
    public readonly string $name;
    public readonly int $categoryId;
    public readonly int $amount;
    public readonly string $calendarDate;

    public function __construct(
        int $id,
        string $name,
        int $categoryId,
        int $amount,
        string $calendarDate
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->categoryId = $categoryId;
        $this->amount = $amount;
        $this->calendarDate = $calendarDate;
    }
}
