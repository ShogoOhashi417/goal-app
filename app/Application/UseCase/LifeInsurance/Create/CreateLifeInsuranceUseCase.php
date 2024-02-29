<?php

declare(strict_types=1);

namespace App\Application\UseCase\LifeInsurance\Create;

use App\Domain\LifeInsurance\LifeInsuranceRepositoryInterface;
use App\Domain\LifeInsurance\LifeInsurance;
use App\Domain\LifeInsurance\LifeInsuranceName;
use App\Domain\LifeInsurance\Fee;
use App\Domain\LifeInsurance\PaymentType;
use App\Domain\LifeInsurance\InsuranceType;

class CreateLifeInsuranceUseCase {
    private readonly LifeInsuranceRepositoryInterface $lifeInsuranceRepository;

    public function __construct(
        LifeInsuranceRepositoryInterface $lifeInsuranceRepository
    ) {
        $this->lifeInsuranceRepository = $lifeInsuranceRepository;
    }

    public function handle(
        int $id,
        string $name,
        int $fee,
        string $paymentType,
        string $insuranceType
    ) {
        // todo トランザクションをかける

        $lifeInsurance = new LifeInsurance(
            $id,
            new LifeInsuranceName($name),
            new Fee($fee),
            PaymentType::fromString($paymentType),
            InsuranceType::fromString($insuranceType)
        );

        try {
            $this->lifeInsuranceRepository->save($lifeInsurance);
        } catch (RuntimeException $exeption) {
            throw $exeption;
        } catch (Exception $exeption) {
            throw $exeption;
        }
    }
}