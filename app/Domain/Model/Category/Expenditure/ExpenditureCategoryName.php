<?php

namespace App\Domain\Model\Category\Expenditure;

final class ExpenditureCategoryName
{
    private readonly string $name;

    public function __construct(
        string $name
    )
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->name;
    }
}
