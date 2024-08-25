<?php

declare(strict_types=1);

namespace App\Http\Controllers\Expenditure;

use App\Models\Expenditure AS ExpenditureModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Infrastructure\Query\Expenditure\ExpenditureQueryService;
use App\Application\UseCase\Expenditure\Fetch\FetchExpenditureUseCase;

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
}
