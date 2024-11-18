<?php

namespace App\Domain\Model\Category\Income;

use App\Domain\Model\Category\Income\IncomeCategoryName;

final class IncomeCategory
{
    private readonly int $id;
    private readonly IncomeCategoryName $name;

    private function __construct(
        int $id,
        IncomeCategoryName $name
    )
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @return integer
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return IncomeCategoryName
     */
    public function getName(): IncomeCategoryName
    {
        return $this->name;
    }

    /**
     * @param IncomeCategoryName $name
     * @return self
     */
    public static function create(
        IncomeCategoryName $name
    ): self {
        return new self(
            0,
            $name
        );
    }

    /**
     * @param integer $id
     * @param IncomeCategoryName $name
     * @return self
     */
    public static function reconstruct(
        int $id,
        IncomeCategoryName $name
    ): self {
        return new self(
            $id,
            $name
        );
    }
}
