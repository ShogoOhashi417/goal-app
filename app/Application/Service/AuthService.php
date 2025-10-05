<?php

declare(strict_types=1);

namespace App\Application\Service;

final class AuthService
{
    public function getCurrentUserId(): int
    {
        return auth()->user()->id;
    }
} 