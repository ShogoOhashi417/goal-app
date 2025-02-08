<?php

namespace App\Application\UseCase\CSV\Import;

use App\Domain\Model\Expenditure\Expenditure;
use App\Domain\Model\Expenditure\ExpenditureHolder;
use App\Application\Port\Date\DateConverterInterface;
use App\Domain\Model\Expenditure\ExpenditureRepositoryInterface;
use App\Application\UseCase\Category\Expenditure\Fetch\FetchExpenditureCategoryUseCase;
use App\Models\PresetExpenditureItem;

final readonly class ImportExpendtureCsvUseCase 
{
    private const ITEM_LINE = 1;
    private const NAME_COLUMN = 1;
    private const AMOUNT_COLUMN = 2;
    private const CATEGORY_COLUMN = 3;

    private DateConverterInterface $dateConverter;
    private FetchExpenditureCategoryUseCase $fetchExpenditureCategoryUseCase;

    public function __construct(
        DateConverterInterface $dateConverter,
        FetchExpenditureCategoryUseCase $fetchExpenditureCategoryUseCase
    )
    {
        $this->dateConverter = $dateConverter;
        $this->fetchExpenditureCategoryUseCase = $fetchExpenditureCategoryUseCase;
    }

    /**
     * @param string $file_path
     * @return 
     */
    public function handle(string $file_path)
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

        $presetExpenditureItemModel = new PresetExpenditureItem();
        $presetExpenditureItemInfoList = $presetExpenditureItemModel->where('category_id', '!=', 0)->get()->toArray();

        $expenditureNameToCategoryIdMapList = array_column($presetExpenditureItemInfoList, 'category_id', 'name');

        foreach ($targetLineList as $line) {

            $line = array_map(function($value) {
                return mb_convert_encoding($value, 'UTF-8', 'SJIS-win'); // ここでエンコーディングを変換
            }, $line);

            $date = $this->dateConverter->toYearMonthDay($line[0]);
            
            $name = $line[self::NAME_COLUMN];

            $categoryId = $category_name_to_id_map_list[$line[self::CATEGORY_COLUMN]] ?? 0;
            $amount = (int)$line[self::AMOUNT_COLUMN];

            foreach ($expenditureNameToCategoryIdMapList as $presetName => $presetCategoryId) {
                if (str_contains($name, $presetName)) {
                    $categoryId = $presetCategoryId;
                }
            }

            $expenditureHolder->appendExpenditure(
                Expenditure::create(
                    $name,
                    $categoryId,
                    $amount,
                    $date
                )
            );
        }

        return $expenditureHolder->getExpenditureList();
    }
}