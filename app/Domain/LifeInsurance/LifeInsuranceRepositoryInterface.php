<?php

declare(strict_types=1);

namespace App\Domain\LifeInsurance;

interface LifeInsuranceRepositoryInterface {
    public function fetchAll(int $userId): array;

    public function remove(int $id): void;
}