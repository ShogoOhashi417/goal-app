<?php

namespace App\Http\Controllers\IncomeCategory;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\IncomeCategory;
use App\Models\ExpenditureCategory;
use App\Http\Controllers\Controller;
use App\Application\Service\AuthService;
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
        $incomeCategoryInfoList = $this->fetchIncomeCategories();

        $fetchExpenditureCategoryUseCase = new FetchExpenditureCategoryUseCase(
            new ExpenditureCategory(),
            new AuthService()
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
        $incomeCategoryInfoList = $this->fetchIncomeCategories();

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

        $createdCategory = $createIncomeCategoryUseCase->handle(
            new CreateIncomeCategoryInputData(
                $request->name,
                $request->user()->id
            )
        );

        return [
            'categoryData' => $createdCategory
        ];
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
            id: (int)$id,
            name: $request->name,
            userId: $request->user()->id
        );

        $updateIncomeCategoryUseCase = new UpdateIncomeCategoryUseCase(
            new IncomeCategoryRepository(
                new IncomeCategory()
            )
        );

        $updatedCategory = $updateIncomeCategoryUseCase->handle($inputData);

        return [
            'categoryData' => $updatedCategory
        ];
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
                (int)$request->id,
                $request->user()->id
            )
        );

        $incomeCategoryInfoList = $this->fetchIncomeCategories();

        return [
            'income_category_info_list' => $incomeCategoryInfoList
        ];
    }

    /**
     * Fetch income categories
     * 
     * @return array
     */
    private function fetchIncomeCategories(): array
    {
        $fetchIncomeCategoryUseCase = new FetchIncomeCategoryUseCase(
            new IncomeCategory(),
            new AuthService()
        );

        return $fetchIncomeCategoryUseCase->handle();
    }
}
