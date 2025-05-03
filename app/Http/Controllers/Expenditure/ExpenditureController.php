<?php

declare(strict_types=1);

namespace App\Http\Controllers\Expenditure;

use DateTime;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ExpenditureCategory;
use App\Http\Controllers\Controller;
use App\Models\Expenditure as ExpenditureModel;
use App\Infrastructure\Adaptor\Date\DateConverter;
use App\Infrastructure\Query\Expenditure\ExpenditureQueryService;
use App\Application\UseCase\CSV\Import\ImportExpendtureCsvUseCase;
use App\Infrastructure\Adaptor\Calculation\CategoryAmountCalculater;
use App\Infrastructure\Repository\Expenditure\ExpenditureRepository;
use App\Application\UseCase\Expenditure\Fetch\FetchExpenditureUseCase;
use App\Application\UseCase\Expenditure\Create\CreateExpenditureUseCase;
use App\Application\UseCase\Expenditure\Delete\DeleteExpenditureUseCase;
use App\Application\UseCase\Expenditure\Update\UpdateExpenditureUseCase;
use App\Application\UseCase\CSV\Export\ExportSampleExpenditureCsvUseCase;
use App\Application\UseCase\CSV\Export\ExportExpenditureCsvUseCase;
use App\Application\UseCase\Expenditure\Create\CreateExpenditureInputData;
use App\Application\UseCase\Expenditure\Delete\DeleteExpenditureInputData;
use App\Application\UseCase\Expenditure\Update\UpdateExpenditureInputData;
use App\Application\UseCase\Category\Expenditure\Fetch\FetchExpenditureCategoryUseCase;
use App\Application\UseCase\Expenditure\Create\BulkCreateExpenditureInputData;
use App\Application\UseCase\Expenditure\Create\BulkCreateExpenditureUseCase;
use App\Infrastructure\Repository\PresetExpenditureItem\PresetExpenditureItemRepository;
use App\Models\PresetExpenditureItem;
use App\Infrastructure\Util\CsvExporter;

class ExpenditureController extends Controller
{
    public function index()
    {
        $fetchExpenditureUseCase = new FetchExpenditureUseCase(
            new ExpenditureQueryService(
                new ExpenditureModel()
            )
        );

        $expenditureInfoList = $fetchExpenditureUseCase->handle();

        $fetchExpenditureCategoryUseCase = new FetchExpenditureCategoryUseCase(
            new ExpenditureCategory()
        );

        $expenditureCategoryInfoList = $fetchExpenditureCategoryUseCase->handle();

        return Inertia::render('Expenditure/Index',
            [
                'expenditure_info_list' => $expenditureInfoList,
                'expenditure_category_info_list' => $expenditureCategoryInfoList
            ]
        );
    }

    public function get()
    {
        $fetchExpenditureUseCase = new FetchExpenditureUseCase(
            new ExpenditureQueryService(
                new ExpenditureModel()
            )
        );

        $expenditureInfoList = $fetchExpenditureUseCase->handle();

        return [
            'expenditure_info_list' => $expenditureInfoList
        ];
    }

    public function fetchByPeriod(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $expenditureQueryService = new ExpenditureQueryService(
            new ExpenditureModel()
        );

        $oneTimeExpenditureInfoList = $expenditureQueryService->fetchOneTimeExpenditure($startDate, $endDate);
        
        $fixedExpenditureInfoList = $expenditureQueryService->fetchFixedExpenditure();

        $targetFixedExpenditureInfoList = [];
        foreach ($fixedExpenditureInfoList as $fixedExpenditure) {
            $expenditureStartDate = new DateTime($fixedExpenditure['start_date']);
            $expenditureEndDate = $fixedExpenditure['end_date'] ? new DateTime($fixedExpenditure['end_date']) : null;
            
            $requestStartDate = new DateTime($startDate);
            $requestEndDate = new DateTime($endDate);

            if ($expenditureEndDate && $expenditureEndDate < $requestStartDate) {
                continue;
            }

            if ($expenditureStartDate > $requestEndDate) {
                continue;
            }

            $currentDate = clone $requestStartDate;
            while ($currentDate <= $requestEndDate) {
                $paymentDate = clone $currentDate;
                $paymentDate->setDate(
                    (int)$currentDate->format('Y'),
                    (int)$currentDate->format('m'),
                    (int)$fixedExpenditure['payment_day']
                );

                $isAfterStartDate = !$expenditureStartDate || $paymentDate >= $expenditureStartDate;
                $isBeforeEndDate = !$expenditureEndDate || $paymentDate <= $expenditureEndDate;

                $isInPeriod = $isAfterStartDate && $isBeforeEndDate;

                if ($isInPeriod) {
                    $expenditureData = $fixedExpenditure;
                    $expenditureData['calendar_date'] = $paymentDate->format('Y-m-d');
                    $targetFixedExpenditureInfoList[] = $expenditureData;
                }

                $currentDate->modify('+1 month');
            }
        }

        $expenditureInfoList = array_merge($oneTimeExpenditureInfoList, $targetFixedExpenditureInfoList);

        $categoryAmountCalculater = new CategoryAmountCalculater(
            new DateConverter()
        );

        $categoryToAmountList = $categoryAmountCalculater->calculate($expenditureInfoList);

        $fixedExpenditureInfoList = $expenditureQueryService->fetchFixedExpenditure();

        return [
            'category_to_amount_list' => $categoryToAmountList
        ];
    }

