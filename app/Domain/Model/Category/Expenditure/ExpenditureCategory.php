<?php

namespace App\Domain\Model\Category\Expenditure;

final class ExpenditureCategory
{
    private readonly int $id;
    private readonly ExpenditureCategoryName $name;

    private function __construct(
        int $id,
        ExpenditureCategoryName $name
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
     * @return ExpenditureCategoryName
     */
    public function getName(): ExpenditureCategoryName
    {
        return $this->name;
    }

    /**
     * @param ExpenditureCategoryName $name
     * @return self
     */
    public static function create(
        ExpenditureCategoryName $name
    ): self {
        return new self(
            0,
            $name
        );
    }

    /**
     * @param integer $id
     * @param ExpenditureCategoryName $name
     * @return self
     */
    public static function reconstruct(
        int $id,
        ExpenditureCategoryName $name
    ): self {
        return new self(
            $id,
            $name
        );
    }
}
