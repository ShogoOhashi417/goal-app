<?php

declare(strict_types=1);

namespace App\Http\Controllers\Income;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Income AS IncomeModel;
use App\Infrastructure\Query\Income\IncomeQueryService;
use App\Infrastructure\Repository\Income\IncomeRepository;
use App\Application\UseCase\Income\Fetch\FetchIncomeUseCase;
use App\Application\UseCase\Income\Create\CreateIncomeUseCase;
use App\Application\UseCase\Income\Delete\DeleteIncomeUseCase;
use App\Application\UseCase\Income\Update\UpdateIncomeUseCase;
use App\Application\UseCase\Income\Create\CreateIncomeInputData;
use App\Application\UseCase\Income\Delete\DeleteIncomeInputData;
use App\Application\UseCase\Income\Update\UpdateIncomeInputData;

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
                $request->income_amount
            )
        );
    }

    public function update(Request $request)
    {
        $updateIncomeUseCase = new UpdateIncomeUseCase(
            new IncomeRepository(
                new IncomeModel()
            )
        );

        $updateIncomeUseCase->handle(
            new UpdateIncomeInputData(
                $request->id,
                $request->income_name,
                (int)$request->income_category_id,
                $request->income_amount
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
                $request->id,
            )
        );
    }
}
