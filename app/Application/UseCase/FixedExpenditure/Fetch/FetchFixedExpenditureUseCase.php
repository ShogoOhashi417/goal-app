<?php

declare(strict_types=1);

namespace App\Application\UseCase\FixedExpenditure\Fetch;

use App\Application\Query\FixedExpenditure\FixedExpenditureQueryServiceInterface;
use App\Domain\Model\FixedExpenditure\CycleUnit;

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
		$result = $this->query->fetchAll();

		foreach ($result as $index => $fixedExpenditureData) {
			$result[$index]['cycle_unit_string'] = CycleUnit::toString((int)$fixedExpenditureData['cycle_unit']);
		}

		return $result;
    }
} 