<?php

declare(strict_types=1);

namespace App\Domain\Model\FixedExpenditure;

final class CycleUnit
{
    public const MONTHLY = 'month';
    public const YEARLY = 'year';

    /**
     * @param string $value
     */
    public function __construct(
        private readonly string $value
    )
    {
        $this->validate($value);
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     * @return void
     */
    private function validate(string $value): void
    {
        $allowedValues = [self::MONTHLY, self::YEARLY];
        
        if (!in_array($value, $allowedValues)) {
            throw new \InvalidArgumentException("Invalid cycle unit value: {$value}");
        }
    }
} 