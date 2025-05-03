<?php

declare(strict_types=1);

namespace App\Domain\Model\FixedIncome;

final class StartDate
{
    private readonly string $value;

    public function __construct(string $value)
    {
        if (!strtotime($value)) {
            throw new \InvalidArgumentException('開始日の形式が正しくありません。');
        }
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
