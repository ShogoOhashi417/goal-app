<?php

declare(strict_types=1);

namespace App\Domain\LifeInsurance;

class LifeInsurance {
    const TEMPORARY_ID = 0;

    private readonly int $id;
    private readonly LifeInsuranceName $lifeInsuranceName;
    private readonly Fee $fee;
    private readonly PaymentType $paymentType;
    private readonly InsuranceType $insuranceType;

    public function __construct(
        int $id,
        LifeInsuranceName $lifeInsuranceName,
        Fee $fee,
        PaymentType $paymentType,
        InsuranceType $insuranceType
    )
    {
        $this->id = $id;
        $this->lifeInsuranceName = $lifeInsuranceName;
        $this->fee = $fee;
        $this->paymentType = $paymentType;
        $this->insuranceType = $insuranceType;
    }

    public function getId()
    {
        return $this->id;
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

    public function isEdit()
    {
        return $this->id !== self::TEMPORARY_ID;
    }
}