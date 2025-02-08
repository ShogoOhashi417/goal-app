<?php

namespace App\Domain\Model\PresetExpenditureItem;

use App\Domain\Model\Expenditure\ExpenditureHolder;

interface PresetExpenditureItemRepositoryInterface
{
    public function create(ExpenditureHolder $expenditureHolder): void;
}