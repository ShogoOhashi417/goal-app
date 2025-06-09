<?php

declare(strict_types=1);

namespace App\Application\UseCase\LifeInsurance\Read;

use App\Domain\LifeInsurance\LifeInsuranceRepositoryInterface;
use App\Application\Service\AuthService;

final class ReadLifeInsuranceUseCase
{
    public function __construct(
        private readonly LifeInsuranceRepositoryInterface $lifeInsuranceRepository,
        private readonly AuthService $authService
    ) {}

    public function handle(): array
    {
        $userId = $this->authService->getCurrentUserId();
        return $this->lifeInsuranceRepository->fetchAll($userId);
    }
}