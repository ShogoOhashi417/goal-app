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
     * @return integer
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return IncomeName
     */
    public function getName(): IncomeName
    {
        return $this->name;
    }

    /**
     * @return IncomeAmount
     */
    public function getAmount(): IncomeAmount
    {
        return $this->amount;
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

    /**
     * @param integer $id
     * @param string $name
     * @param integer $amount
     * @return self
     */
    public static function reconstruct(
        int $id,
        string $name,
        int $amount
    ): self
    {
        return new self(
            $id,
            new IncomeName($name),
            new IncomeAmount($amount)
        );
    }
}
