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
        string $name,
        int $fee,
        int $paymentType,
        int $insuranceType
    ) {
        // todo トランザクションをかける

        $lifeInsurance = new LifeInsurance(
            new LifeInsuranceName($name),
            new Fee($fee),
            PaymentType::from($paymentType),
            InsuranceType::from($insuranceType)
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