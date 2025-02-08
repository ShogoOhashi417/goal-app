<?php

namespace App\Domain\Model\Category\Income;

final class IncomeCategoryName
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
