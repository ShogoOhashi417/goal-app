<?php

declare(strict_types=1);

namespace App\Domain\LifeInsurance;

interface LifeInsuranceRepositoryInterface {
    public function fetchAll(): array;

    public function remove(int $id): void;
}