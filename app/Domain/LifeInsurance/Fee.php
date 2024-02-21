<?php

declare(strict_types=1);

namespace App\Domain\LifeInsurance;

class Fee {
    private readonly int $fee;

    public function __construct(int $fee)
    {
        $this->fee = $fee;
    }

    /**
     *
     * @return integer
     */
    public function getFee(): int
    {
        return $this->fee;
    }
}