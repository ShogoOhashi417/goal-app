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
use App\Application\UseCase\Expenditure\Create\CreateExpenditureInputData;
use App\Application\UseCase\Expenditure\Delete\DeleteExpenditureInputData;
use App\Application\UseCase\Expenditure\Update\UpdateExpenditureInputData;
use App\Application\UseCase\Category\Expenditure\Fetch\FetchExpenditureCategoryUseCase;

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
                $request->expenditure_amount,
                (new DateTime($request->calendar_date))->format('Y-m-d')
            )
        );
    }

    public function update(Request $request)
    {
        $updateExpenditureUseCase = new UpdateExpenditureUseCase(
            new ExpenditureRepository(
                new ExpenditureModel()
            )
        );

        $updateExpenditureUseCase->handle(
            new UpdateExpenditureInputData(
                (int)$request->id,
                $request->expenditure_name,
                (int)$request->expenditure_category_id,
                $request->expenditure_amount,
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
                $request->id,
                $request->name,
                $request->amount
            )
        );
    }

    public function export()
    {
        $exportSampleExpenditureCsvUseCase = new ExportSampleExpenditureCsvUseCase();
        
        return $exportSampleExpenditureCsvUseCase->handle();
    }

    public function import_csv(Request $request)
    {
        $file_path = $request->file('csv')->path();

        $importExpenditureCsvUseCase = new ImportExpendtureCsvUseCase(
            new ExpenditureRepository(
                new ExpenditureModel()
            ),
            new DateConverter(),
            new FetchExpenditureCategoryUseCase(
                new ExpenditureCategory()
            )
        );

        $importExpenditureCsvUseCase->handle($file_path);
    }
}
