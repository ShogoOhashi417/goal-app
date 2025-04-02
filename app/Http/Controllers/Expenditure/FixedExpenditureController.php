<?php

declare(strict_types=1);

namespace App\Http\Controllers\Expenditure;

use DateTime;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FixedExpenditure as FixedExpenditureModel;
use App\Models\Expenditure as ExpenditureModel;
use App\Models\ExpenditureCategory;
use App\Infrastructure\Repository\FixedExpenditure\FixedExpenditureRepository;
use App\Infrastructure\Repository\Expenditure\ExpenditureRepository;
use App\Application\UseCase\FixedExpenditure\Create\CreateFixedExpenditureUseCase;
use App\Application\UseCase\FixedExpenditure\Create\CreateFixedExpenditureInputData;
use App\Infrastructure\Query\Expenditure\ExpenditureQueryService;
use App\Application\UseCase\Expenditure\Fetch\FetchExpenditureUseCase;
use App\Application\UseCase\Category\Expenditure\Fetch\FetchExpenditureCategoryUseCase;

class FixedExpenditureController extends Controller
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

        return Inertia::render('Expenditure/Fixed',
            [
                'expenditure_info_list' => $expenditureInfoList,
                'expenditure_category_info_list' => $expenditureCategoryInfoList
            ]
        );
    }

    public function create(Request $request)
    {
        $createFixedExpenditureUseCase = new CreateFixedExpenditureUseCase(
            new FixedExpenditureRepository(
                new FixedExpenditureModel()
            ),
            new ExpenditureRepository(
                new ExpenditureModel()
            )
        );

        $createFixedExpenditureUseCase->handle(
            new CreateFixedExpenditureInputData(
                $request->name,
                (int)$request->category_id,
                (int)$request->amount,
                $request->cycle_unit,
                (int)$request->payment_day,
                $request->payment_month ? (int)$request->payment_month : null,
                (new DateTime($request->start_date))->format('Y-m-d'),
                $request->end_date ? (new DateTime($request->end_date))->format('Y-m-d') : null,
            )
        );
    }
} 