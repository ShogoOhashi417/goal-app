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
use App\Application\UseCase\Expenditure\Delete\DeleteExpenditureUseCase;
use App\Application\UseCase\Expenditure\Update\UpdateExpenditureUseCase;
use App\Application\UseCase\Expenditure\Create\CreateExpenditureInputData;
use App\Application\UseCase\Expenditure\Delete\DeleteExpenditureInputData;
use App\Application\UseCase\Expenditure\Update\UpdateExpenditureInputData;

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
                (int)$request->expenditure_category_id,
                $request->expenditure_amount
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
                $request->id,
                $request->expenditure_name,
                (int)$request->expenditure_category_id,
                $request->expenditure_amount
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
}
