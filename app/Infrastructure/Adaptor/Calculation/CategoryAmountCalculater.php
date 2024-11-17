<?php

namespace App\Infrastructure\Adaptor\Calculation;

use App\Application\Port\Calculation\CategoryAmountCalculaterInterface;

final class CategoryAmountCalculater implements CategoryAmountCalculaterInterface
{
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

            if (isset($result[$categoryName])) {
                $result[$categoryName] += $amount;

                continue;
            }

            $result[$categoryName] = $amount;
        }

        return $result;
    }
}
