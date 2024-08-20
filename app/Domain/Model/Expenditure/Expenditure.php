<?php

declare(strict_types=1);

namespace App\Domain\Model\Expenditure;

final class Expenditure
{
    private readonly int $id;
    private readonly ExpenditureName $name;
    private readonly ExpenditureAmount $amount;

    private function __construct(
        int $id,
        ExpenditureName $name,
        ExpenditureAmount $amount
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
     * @return ExpenditureName
     */
    public function getName(): ExpenditureName
    {
        return $this->name;
    }

    /**
     * @return ExpenditureAmount
     */
    public function getAmount(): ExpenditureAmount
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
            new ExpenditureName($name),
            new ExpenditureAmount($amount)
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
            new ExpenditureName($name),
            new ExpenditureAmount($amount)
        );
    }
}
