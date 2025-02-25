<?php

declare(strict_types=1);

namespace App\Application\UseCase\Category\Expenditure\Update;

final class UpdateExpenditureCategoryInputData
{
    public function __construct(
        public readonly int $id,
        public readonly string $name
    ) {}
}
