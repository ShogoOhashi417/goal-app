<?php

declare(strict_types=1);

namespace App\Application\Query\Income;

interface IncomeQueryServiceInterface
{
    public function fetchAll(int $userId): array;
    
    public function fetchOneTimeIncome(string $startDate, string $endDate, int $userId): array;
    
    public function fetchFixedIncome(int $userId): array;
}
