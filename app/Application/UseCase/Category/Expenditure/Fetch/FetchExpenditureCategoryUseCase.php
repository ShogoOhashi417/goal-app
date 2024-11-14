<?php

namespace App\Application\UseCase\Category\Expenditure\Fetch;

use App\Models\ExpenditureCategory;

final readonly class FetchExpenditureCategoryUseCase
{
    private readonly ExpenditureCategory $expenditureCategory;

    public function __construct(
        ExpenditureCategory $expenditureCategory
    )
    {
        $this->expenditureCategory = $expenditureCategory;
    }

    /**
     * @return array
     */
    public function handle(): array
    {
        return $this->expenditureCategory->fetchAll();
    }
}
