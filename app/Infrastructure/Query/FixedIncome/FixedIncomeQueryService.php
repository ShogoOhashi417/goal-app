<?php

declare(strict_types=1);

namespace App\Infrastructure\Query\FixedIncome;

use App\Models\FixedIncome AS FixedIncomeModel;
use App\Application\Query\FixedIncome\FixedIncomeQueryServiceInterface;
use Illuminate\Support\Facades\Auth;

final readonly class FixedIncomeQueryService implements FixedIncomeQueryServiceInterface
{
    public function __construct(
        private readonly FixedIncomeModel $fixedIncomeModel
    )
    {}

    /**
     * @param int $userId
     * @return array
     */
    public function fetchAll(int $userId): array
    {
        return $this->fixedIncomeModel->fetchAll($userId)
            ->get()
            ->toArray();
    }
}
