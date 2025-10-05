<?php

namespace App\Application\UseCase\Category\Income\Create;

final class CreateIncomeCategoryInputData
{
    public readonly string $name;
    public readonly int $userId;

    public function __construct(string $name, int $userId)
    {
        $this->name = $name;
        $this->userId = $userId;
    }
}
