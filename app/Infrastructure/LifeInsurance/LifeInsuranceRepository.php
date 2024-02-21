<?php

declare(strict_types=1);

namespace App\Infrastructure\LifeInsurance;

use App\Domain\LifeInsurance\LifeInsuranceRepositoryInterface;
use App\Domain\LifeInsurance\LifeInsurance;

class LifeInsuranceRepository implements LifeInsuranceRepositoryInterface {
    
    public function fetchAll(): array
    {
        // todo DBから取得する
        return [
            [
                'id' => 1,
                'name' => '長生きゴールド',
                'fee' => 1000,
                'payment_type' => '月払い',
                'insurance_type' => '定期'
            ],
            [
                'id' => 2,
                'name' => 'もしもの味方',
                'fee' => 12000,
                'payment_type' => '年払',
                'insurance_type' => '定期'
            ],
            [
                'id' => 3,
                'name' => 'コツコツ年金',
                'fee' => 240000,
                'payment_type' => '年払',
                'insurance_type' => '年金'
            ],
            [
                'id' => 4,
                'name' => '安心丸ごと自動車',
                'fee' => 3000,
                'payment_type' => '年払い',
                'insurance_type' => '定期'
            ]
        ];
    }

    public function save(LifeInsurance $lifeInsurance)
    {
        print('保存した');
        // todo DBに保存
    }
}