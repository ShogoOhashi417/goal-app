<?php

namespace App\Application\UseCase\Category\Expenditure\Create;

final class CreateExpenditureCategoryInputData
{
    public readonly string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }
}
