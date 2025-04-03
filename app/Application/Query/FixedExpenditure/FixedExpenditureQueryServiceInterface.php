<?php

declare(strict_types=1);

namespace App\Application\Query\FixedExpenditure;

interface FixedExpenditureQueryServiceInterface
{
    public function fetchAll(): array;
} 