<?php

namespace App\Domain\Model\Category\Income;

use App\Domain\Model\User\UserId;
use App\Domain\Model\Category\Income\IncomeCategoryName;

final class IncomeCategory
{
    private readonly int $id;
    private readonly IncomeCategoryName $name;
    private readonly UserId $userId;

    private function __construct(
        int $id,
        IncomeCategoryName $name,
        UserId $userId
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
     * @return \App\Domain\Model\User\UserId
     */
    public function getUserId(): \App\Domain\Model\User\UserId
    {
        return $this->userId;
    }

    /**
     * @param IncomeCategoryName $name
     * @param UserId $userId
     * @return self
     */
    public static function create(
        IncomeCategoryName $name,
        UserId $userId
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
     * @param UserId $userId
     * @return self
     */
    public static function reconstruct(
        int $id,
        IncomeCategoryName $name,
        UserId $userId
    ): self {
        return new self(
            $id,
            $name,
            $userId
        );
    }
}
