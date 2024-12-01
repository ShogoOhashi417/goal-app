<?php

namespace App\Application\UseCase\CSV\Import;

use App\Domain\Model\Expenditure\Expenditure;
use App\Domain\Model\Expenditure\ExpenditureHolder;
use App\Application\Port\Date\DateConverterInterface;
use App\Domain\Model\Expenditure\ExpenditureRepositoryInterface;
use App\Application\UseCase\Category\Expenditure\Fetch\FetchExpenditureCategoryUseCase;

final readonly class ImportExpendtureCsvUseCase 
{
    private const ITEM_LINE = 1;
    private const NAME_COLUMN = 1;
    private const AMOUNT_COLUMN = 2;
    private const CATEGORY_COLUMN = 3;

    private ExpenditureRepositoryInterface $repository;
    private DateConverterInterface $dateConverter;
    private FetchExpenditureCategoryUseCase $fetchExpenditureCategoryUseCase;

    public function __construct(
        ExpenditureRepositoryInterface $repository,
        DateConverterInterface $dateConverter,
        FetchExpenditureCategoryUseCase $fetchExpenditureCategoryUseCase
    )
    {
        $this->repository = $repository;
        $this->dateConverter = $dateConverter;
        $this->fetchExpenditureCategoryUseCase = $fetchExpenditureCategoryUseCase;
    }

    /**
     * @param string $file_path
     * @return void
     */
    public function handle(string $file_path): void
    {
        $file = new \SplFileObject($file_path);

        $file->setFlags(
            \SplFileObject::READ_CSV |
            \SplFileObject::READ_AHEAD |
            \SplFileObject::SKIP_EMPTY |
            \SplFileObject::DROP_NEW_LINE
        );

        $targetLineList = new \LimitIterator($file, self::ITEM_LINE);

        $categoryInfoList = $this->fetchExpenditureCategoryUseCase->handle();

        $category_name_to_id_map_list = array_column($categoryInfoList, 'id', 'name');

        $expenditureHolder = new ExpenditureHolder();

        foreach ($targetLineList as $line) {

            $line = array_map(function($value) {
                return mb_convert_encoding($value, 'UTF-8', 'SJIS-win'); // ここでエンコーディングを変換
            }, $line);

            $date = $this->dateConverter->toYearMonthDay($line[0]);

            $expenditureHolder->appendExpenditure(
                Expenditure::create(
                    $line[self::NAME_COLUMN],
                    $category_name_to_id_map_list[$line[self::CATEGORY_COLUMN]] ?? 0,
                    (int)$line[self::AMOUNT_COLUMN],
                    $date
                )
            );
        }
        $this->repository->saveBulk($expenditureHolder);
    }
}