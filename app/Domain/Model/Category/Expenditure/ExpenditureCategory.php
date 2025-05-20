<?php

namespace App\Domain\Model\Category\Expenditure;

use App\Domain\Model\User\UserId;

final class ExpenditureCategory
{
    private readonly int $id;
    private readonly ExpenditureCategoryName $name;
    private readonly UserId $userId;

    private function __construct(
        int $id,
        ExpenditureCategoryName $name,
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
     * @return ExpenditureCategoryName
     */
    public function getName(): ExpenditureCategoryName
    {
        return $this->name;
    }

    /**
     * @return UserId
     */
    public function getUserId(): UserId
    {
        return $this->userId;
    }

    /**
     * @param ExpenditureCategoryName $name
     * @param UserId $userId
     * @return self
     */
    public static function create(
        ExpenditureCategoryName $name,
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
     * @param ExpenditureCategoryName $name
     * @param UserId $userId
     * @return self
     */
    public static function reconstruct(
        int $id,
        ExpenditureCategoryName $name,
        UserId $userId
    ): self {
        return new self(
            $id,
            $name,
            $userId
        );
    }
}
