<?php

declare(strict_types=1);

namespace App\Domain\LifeInsurance;

use Exception;

class Fee {
    private readonly int $fee;

    public function __construct(int $fee)
    {
        if (!$fee) {
            throw new Exception('保険料は1円以上を入力してください');
        }
        
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
}