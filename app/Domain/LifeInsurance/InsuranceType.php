<?php

declare(strict_types=1);

namespace App\Domain\LifeInsurance;

enum InsuranceType: int {
    case Term = 1;
    case TotalLlfe = 2;
    case Endowment = 3;

    public static function fromString(string $string)
    {
        return match ($string) {
            '定期保険' => self::Term,
            '終身保険' => self::TotalLlfe,
            '養老保険' => self::Endowment
        };
    }

    public function toString()
    {
        return match ($this) {
            self::Term =>  '定期保険',
            self::TotalLlfe => '終身保険' ,
            self::Endowment => '養老保険'
        };
    }
}