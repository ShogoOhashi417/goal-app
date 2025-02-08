<?php

declare(strict_types=1);

namespace App\Domain\LifeInsurance;

use Exception;

class LifeInsuranceName {
    private readonly string $name;

    public function __construct(string $name)
    {
        if (!$name) {
            throw new Exception('商品名は1文字以上で入力してください');
        }
        
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }
}