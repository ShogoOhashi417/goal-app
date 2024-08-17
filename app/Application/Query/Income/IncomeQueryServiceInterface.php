<?php

declare(strict_types=1);

namespace App\Application\Query\Income;

interface IncomeQueryServiceInterface
{
    public function fetchAll(): array;
}
