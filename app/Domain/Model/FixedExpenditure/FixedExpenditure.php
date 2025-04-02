<?php

declare(strict_types=1);

namespace App\Domain\Model\FixedExpenditure;

use App\Domain\Model\FixedExpenditure\PaymentDate;
use App\Domain\Model\FixedExpenditure\EndDate;
use App\Domain\Model\FixedExpenditure\StartDate;
use App\Domain\Model\FixedExpenditure\PaymentMonth;
use App\Domain\Model\FixedExpenditure\PaymentDay;
use App\Domain\Model\FixedExpenditure\CycleUnit;
use App\Domain\Model\Expenditure\ExpenditureAmount;
use App\Domain\Model\Expenditure\ExpenditureCategoryId;
use App\Domain\Model\Expenditure\ExpenditureName;

final class FixedExpenditure
{
    private readonly int $id;
    private readonly ExpenditureName $name;
    private readonly ExpenditureCategoryId $categoryId;
    private readonly ExpenditureAmount $amount;
    private readonly CycleUnit $cycleUnit;
    private readonly PaymentDay $paymentDay;
    private readonly ?PaymentMonth $paymentMonth;
    private readonly StartDate $startDate;
    private readonly ?EndDate $endDate;
    private readonly int $expenditureId;

    private function __construct(
        int $id,
        ExpenditureName $name,
        ExpenditureCategoryId $categoryId,
        ExpenditureAmount $amount,
        CycleUnit $cycleUnit,
        PaymentDay $paymentDay,
        ?PaymentMonth $paymentMonth,
        StartDate $startDate,
        ?EndDate $endDate,
        int $expenditureId
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->categoryId = $categoryId;
        $this->amount = $amount;
        $this->cycleUnit = $cycleUnit;
        $this->paymentDay = $paymentDay;
        $this->paymentMonth = $paymentMonth;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->expenditureId = $expenditureId;
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
     * @return CycleUnit
     */
    public function getCycleUnit(): CycleUnit
    {
        return $this->cycleUnit;
    }

    /**
     * @return PaymentDay
     */
    public function getPaymentDay(): PaymentDay
    {
        return $this->paymentDay;
    }

    /**
     * @return PaymentMonth|null
     */
    public function getPaymentMonth(): ?PaymentMonth
    {
        return $this->paymentMonth;
    }

    /**
     * @return StartDate
     */
    public function getStartDate(): StartDate
    {
        return $this->startDate;
    }

    /**
     * @return EndDate|null
     */
    public function getEndDate(): ?EndDate
    {
        return $this->endDate;
    }

    /**
     * @return int
     */
    public function getExpenditureId(): int
    {
        return $this->expenditureId;
    }

    /**
     * @param string $name
     * @param int $categoryId
     * @param int $amount
     * @param string $cycleUnit
     * @param int $paymentDay
     * @param ?int $paymentMonth
     * @param string $startDate
     * @param ?string $endDate
     * @param int $expenditureId
     * @return FixedExpenditure
     */
    public static function create(
        string $name,
        int $categoryId,
        int $amount,
        string $cycleUnit,
        int $paymentDay,
        ?int $paymentMonth,
        string $startDate,
        ?string $endDate,
        int $expenditureId
    ): self {
        return new self(
            0,
            new ExpenditureName($name),
            new ExpenditureCategoryId($categoryId),
            new ExpenditureAmount($amount),
            new CycleUnit($cycleUnit),
            new PaymentDay($paymentDay),
            $paymentMonth ? new PaymentMonth($paymentMonth) : null,
            new StartDate($startDate),
            $endDate ? new EndDate($endDate) : null,
            $expenditureId
        );
    }
} 