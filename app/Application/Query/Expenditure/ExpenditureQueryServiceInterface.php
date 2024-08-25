<?php

declare(strict_types=1);

namespace App\Application\Query\Expenditure;

interface ExpenditureQueryServiceInterface
{
    public function fetchAll(): array;
}
