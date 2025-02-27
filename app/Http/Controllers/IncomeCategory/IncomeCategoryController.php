<?php

namespace App\Http\Controllers\IncomeCategory;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\IncomeCategory;
use App\Models\ExpenditureCategory;
use App\Http\Controllers\Controller;
use App\Infrastructure\Repository\Category\Income\IncomeCategoryRepository;
use App\Application\UseCase\Category\Income\Fetch\FetchIncomeCategoryUseCase;
use App\Application\UseCase\Category\Income\Create\CreateIncomeCategoryUseCase;
use App\Application\UseCase\Category\Income\Delete\DeleteIncomeCategoryUseCase;
use App\Application\UseCase\Category\Income\Update\UpdateIncomeCategoryUseCase;
use App\Application\UseCase\Category\Income\Create\CreateIncomeCategoryInputData;
use App\Application\UseCase\Category\Income\Delete\DeleteIncomeCategoryInputData;
use App\Application\UseCase\Category\Income\Update\UpdateIncomeCategoryInputData;
use App\Application\UseCase\Category\Expenditure\Fetch\FetchExpenditureCategoryUseCase;

class IncomeCategoryController extends Controller
{
    public function index()
    {
        $fetchIncomeCategoryUseCase = new FetchIncomeCategoryUseCase(
            new IncomeCategory()
        );

        $incomeCategoryInfoList = $fetchIncomeCategoryUseCase->handle();

        $fetchExpenditureCategoryUseCase = new FetchExpenditureCategoryUseCase(
            new ExpenditureCategory()
        );

        $expenditureCategoryInfoList = $fetchExpenditureCategoryUseCase->handle();

        return Inertia::render('Category/Index',
            [
                'incomeCategoryDataList' => $incomeCategoryInfoList,
                'expenditureCategoryDataList' => $expenditureCategoryInfoList
            ]
        );
    }
    /**
     * Display a listing of the resource.
     */
    public function get()
    {
        $fetchIncomeCategoryUseCase = new FetchIncomeCategoryUseCase(
            new IncomeCategory()
        );

        $incomeCategoryInfoList = $fetchIncomeCategoryUseCase->handle();

        return [
            'income_category_info_list' => $incomeCategoryInfoList
        ];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $createIncomeCategoryUseCase = new CreateIncomeCategoryUseCase(
            new IncomeCategoryRepository(
                new IncomeCategory()
            )
        );

        $createIncomeCategoryUseCase->handle(
            new CreateIncomeCategoryInputData(
                $request->incomeCategoryName
            )
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $inputData = new UpdateIncomeCategoryInputData(
            id: $id,
            name: $request->incomeCategoryName
        );

        $updateIncomeCategoryUseCase = new UpdateIncomeCategoryUseCase(
            new IncomeCategoryRepository(
                new IncomeCategory()
            )
        );

        $updateIncomeCategoryUseCase->handle($inputData);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request)
    {
        $deleteIncomeCategoryUseCase = new DeleteIncomeCategoryUseCase(
            new IncomeCategoryRepository(
                new IncomeCategory()
            )
        );

        $deleteIncomeCategoryUseCase->handle(
            new DeleteIncomeCategoryInputData(
                (int)$request->id
            )
        );
    }
}
