<?php

declare(strict_types=1);

namespace App\Infrastructure\LifeInsurance;

use App\Domain\LifeInsurance\LifeInsuranceRepositoryInterface;
use App\Domain\LifeInsurance\LifeInsurance;
use App\Models\LifeInsurance as LifeInsuranceModel;

class LifeInsuranceRepository implements LifeInsuranceRepositoryInterface {
    
    public function fetchAll(): array
    {
        return LifeInsuranceModel::all()->toArray();
    }

    public function save(LifeInsurance $lifeInsurance)
    {
        LifeInsuranceModel::create([
            'name' => $lifeInsurance->getName()->getName(),
            'fee' => $lifeInsurance->getFee()->getFee(),
            'payment_type' => $lifeInsurance->getPaymentType()->value,
            'type' => $lifeInsurance->getInsuranceType()->value
        ]);
    }

    /**
     *
     * @param integer $id
     * @return void
     */
    public function remove(int $id): void
    {
        LifeInsuranceModel::where('id', $id)->delete();
    }
}