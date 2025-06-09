<?php

declare(strict_types=1);

namespace App\Application\Query\Expenditure;

interface ExpenditureQueryServiceInterface
{
    public function fetchAll(int $userId): array;
    public function fetchByDateRange(string $startDate, string $endDate): array;
}
