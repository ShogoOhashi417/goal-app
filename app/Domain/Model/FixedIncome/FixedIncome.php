<?php

declare(strict_types=1);

namespace App\Domain\Model\FixedIncome;

use App\Domain\Model\FixedIncome\PaymentDate;
use App\Domain\Model\FixedIncome\EndDate;
use App\Domain\Model\FixedIncome\StartDate;
use App\Domain\Model\FixedIncome\PaymentMonth;
use App\Domain\Model\FixedIncome\PaymentDay;
use App\Domain\Model\FixedIncome\CycleUnit;
use App\Domain\Model\Income\IncomeAmount;
use App\Domain\Model\Income\IncomeCategoryId;
use App\Domain\Model\Income\IncomeName;

final class FixedIncome
{
	private readonly int $incomeId;
    private readonly IncomeName $name;
    private readonly IncomeCategoryId $categoryId;
    private readonly IncomeAmount $amount;
    private readonly CycleUnit $cycleUnit;
    private readonly PaymentDay $paymentDay;
    private readonly ?PaymentMonth $paymentMonth;
    private readonly StartDate $startDate;
    private readonly ?EndDate $endDate;
    private readonly int $userId;

    private function __construct(
        int $incomeId,
        IncomeName $name,
        IncomeCategoryId $categoryId,
        IncomeAmount $amount,
        CycleUnit $cycleUnit,
        PaymentDay $paymentDay,
        ?PaymentMonth $paymentMonth,
        StartDate $startDate,
        ?EndDate $endDate,
        int $userId
    ) {
        $this->incomeId = $incomeId;
        $this->name = $name;
        $this->categoryId = $categoryId;
        $this->amount = $amount;
        $this->cycleUnit = $cycleUnit;
        $this->paymentDay = $paymentDay;
        $this->paymentMonth = $paymentMonth;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->userId = $userId;
    }

    /**
     * @return integer
     */
    public function getIncomeId(): int
    {
        return $this->incomeId;
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
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param string $name
     * @param int $categoryId
     * @param int $amount
     * @param int $cycleUnit
     * @param int $paymentDay
     * @param ?int $paymentMonth
     * @param string $startDate
     * @param ?string $endDate
     * @param int $userId
     * @return FixedIncome
     */
    public static function create(
		int $incomeId,
        string $name,
        int $categoryId,
        int $amount,
        int $cycleUnit,
        int $paymentDay,
        ?int $paymentMonth,
        string $startDate,
        ?string $endDate,
        int $userId
    ): self {
        return new self(
			$incomeId,
            new IncomeName($name),
            new IncomeCategoryId($categoryId),
            new IncomeAmount($amount),
            CycleUnit::from($cycleUnit),
            new PaymentDay($paymentDay),
            $paymentMonth ? new PaymentMonth($paymentMonth) : null,
            new StartDate($startDate),
            $endDate ? new EndDate($endDate) : null,
            $userId
        );
    }

    /**
     * @param int $id
     * @param string $name
     * @param int $categoryId
     * @param int $amount
     * @param int $cycleUnit
     * @param int $paymentDay
     * @param ?int $paymentMonth
     * @param string $startDate
     * @param ?string $endDate
     * @param int $userId
     * @return FixedIncome
     */
    public static function reconstruct(
        int $id,
        string $name,
        int $categoryId,
        int $amount,
        int $cycleUnit,
        int $paymentDay,
        ?int $paymentMonth,
        string $startDate,
        ?string $endDate,
        int $userId
    ): self {
        return new self(
            $id,
            new IncomeName($name),
            new IncomeCategoryId($categoryId),
            new IncomeAmount($amount),
            CycleUnit::from($cycleUnit),
            new PaymentDay($paymentDay),
            $paymentMonth ? new PaymentMonth($paymentMonth) : null,
            new StartDate($startDate),
            $endDate ? new EndDate($endDate) : null,
            $userId
        );
    }
}
