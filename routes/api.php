<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Income\IncomeController;
use App\Http\Controllers\Expenditure\ExpenditureController;
use App\Http\Controllers\IncomeCategory\IncomeCategoryController;
use App\Http\Controllers\ExpenditureCategoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')
    ->name('v1.')
    ->group(function () {
        Route::get('/csrf-token', function () {
            return response()->json(['token' => csrf_token()]);
        });
        
        Route::get('/income', [IncomeController::class, 'get']);
        Route::post('/income', [IncomeController::class, 'create']);
        Route::put('/income/{id}', [IncomeController::class, 'update']);
        Route::delete('/income/{id}', [IncomeController::class, 'delete']);

        Route::get('/expenditure', [ExpenditureController::class, 'get']);
        Route::post('/expenditure', [ExpenditureController::class, 'create']);
        Route::put('/expenditure/{id}', [ExpenditureController::class, 'update']);
        Route::delete('/expenditure/{id}', [ExpenditureController::class, 'delete']);

        Route::get('/income_category', [IncomeCategoryController::class, 'get']);
        Route::post('/income_category', [IncomeCategoryController::class, 'store']);
        Route::delete('/income_category/{id}', [IncomeCategoryController::class, 'delete']);

        Route::get('/expenditure_category', [ExpenditureCategoryController::class, 'get']);
        Route::post('/expenditure_category', [ExpenditureCategoryController::class, 'store']);
        Route::put('/expenditure_category/{id}', [ExpenditureCategoryController::class, 'update']);
        Route::delete('/expenditure_category/{id}', [ExpenditureCategoryController::class, 'delete']);
    });
