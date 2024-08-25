<?php

declare(strict_types=1);

namespace App\Application\UseCase\Income\Fetch;

use App\Application\Query\Income\IncomeQueryServiceInterface;

final class FetchIncomeUseCase
{
    private readonly IncomeQueryServiceInterface $query;

    public function __construct(
        IncomeQueryServiceInterface $query
    )
    {
        $this->query = $query;
    }

    /**
     * @return void
     */
    public function handle(): array
    {
        return $this->query->fetchAll();
    }
}
