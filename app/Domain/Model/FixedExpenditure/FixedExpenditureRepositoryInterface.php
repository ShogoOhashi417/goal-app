<?php

declare(strict_types=1);

namespace App\Domain\Model\FixedExpenditure;

interface FixedExpenditureRepositoryInterface
{
    /**
     * @param integer $id
     * @return array
     */
    public function fetchById(int $id): array;

    /**
     * @param FixedExpenditure $fixedExpenditure
     * @return void
     */
    public function create(FixedExpenditure $fixedExpenditure): void;

    /**
     * @param FixedExpenditure $fixedExpenditure
     * @return void
     */
    public function update(FixedExpenditure $fixedExpenditure): void;

    /**
     * @param FixedExpenditure $fixedExpenditure
     * @return void
     */
    public function remove(FixedExpenditure $fixedExpenditure): void;
} 