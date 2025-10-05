<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExpenditureCategory;
use App\Application\Service\AuthService;
use App\Infrastructure\Repository\Category\Expenditure\ExpenditureCategoryRepository;
use App\Application\UseCase\Category\Expenditure\Fetch\FetchExpenditureCategoryUseCase;
use App\Application\UseCase\Category\Expenditure\Create\CreateExpenditureCategoryUseCase;
use App\Application\UseCase\Category\Expenditure\Delete\DeleteExpenditureCategoryUseCase;
use App\Application\UseCase\Category\Expenditure\Update\UpdateExpenditureCategoryUseCase;
use App\Application\UseCase\Category\Expenditure\Create\CreateExpenditureCategoryInputData;
use App\Application\UseCase\Category\Expenditure\Delete\DeleteExpenditureCategoryInputData;
use App\Application\UseCase\Category\Expenditure\Update\UpdateExpenditureCategoryInputData;

class ExpenditureCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function get()
    {
        $expenditureCategoryInfoList = $this->fetchExpenditureCategories();

        return [
            "expenditure_category_info_list" => $expenditureCategoryInfoList
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
        $createExpenditureCategoryUseCase = new CreateExpenditureCategoryUseCase(
            new ExpenditureCategoryRepository(
                new ExpenditureCategory()
            )
        );

        $createdCategory = $createExpenditureCategoryUseCase->handle(
            new CreateExpenditureCategoryInputData(
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
    public function update(Request $request, $id)
    {
        $inputData = new UpdateExpenditureCategoryInputData(
            id: $id,
            name: $request->name,
            userId: $request->user()->id
        );

        $updateExpenditureCategoryUseCase = new UpdateExpenditureCategoryUseCase(
            new ExpenditureCategoryRepository(
                new ExpenditureCategory()
            )
        );

        $updatedCategory = $updateExpenditureCategoryUseCase->handle($inputData);

        return [
            'categoryData' => $updatedCategory
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request)
    {
        $deleteExpenditureCategoryUseCase = new DeleteExpenditureCategoryUseCase(
            new ExpenditureCategoryRepository(
                new ExpenditureCategory()
            )
        );

        $deleteExpenditureCategoryUseCase->handle(
            new DeleteExpenditureCategoryInputData(
                (int)$request->id,
                $request->user()->id
            )
        );

        $expenditureCategoryInfoList = $this->fetchExpenditureCategories();

        return [
            'expenditure_category_info_list' => $expenditureCategoryInfoList
        ];
    }

    /**
     * Fetch expenditure categories
     * 
     * @return array
     */
    private function fetchExpenditureCategories(): array
    {
        $fetchExpenditureCategoryUseCase = new FetchExpenditureCategoryUseCase(
            new ExpenditureCategory(),
            new AuthService()
        );

        return $fetchExpenditureCategoryUseCase->handle();
    }
}
