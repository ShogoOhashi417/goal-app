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
        print('保存した');
        // todo DBに保存
    }

    /**
     *
     * @param integer $id
     * @return void
     */
    public function remove(int $id): void
    {
        // todo DBから削除
    }
}