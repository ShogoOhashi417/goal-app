<?php

declare(strict_types=1);

namespace App\Domain\Model\Income;

use App\Domain\Model\User\UserId;

final class Income
{
    private readonly int $id;
    private readonly IncomeName $name;
    private readonly IncomeCategoryId $categoryId;
    private readonly IncomeAmount $amount;
    private readonly CalendarDate $calendarDate;
    private readonly UserId $userId;

    private function __construct(
        int $id,
        IncomeName $name,
        IncomeCategoryId $categoryId,
        IncomeAmount $amount,
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
     * @return IncomeName
     */
    public function getName(): IncomeName
    {
        return $this->name;
    }

    /**
     * @return IncomeCategoryId
     */
    public function getCategoryId(): IncomeCategoryId
    {
        return $this->categoryId;
    }

    /**
     * @return IncomeAmount
     */
    public function getAmount(): IncomeAmount
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
            new IncomeName($name),
            new IncomeCategoryId($categoryId),
            new IncomeAmount($amount),
            new CalendarDate($calendarDate),
            new UserId($userId)
        );
    }

    /**
     * @param integer $id
     * @param string $name
     * @param integer $categoryId
     * @param integer $amount
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
            new IncomeName($name),
            new IncomeCategoryId($categoryId),
            new IncomeAmount($amount),
            new CalendarDate($calendarDate),
            new UserId($userId)
        );
    }
}
