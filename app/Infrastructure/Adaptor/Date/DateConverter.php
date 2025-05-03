<?php

namespace App\Infrastructure\Adaptor\Date;

use DateTime;
use Exception;
use App\Application\Port\Date\DateConverterInterface;

final readonly class DateConverter implements DateConverterInterface
{
    /**
     * @param string $date
     * @return string
     */
    public function toYearMonth(string $date): string
    {
        $dateTime = $this->parseDate($date);

        return $dateTime->format('Y-m');
    }

    /**
     * @param string $date
     * @return string
     */
    public function toYearMonthDay(string $date): string
    {
        $dateTime = $this->parseDate($date);

        return $dateTime->format('Y-m-d');
    }

    /**
     * 様々な形式の日付文字列をパースする
     *
     * @param string $date
     * @return DateTime
     * @throws Exception 不正な日付形式の場合
     */
    private function parseDate(string $date): DateTime
    {
        // 数字のみの形式 (YYYYMMDD) を処理
        if (preg_match('/^\d{8}$/', $date)) {
            return DateTime::createFromFormat('Ymd', $date);
        }
        
        // ドット区切りの形式 (YYYY.MM.DD) を処理
        if (str_contains($date, '.')) {
            $parts = explode('.', $date);
            if (count($parts) === 3) {
                return DateTime::createFromFormat('Y.m.d', $date);
            }
        }
        
        // スラッシュ区切りの形式 (YYYY/MM/DD) を処理
        if (str_contains($date, '/')) {
            $parts = explode('/', $date);
            if (count($parts) === 3) {
                return DateTime::createFromFormat('Y/m/d', $date);
            }
        }
        
        // 標準形式 (YYYY-MM-DD) またはその他の形式
        return new DateTime($date);
    }
}
