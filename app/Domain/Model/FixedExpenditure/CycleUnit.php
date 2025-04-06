<?php

namespace App\Domain\Model\FixedExpenditure;

enum CycleUnit: int
{
    case MONTHLY = 1;
    case YEARLY = 2;
}