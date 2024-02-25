<?php

declare(strict_types=1);

namespace App\Domain\LifeInsurance;

class LifeInsurance {
    private readonly LifeInsuranceName $lifeInsuranceName;
    private readonly Fee $fee;
    private readonly PaymentType $paymentType;
    private readonly InsuranceType $insuranceType;

    public function __construct(
        LifeInsuranceName $lifeInsuranceName,
        Fee $fee,
        PaymentType $paymentType,
        InsuranceType $insuranceType
    )
    {
        $this->lifeInsuranceName = $lifeInsuranceName;
        $this->fee = $fee;
        $this->paymentType = $paymentType;
        $this->insuranceType = $insuranceType;
    }

    public function getName()
    {
        return $this->lifeInsuranceName;
    }

    public function getFee()
    {
        return $this->fee;
    }

    public function getPaymentType()
    {
        return $this->paymentType;
    }
    
    public function getInsuranceType()
    {
        return $this->insuranceType;
    }
}