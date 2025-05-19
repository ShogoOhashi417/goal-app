<?php

namespace App\Domain\Model\Category\Income;

use App\Domain\Model\Category\Income\IncomeCategoryName;

final class IncomeCategory
{
    private readonly int $id;
    private readonly IncomeCategoryName $name;
    private readonly int $userId;

    private function __construct(
        int $id,
        IncomeCategoryName $name,
        int $userId
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->userId = $userId;
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
     * @return integer
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param IncomeCategoryName $name
     * @param int $userId
     * @return self
     */
    public static function create(
        IncomeCategoryName $name,
        int $userId
    ): self {
        return new self(
            0,
            $name,
            $userId
        );
    }

    /**
     * @param integer $id
     * @param IncomeCategoryName $name
     * @param int $userId
     * @return self
     */
    public static function reconstruct(
        int $id,
        IncomeCategoryName $name,
        int $userId
    ): self {
        return new self(
            $id,
            $name,
            $userId
        );
    }
}
