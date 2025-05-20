<?php

declare(strict_types=1);

namespace App\Domain\Model\User;

final class UserId
{
    private int $value;

    public function __construct(int $value)
    {
        if ($value <= 0) {
            throw new \InvalidArgumentException('UserIdは正の整数でなければなりません');
        }
        $this->value = $value;
    }

    public function value(): int
    {
        return $this->value;
    }

    public function equals(UserId $other): bool
    {
        return $this->value === $other->value();
    }
} 