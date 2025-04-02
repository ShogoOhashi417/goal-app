<?php

declare(strict_types=1);

namespace App\Domain\Model\Expenditure;

interface ExpenditureRepositoryInterface
{
    public function create(Expenditure $income): void;

    public function saveBulk(ExpenditureHolder $expenditureHolder): void;

    public function update(Expenditure $income): void;

    public function remove(Expenditure $income): void;

    public function fetchById(int $id): array;

    public function getLastInsertId(): int;
}
