<?php

declare(strict_types=1);

namespace App\Application\UseCase\Expenditure\Fetch;

use App\Application\Query\Expenditure\ExpenditureQueryServiceInterface;

final class FetchExpenditureUseCase
{
    private readonly ExpenditureQueryServiceInterface $query;

    public function __construct(
        ExpenditureQueryServiceInterface $query
    )
    {
        $this->query = $query;
    }

    /**
     * @return array
     */
    public function handle(): array
    {
        return $this->query->fetchAll();
    }
}
