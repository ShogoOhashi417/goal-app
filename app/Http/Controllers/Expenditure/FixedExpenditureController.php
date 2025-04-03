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
use App\Infrastructure\Query\FixedExpenditure\FixedExpenditureQueryService;
use App\Application\UseCase\FixedExpenditure\Fetch\FetchFixedExpenditureUseCase;
use App\Application\UseCase\Category\Expenditure\Fetch\FetchExpenditureCategoryUseCase;

class FixedExpenditureController extends Controller
{
    public function index()
    {
        $fixedExpenditureInfoList = $this->fetchFixedExpenditureInfoList();
        $expenditureCategoryInfoList = $this->fetchExpenditureCategoryInfoList();

        return Inertia::render('Expenditure/Fixed',
            [
                'expenditure_info_list' => $fixedExpenditureInfoList,
                'expenditure_category_info_list' => $expenditureCategoryInfoList
            ]
        );
    }

	public function get(Request $request)
	{
        $fixedExpenditureInfoList = $this->fetchFixedExpenditureInfoList();
        $expenditureCategoryInfoList = $this->fetchExpenditureCategoryInfoList();

		return [
			'expenditure_info_list' => $fixedExpenditureInfoList,
			'expenditure_category_info_list' => $expenditureCategoryInfoList
		];
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

	private function fetchFixedExpenditureInfoList()
	{
		$fetchFixedExpenditureUseCase = new FetchFixedExpenditureUseCase(
			new FixedExpenditureQueryService(
				new FixedExpenditureModel()
			)
		);

		return $fetchFixedExpenditureUseCase->handle();
	}

	private function fetchExpenditureCategoryInfoList()
	{
		$fetchExpenditureCategoryUseCase = new FetchExpenditureCategoryUseCase(
			new ExpenditureCategory()
		);

		return $fetchExpenditureCategoryUseCase->handle();
	}
} 