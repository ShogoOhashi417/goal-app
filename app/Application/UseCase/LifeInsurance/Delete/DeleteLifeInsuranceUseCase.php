<?php

declare(strict_types=1);

namespace App\Application\UseCase\LifeInsurance\Delete;

use App\Domain\LifeInsurance\LifeInsuranceRepositoryInterface;

class DeleteLifeInsuranceUseCase {
    private readonly LifeInsuranceRepositoryInterface $lifeInsuranceRepository;

    public function __construct(LifeInsuranceRepositoryInterface $lifeInsuranceRepository)
    {
        $this->lifeInsuranceRepository = $lifeInsuranceRepository;
    }

    /**
     *
     * @param integer $id
     * @return void
     */
    public function handle(int $id): void
    {
        $this->lifeInsuranceRepository->remove($id);
    }
}