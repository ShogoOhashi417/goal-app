<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\CoversClass;
use App\Application\Port\Date\DateConverterInterface;
use App\Infrastructure\Adaptor\Calculation\CategoryAmountCalculater;

#[CoversClass(CategoryAmountCalculater::class)]
class CategoryAmountCalculaterTest extends TestCase
{
    private CategoryAmountCalculater $sut;
    private DateConverterInterface $date_converter_mock;

    protected function setUp(): void
    {
        $this->date_converter_mock = $this->createMock(DateConverterInterface::class);
        $this->sut = new CategoryAmountCalculater($this->date_converter_mock);
    }

    /**
     * @test
     */
    #[Test]
    public function 同じ年月をカテゴリごとに計算する(): void
    {
        $expected = [
            '食費' => [
                '2023-01' => 1000,
                '2023-02' => 1500,
            ],
            '交通費' => [
                '2023-01' => 1500,
            ],
        ];

        $expenditure_info_list = [
            ['amount' => 1000, 'category_name' => '食費', 'calendar_date' => '2023-01-15'],
            ['amount' => 1500, 'category_name' => '食費', 'calendar_date' => '2023-02-10'],
            ['amount' => 500, 'category_name' => '交通費', 'calendar_date' => '2023-01-20'],
            ['amount' => 1000, 'category_name' => '交通費', 'calendar_date' => '2023-01-20'],
        ];

        $this->date_converter_mock->method('toYearMonth')
            ->willReturnOnConsecutiveCalls('2023-01', '2023-02', '2023-01', '2023-01');

        $actual = $this->sut->calculate($expenditure_info_list);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    #[Test]
    public function 空のリストを渡した場合の計算テスト(): void
    {
        $expected = [];

        $actual = $this->sut->calculate([]);

        $this->assertEquals($expected, $actual);
    }
} 