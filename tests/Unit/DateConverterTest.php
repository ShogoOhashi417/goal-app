<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\CoversClass;
use App\Infrastructure\Adaptor\Date\DateConverter;
use Exception;

#[CoversClass(DateConverter::class)]
class DateConverterTest extends TestCase
{
    private DateConverter $sut;

    protected function setUp(): void
    {
        $this->sut = new DateConverter();
    }

    #[Test]
    public function 日付文字列を年月形式に変換する(): void
    {
        $test_cases = [
            '2023-01-15' => '2023-01',
            '2023-02-28' => '2023-02',
            '2023-12-31' => '2023-12',
            '2023-01-01' => '2023-01',
        ];

        foreach ($test_cases as $input => $expected) {
            $actual = $this->sut->toYearMonth($input);
            $this->assertSame($expected, $actual);
        }
    }

    #[Test]
    public function 日付文字列を年月日形式に変換する(): void
    {
        $test_cases = [
            '2023-01-15' => '2023-01-15',
            '2023-02-28' => '2023-02-28',
            '2023-12-31' => '2023-12-31',
            '2023-01-01' => '2023-01-01',
        ];

        foreach ($test_cases as $input => $expected) {
            $actual = $this->sut->toYearMonthDay($input);
            $this->assertSame($expected, $actual);
        }
    }

    #[Test]
    public function 異なる形式の日付文字列を年月形式に変換する(): void
    {
        $test_cases = [
            '2023/01/15' => '2023-01',
            '2023.02.28' => '2023-02',
            '20231231' => '2023-12',
        ];

        foreach ($test_cases as $input => $expected) {
            $actual = $this->sut->toYearMonth($input);
            $this->assertSame($expected, $actual);
        }
    }

    #[Test]
    public function 異なる形式の日付文字列を年月日形式に変換する(): void
    {
        $test_cases = [
            '2023/01/15' => '2023-01-15',
            '2023.02.28' => '2023-02-28',
            '20231231' => '2023-12-31',
        ];

        foreach ($test_cases as $input => $expected) {
            $actual = $this->sut->toYearMonthDay($input);
            $this->assertSame($expected, $actual);
        }
    }

    #[Test]
    public function 不正な日付文字列が入力された場合にExceptionが発生する(): void
    {
        $invalid_dates = [
            'invalid-date',
            '2023-13-01',
            '2023-02-30',
            'abc123',
        ];

        foreach ($invalid_dates as $invalid_date) {
            $this->expectException(Exception::class);
            $this->sut->toYearMonth($invalid_date);
        }
    }

    #[Test]
    public function 不正な日付文字列が入力された場合に年月日変換でExceptionが発生する(): void
    {
        $invalid_dates = [
            'invalid-date',
            '2023-13-01',
            '2023-02-30',
            'abc123',
        ];

        foreach ($invalid_dates as $invalid_date) {
            $this->expectException(Exception::class);
            $this->sut->toYearMonthDay($invalid_date);
        }
    }
} 