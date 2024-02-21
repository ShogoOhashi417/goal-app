<?php

declare(strict_types=1);

namespace App\Domain\LifeInsurance;

class LifeInsuranceName {
    private readonly string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }
}