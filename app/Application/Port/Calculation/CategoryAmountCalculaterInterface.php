<?php

namespace App\Application\Port\Calculation;

interface CategoryAmountCalculaterInterface
{
    public function calculate(array $expenditureInfoList): array;
}
