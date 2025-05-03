<?php

declare(strict_types=1);

namespace App\Domain\Model\FixedExpenditure;

final class StartDate
{
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
        $date = \DateTime::createFromFormat('Y-m-d', $value);
        if (!$date || $date->format('Y-m-d') !== $value) {
            throw new \InvalidArgumentException("Invalid date format for start date: {$value}. Expected format: YYYY-MM-DD");
        }
    }
} 