<?php

namespace App\Application\Port\Date;

interface DateConverterInterface
{
    public function toYearMonth(string $date): string;
    public function toYearMonthDay(string $date): string;
}
