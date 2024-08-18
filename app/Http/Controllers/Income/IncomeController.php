<?php

declare(strict_types=1);

namespace App\Http\Controllers\Income;

use App\Application\UseCase\Income\Create\CreateIncomeInputData;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Income AS IncomeModel;
use App\Infrastructure\Query\Income\IncomeQueryService;
use App\Infrastructure\Repository\Income\IncomeRepository;
use App\Application\UseCase\Income\Fetch\FetchIncomeUseCase;
use App\Application\UseCase\Income\Create\CreateIncomeUseCase;

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

        return view('view.income.index', [
            'income_info_list' => $incomeInfoList
        ]);
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
                $request->income_amount
            )
        );
    }
}