    public function fetchByCategory()
    {
        $fetchExpenditureUseCase = new FetchExpenditureUseCase(
            new ExpenditureQueryService(
                new ExpenditureModel()
            )
        );

        $expenditureInfoList = $fetchExpenditureUseCase->handle();

        $categoryAmountCalculater = new CategoryAmountCalculater(
            new DateConverter()
        );

        $categoryToAmountList = $categoryAmountCalculater->calculate($expenditureInfoList);

        return [
            'category_to_amount_list' => $categoryToAmountList
        ];
    }

    public function create(Request $request)
    {
        $createExpenditureUseCase = new CreateExpenditureUseCase(
            new ExpenditureRepository(
                new ExpenditureModel()
            )
        );

        $createExpenditureUseCase->handle(
            new CreateExpenditureInputData(
                $request->expenditure_name,
                (int)$request->expenditure_category_id,
                (int)$request->expenditure_amount,
                (new DateTime($request->calendar_date))->format('Y-m-d')
            )
        );
    }

    public function update(Request $request, $id)
    {
        $updateExpenditureUseCase = new UpdateExpenditureUseCase(
            new ExpenditureRepository(
                new ExpenditureModel()
            )
        );

        $updateExpenditureUseCase->handle(
            new UpdateExpenditureInputData(
                (int)$id,
                $request->expenditure_name,
                (int)$request->expenditure_category_id,
                (int)$request->expenditure_amount,
                (new DateTime($request->calendar_date))->format('Y-m-d')
            )
        );
    }

    public function delete(Request $request)
    {
        $deleteExpenditureUseCase = new DeleteExpenditureUseCase(
            new ExpenditureRepository(
                new ExpenditureModel()
            )
        );

        $deleteExpenditureUseCase->handle(
            new DeleteExpenditureInputData(
                (int)$request->id,
                $request->name,
                (int)$request->amount
            )
        );
    }

    public function export()
    {
        $exportSampleExpenditureCsvUseCase = new ExportSampleExpenditureCsvUseCase();
        
        return $exportSampleExpenditureCsvUseCase->handle();
    }

    public function exportData(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $format = $request->input('format', 'detailed');
        
        $exportExpenditureCsvUseCase = new ExportExpenditureCsvUseCase(
            new ExpenditureQueryService(
                new ExpenditureModel()
            ),
            new CsvExporter()
        );
        
        $result = $exportExpenditureCsvUseCase->handle($startDate, $endDate, $format);
        
        $filename = 'expenditure.csv';
        if ($startDate && $endDate) {
            $filename = "expenditure_{$startDate}_{$endDate}.csv";
        }
        
        return (new CsvExporter())->export($result['header'], $result['data'], $filename);
    }

    public function import_csv(Request $request)
    {
        $file_path = $request->file('csv')->path();

        $importExpenditureCsvUseCase = new ImportExpendtureCsvUseCase(
            new DateConverter(),
            new FetchExpenditureCategoryUseCase(
                new ExpenditureCategory()
            )
        );

        $expenditureList = $importExpenditureCsvUseCase->handle($file_path);

        $result = [];

        $presetExpenditureItemModel = new PresetExpenditureItem();
        $presetExpenditureItemInfoList = $presetExpenditureItemModel->where('category_id', '!=', 0)->get()->toArray();

        $expenditureNameToCategoryIdMapList = array_column($presetExpenditureItemInfoList, 'category_id', 'name');

        foreach ($expenditureList as $expenditure) {
            $id = $expenditure->getId();
            $expenditureName = $expenditure->getName()->getValue();
            $categoryId = $expenditure->getCategoryId()->getValue();
            $amount = $expenditure->getAmount()->getValue();
            $date = $expenditure->getCalendarDate()->getValue();

            foreach ($expenditureNameToCategoryIdMapList as $presetName => $presetCategoryId) {
                if (str_contains($expenditureName, $presetName)) {
                    $categoryId = $presetCategoryId;
                    break;
                }
            }

            $result[] = [
                "id" => $id,
                "name" => $expenditureName,
                "category_id" => $categoryId,
                "amount" => $amount,
                "date" => $date
            ];
        }

        return [
            'uploadDataList' => json_encode($result)
        ];
    }

    public function bulkCreate(Request $request)
    {
        $bulkCreateExpenditureUseCase = new BulkCreateExpenditureUseCase(
            new ExpenditureRepository(
                new ExpenditureModel()
            ),
            new PresetExpenditureItemRepository(
                new PresetExpenditureItem()
            )
        );

        $bulkCreateExpenditureUseCase->handle(
            new BulkCreateExpenditureInputData(
                $request->items
            )
        );
    }
}
