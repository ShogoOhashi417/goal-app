<?php

namespace App\Application\Port\Date;

interface DateConverterInterface
{
    public function toYearMonth(string $date): string;
}
