<?php

namespace App\Domain\Model\Category\Expenditure;

final class ExpenditureCategory
{
    private readonly ExpenditureCategoryName $name;

    public function __construct(
        ExpenditureCategoryName $name
    )
    {
        $this->name = $name;
    }

    /**
     * @return ExpenditureCategoryName
     */
    public function getName(): ExpenditureCategoryName
    {
        return $this->name;
    }
}
