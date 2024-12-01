<?php

namespace App\Domain\Model\Expenditure;

final class ExpenditureHolder
{
    private array $expenditureList;

    public function __construct()
    {
        $this->expenditureList = [];
    }

    /**
     * @return array
     */
    public function getExpenditureList(): array
    {
        return $this->expenditureList;
    }

    /**
     * @param Expenditure $expenditure
     * @return void
     */
    public function appendExpenditure(Expenditure $expenditure): void
    {
        $this->expenditureList[] = $expenditure;
    }
}