<?php

declare(strict_types=1);

namespace App\Http\Controllers\Income;

use App\Models\Income AS IncomeModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Infrastructure\Query\Income\IncomeQueryService;
use App\Application\UseCase\Income\Fetch\FetchIncomeUseCase;

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
}
