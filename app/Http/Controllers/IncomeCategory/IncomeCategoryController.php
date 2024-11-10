<?php

namespace App\Http\Controllers\IncomeCategory;

use App\Application\UseCase\Category\Income\Create\CreateIncomeCategoryInputData;
use App\Application\UseCase\Category\Income\Create\CreateIncomeCategoryUseCase;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Infrastructure\Repository\Category\Income\IncomeCategoryRepository;
use App\Models\IncomeCategory;

class IncomeCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
