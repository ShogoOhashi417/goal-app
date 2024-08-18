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

    /**
     * @param string $name
     * @param integer $amount
     * @return self
     */
    public static function create(
        string $name,
        int $amount
    ): self
    {
        return new self(
            0,
            new IncomeName($name),
            new IncomeAmount($amount)
        );
    }
}
