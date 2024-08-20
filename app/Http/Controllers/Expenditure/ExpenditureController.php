<?php

declare(strict_types=1);

namespace App\Http\Controllers\Expenditure;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Expenditure AS ExpenditureModel;
use App\Infrastructure\Query\Expenditure\ExpenditureQueryService;
use App\Infrastructure\Repository\Expenditure\ExpenditureRepository;
use App\Application\UseCase\Expenditure\Fetch\FetchExpenditureUseCase;
use App\Application\UseCase\Expenditure\Create\CreateExpenditureUseCase;
use App\Application\UseCase\Expenditure\Create\CreateExpenditureInputData;

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

        return view('view.expenditure.index', [
            'expenditure_info_list' => $expenditureInfoList
        ]);
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
                $request->expenditure_amount
            )
        );
    }
}
