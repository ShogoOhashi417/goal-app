<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExpenditureCategory;
use App\Infrastructure\Repository\Category\Expenditure\ExpenditureCategoryRepository;
use App\Application\UseCase\Category\Expenditure\Fetch\FetchExpenditureCategoryUseCase;
use App\Application\UseCase\Category\Expenditure\Create\CreateExpenditureCategoryUseCase;
use App\Application\UseCase\Category\Expenditure\Create\CreateExpenditureCategoryInputData;

class ExpenditureCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function get()
    {
        $fetchExpenditureCategoryUseCase = new FetchExpenditureCategoryUseCase(
            new ExpenditureCategory()
        );

        $expenditureCategoryInfoList = $fetchExpenditureCategoryUseCase->handle();

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

        $createExpenditureCategoryUseCase->handle(
            new CreateExpenditureCategoryInputData(
                $request->expenditureCategoryName
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
