<?php

declare(strict_types=1);

namespace App\Application\UseCase\Expenditure\Create;

final class CreateExpenditureInputData
{
    public readonly string $name;
    public readonly int $categoryId;
    public readonly int $amount;
    public readonly string $calendarDate;
    public readonly int $userId;

    public function __construct(
        string $name,
        int $categoryId,
        int $amount,
        string $calendarDate,
        int $userId
    )
    {
        $this->name = $name;
        $this->categoryId = $categoryId;
        $this->amount = $amount;
        $this->calendarDate = $calendarDate;
        $this->userId = $userId;
    }
}
