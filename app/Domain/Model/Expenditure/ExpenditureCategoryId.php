<?php

namespace App\Domain\Model\Expenditure;

use Exception;

final readonly class ExpenditureCategoryId
{
    private int $categoryId;

    public function __construct(
        int $categoryId
    )
    {
        $this->assertEmpty($categoryId);
        $this->categoryId = $categoryId;
    }

    /**
     * @return integer
     */
    public function getValue(): int
    {
        return $this->categoryId;
    }

    /**
     * @param integer $categoryId
     * @return void
     */
    private function assertEmpty(int $categoryId): void
    {
        if (!$categoryId) {
            throw new Exception();
        }
    }
}
