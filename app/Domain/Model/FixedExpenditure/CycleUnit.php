<?php

namespace App\Domain\Model\FixedExpenditure;

enum CycleUnit: int
{
    case MONTHLY = 1;
    case YEARLY = 2;

	public static function toString(int $cycleUnit): string
	{
		return match ($cycleUnit) {
			self::MONTHLY->value => "月払い",
			self::YEARLY->value => "年払い",
			default => "不明",
		};
	}
}