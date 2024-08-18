<?php

declare(strict_types=1);

namespace App\Application\UseCase\Income\Delete;

use App\Domain\Model\Income\IncomeRepositoryInterface;
use App\Infrastructure\Repository\Income\IncomeRepository;

final class DeleteIncomeUseCase
{
    private readonly IncomeRepositoryInterface $incomeRepository;

    public function __construct(
        IncomeRepositoryInterface $incomeRepository
    )
    {
        $this->incomeRepository = $incomeRepository;
    }
}
