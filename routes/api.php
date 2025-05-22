<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Income\IncomeController;
use App\Http\Controllers\ExpenditureCategoryController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Expenditure\ExpenditureController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\IncomeCategory\IncomeCategoryController;

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

Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/forgot-password', [PasswordResetLinkController::class, 'store']);

Route::prefix('v1')
    ->name('v1.')
    ->group(function () {
        Route::get('/csrf-token', function () {
            return response()->json(['token' => csrf_token()]);
        });
        
        Route::get('/incomes', [IncomeController::class, 'get']);
        Route::post('/incomes/add', [IncomeController::class, 'create']);
        Route::put('/incomes/update/{id}', [IncomeController::class, 'update']);
        Route::delete('/incomes/{id}', [IncomeController::class, 'delete']);

        Route::get('/expenditures', [ExpenditureController::class, 'get']);
        Route::post('/expenditures', [ExpenditureController::class, 'create']);
        Route::put('/expenditures/update/{id}', [ExpenditureController::class, 'update']);
        Route::delete('/expenditures/{id}', [ExpenditureController::class, 'delete']);

        Route::get('/income-categories', [IncomeCategoryController::class, 'get']);
        Route::post('/income-categories', [IncomeCategoryController::class, 'store']);
        Route::put('/income-categories/{id}', [IncomeCategoryController::class, 'update']);
        Route::delete('/income-categories/{id}', [IncomeCategoryController::class, 'delete']);

        Route::get('/expenditure-categories', [ExpenditureCategoryController::class, 'get']);
        Route::post('/expenditure-categories', [ExpenditureCategoryController::class, 'store']);
        Route::put('/expenditure-categories/{id}', [ExpenditureCategoryController::class, 'update']);
        Route::delete('/expenditure-categories/{id}', [ExpenditureCategoryController::class, 'delete']);
    });
