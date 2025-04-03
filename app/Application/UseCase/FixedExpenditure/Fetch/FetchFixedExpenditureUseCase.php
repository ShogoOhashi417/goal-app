<?php

declare(strict_types=1);

namespace App\Application\UseCase\FixedExpenditure\Fetch;

use App\Application\Query\FixedExpenditure\FixedExpenditureQueryServiceInterface;

final readonly class FetchFixedExpenditureUseCase
{
    public function __construct(
        private readonly FixedExpenditureQueryServiceInterface $query
    )
    {}

    /**
     * @return array
     */
    public function handle(): array
    {
        return $this->query->fetchAll();
    }
} 