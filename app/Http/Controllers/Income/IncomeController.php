<?php

declare(strict_types=1);

namespace App\Http\Controllers\Income;

use DateTime;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\IncomeCategory;
use App\Models\Income as IncomeModel;
use App\Http\Controllers\Controller;
use App\Infrastructure\Query\Income\IncomeQueryService;
use App\Infrastructure\Repository\Income\IncomeRepository;
use App\Application\UseCase\Income\Fetch\FetchIncomeUseCase;
use App\Application\UseCase\Income\Create\CreateIncomeUseCase;
use App\Application\UseCase\Income\Delete\DeleteIncomeUseCase;
use App\Application\UseCase\Income\Update\UpdateIncomeUseCase;
use App\Application\UseCase\Income\Create\CreateIncomeInputData;
use App\Application\UseCase\Income\Delete\DeleteIncomeInputData;
use App\Application\UseCase\Income\Update\UpdateIncomeInputData;
use App\Application\UseCase\Category\Income\Fetch\FetchIncomeCategoryUseCase;

class IncomeController extends Controller
{
    public function index()
    {
        $fetchIncomeUseCase = new FetchIncomeUseCase(
            new IncomeQueryService(
                new IncomeModel()
            )
        );

        $incomeInfoList = $fetchIncomeUseCase->handle();

        $fetchIncomeCategoryUseCase = new FetchIncomeCategoryUseCase(
            new IncomeCategory()
        );

        $incomeCategoryInfoList = $fetchIncomeCategoryUseCase->handle();
        
        return Inertia::render('Income/Index',
            [
                'incomeDataList' => $incomeInfoList,
                'IncomeCategoryDataList' => $incomeCategoryInfoList
            ]
        );
    }

    public function get()
    {
        $fetchIncomeUseCase = new FetchIncomeUseCase(
            new IncomeQueryService(
                new IncomeModel()
            )
        );

        $incomeInfoList = $fetchIncomeUseCase->handle();

        return [
            'income_info_list' => $incomeInfoList
        ];
    }

    public function create(Request $request)
    {
        $createIncomeUseCase = new CreateIncomeUseCase(
            new IncomeRepository(
                new IncomeModel()
            )
        );

        $createIncomeUseCase->handle(
            new CreateIncomeInputData(
                $request->income_name,
                (int)$request->income_category_id,
                $request->income_amount,
                (new DateTime($request->calendar_date))->format('Y-m-d')
            )
        );
    }

    public function update(Request $request, $id)
    {
        $updateIncomeUseCase = new UpdateIncomeUseCase(
            new IncomeRepository(
                new IncomeModel()
            )
        );

        $updateIncomeUseCase->handle(
            new UpdateIncomeInputData(
                (int)$id,
                $request->income_name,
                (int)$request->income_category_id,
                (int)$request->income_amount,
                (new DateTime($request->calendar_date))->format('Y-m-d')
            )
        );
    }

    public function delete(Request $request)
    {
        $deleteIncomeUseCase = new DeleteIncomeUseCase(
            new IncomeRepository(
                new IncomeModel()
            )
        );

        $deleteIncomeUseCase->handle(
            new DeleteIncomeInputData(
                (int)$request->id,
            )
        );
    }
}
