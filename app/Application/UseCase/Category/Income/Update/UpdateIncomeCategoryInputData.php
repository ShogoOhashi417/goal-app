<?php

declare(strict_types=1);

namespace App\Application\UseCase\Category\Income\Update;

final class UpdateIncomeCategoryInputData
{
    public function __construct(
        public readonly int $id,
        public readonly string $name
    ) {}
} 