<?php

declare(strict_types=1);

namespace App\Application\Query\FixedIncome;

interface FixedIncomeQueryServiceInterface
{
    /**
     * @param int $userId
     * @return array
     */
    public function fetchAll(int $userId): array;
}
