<?php

declare(strict_types=1);

namespace App\Domain\Model\FixedIncome;

use App\Domain\Model\FixedIncome\FixedIncome;

interface FixedIncomeRepositoryInterface
{
    public function findById(int $id): ?FixedIncome;
    
    public function save(FixedIncome $fixedIncome): void;

	public function update(FixedIncome $fixedIncome): void;
    
    public function delete(FixedIncome $fixedIncome): void;
}
