<?php

namespace App\Application\UseCase\Category\Income\Fetch;

use App\Models\IncomeCategory;

final readonly class FetchIncomeCategoryUseCase
{
    private readonly IncomeCategory $incomeCategory;

    public function __construct(
        IncomeCategory $incomeCategory
    )
    {
        $this->incomeCategory = $incomeCategory;
    }

    /**
     * @return array
     */
    public function handle(): array
    {
        return $this->incomeCategory->fetchAll();
    }
}
