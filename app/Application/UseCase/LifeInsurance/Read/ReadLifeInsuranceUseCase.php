<?php

declare(strict_types=1);

namespace App\Application\UseCase\LifeInsurance\Read;

use App\Domain\LifeInsurance\LifeInsuranceRepositoryInterface;

class ReadLifeInsuranceUseCase {
    private readonly LifeInsuranceRepositoryInterface $lifeInsuranceRepository;

    public function __construct(LifeInsuranceRepositoryInterface $lifeInsuranceRepository)
    {
        $this->lifeInsuranceRepository = $lifeInsuranceRepository;
    }

    public function handle(): array
    {
        return $this->lifeInsuranceRepository->fetchAll();
    }
}