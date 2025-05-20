<?php

declare(strict_types=1);

namespace App\Domain\Model\Expenditure;

use App\Domain\Model\User\UserId;

final class Expenditure
{
    private readonly int $id;
    private readonly ExpenditureName $name;
    private readonly ExpenditureCategoryId $categoryId;
    private readonly ExpenditureAmount $amount;
    private readonly CalendarDate $calendarDate;
    private readonly UserId $userId;

    private function __construct(
        int $id,
        ExpenditureName $name,
        ExpenditureCategoryId $categoryId,
        ExpenditureAmount $amount,
        CalendarDate $calendarDate,
        UserId $userId
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->categoryId = $categoryId;
        $this->amount = $amount;
        $this->calendarDate = $calendarDate;
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
     * @return ExpenditureName
     */
    public function getName(): ExpenditureName
    {
        return $this->name;
    }

    /**
     * @return ExpenditureCategoryId
     */
    public function getCategoryId(): ExpenditureCategoryId
    {
        return $this->categoryId;
    }

    /**
     * @return ExpenditureAmount
     */
    public function getAmount(): ExpenditureAmount
    {
        return $this->amount;
    }

    /**
     * @return CalendarDate
     */
    public function getCalendarDate(): CalendarDate
    {
        return $this->calendarDate;
    }

    /**
     * @return UserId
     */
    public function getUserId(): UserId
    {
        return $this->userId;
    }

    /**
     * @param string $name
     * @param integer $categoryId
     * @param integer $amount
     * @param string $calendarDate
     * @param integer $userId
     * @return self
     */
    public static function create(
        string $name,
        int $categoryId,
        int $amount,
        string $calendarDate,
        int $userId
    ): self
    {
        return new self(
            0,
            new ExpenditureName($name),
            new ExpenditureCategoryId($categoryId),
            new ExpenditureAmount($amount),
            new CalendarDate($calendarDate),
            new UserId($userId)
        );
    }

    /**
     * @param integer $id
     * @param string $name
     * @param integer $categoryId
     * @param integer $amount
     * @param string $calendarDate
     * @param integer $userId
     * @return self
     */
    public static function reconstruct(
        int $id,
        string $name,
        int $categoryId,
        int $amount,
        string $calendarDate,
        int $userId
    ): self
    {
        return new self(
            $id,
            new ExpenditureName($name),
            new ExpenditureCategoryId($categoryId),
            new ExpenditureAmount($amount),
            new CalendarDate($calendarDate),
            new UserId($userId)
        );
    }
}
