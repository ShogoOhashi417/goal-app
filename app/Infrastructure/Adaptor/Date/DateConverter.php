<?php

namespace App\Infrastructure\Adaptor\Date;

use DateTime;
use App\Application\Port\Date\DateConverterInterface;

final readonly class DateConverter implements DateConverterInterface
{
    /**
     * @param string $date
     * @return string
     */
    public function toYearMonth(string $date): string
    {
        $dateTime = new DateTime($date);

        return $dateTime->format('Y-m');
    }

    /**
     * @param string $date
     * @return string
     */
    public function toYearMonthDay(string $date): string
    {
        $dateTime = new DateTime($date);

        return $dateTime->format('Y-m-d');
    }
}
