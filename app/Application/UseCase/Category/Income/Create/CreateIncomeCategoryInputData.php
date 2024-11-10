<?php

namespace App\Application\UseCase\Category\Income\Create;

final class CreateIncomeCategoryInputData
{
    public readonly string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }
}
