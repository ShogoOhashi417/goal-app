<?php

declare(strict_types=1);

namespace App\Domain\LifeInsurance;

use Exception;

class Fee {
    const SIX_MONTHS = 6;
    const MONTHS_PER_ONE_YEAR = 12;

    private readonly int $fee;

    public function __construct(int $fee)
    {
        $this->fee = $fee;
    }

    /**
     *
     * @return integer
     */
    public function getFee(): int
    {
        return $this->fee;
    }
    
    /**
     *
     * @param integer $amount
     * @param PaymentType $paymentType
     * @return self
     */
    public function add(int $amount, PaymentType $paymentType): self
    {
        if ($paymentType->isYealy()) {
            $added_amount = $this->fee + $amount;
            return new Fee($added_amount);
        }

        if ($paymentType->isHalfYearly()) {
            $added_amount = $this->fee + $amount * self::SIX_MONTHS;
            return new Fee($added_amount);
        }

        if ($paymentType->isMonthly()) {
            $added_amount = $this->fee + $amount * self::MONTHS_PER_ONE_YEAR;
            return new Fee($added_amount);
        }

        return $this;
    }
}