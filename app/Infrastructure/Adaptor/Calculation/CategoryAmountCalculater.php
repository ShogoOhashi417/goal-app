<?php

namespace App\Infrastructure\Adaptor\Calculation;

use App\Application\Port\Date\DateConverterInterface;
use App\Application\Port\Calculation\CategoryAmountCalculaterInterface;

final readonly class CategoryAmountCalculater implements CategoryAmountCalculaterInterface
{
    private DateConverterInterface $dateConverter;

    public function __construct(
        DateConverterInterface $dateConverter
    ){
        $this->dateConverter = $dateConverter;
    }

    /**
     * @param array $expenditureInfoList
     * @return array
     */
    public function calculate(array $expenditureInfoList): array
    {
        $result = [];

        foreach ($expenditureInfoList as $expenditureInfo) {
            $amount = $expenditureInfo['amount'];
            $categoryName = $expenditureInfo['category_name'];
            $calendarDate = $expenditureInfo['calendar_date'];

            $year_month = $this->dateConverter->toYearMonth($calendarDate);

            if (isset($result[$categoryName][$year_month])) {
                $result[$categoryName][$year_month] += $amount;

                continue;
            }

            $result[$categoryName][$year_month] = $amount;
        }

        return $result;
    }
}
