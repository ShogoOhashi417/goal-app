<?php

namespace App\Domain\Model\Category\Income;

use App\Domain\Model\Category\Income\IncomeCategoryName;

final class IncomeCategory
{
    private readonly IncomeCategoryName $name;

    public function __construct(
        IncomeCategoryName $name
    )
    {
        $this->name = $name;
    }

    /**
     * @return IncomeCategoryName
     */
    public function getName(): IncomeCategoryName
    {
        return $this->name;
    }
}
