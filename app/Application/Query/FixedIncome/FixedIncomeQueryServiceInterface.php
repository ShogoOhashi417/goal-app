<?php

declare(strict_types=1);

namespace App\Application\Query\FixedIncome;

interface FixedIncomeQueryServiceInterface
{
    /**
     * @return array
     */
    public function fetchAll(): array;
}
